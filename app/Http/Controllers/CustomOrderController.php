<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use App\Models\CustomOrderMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomOrder::with('customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => CustomOrder::count(),
            'pending' => CustomOrder::where('status', 'pending')->count(),
            'in_progress' => CustomOrder::where('status', 'in_progress')->count(),
            'completed' => CustomOrder::where('status', 'completed')->count(),
        ];

        return view('custom-orders.index', compact('orders', 'stats'));
    }

    public function show(CustomOrder $customOrder)
    {
        $customOrder->load(['customer', 'messages', 'milestones']);

        return view('custom-orders.show', compact('customOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'project_type' => 'required|in:android,desktop,web,other',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'budget_range' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('custom-orders', 'public');
            }
        }

        $validated['attachments'] = $attachmentPaths;
        $validated['status'] = 'pending';

        $order = CustomOrder::create($validated);

        return redirect()->route('custom-orders.show', $order)->with('success', 'Permintaan custom order berhasil dibuat!');
    }

    public function update(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:pending,reviewed,quoted,accepted,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string',
            'quoted_price' => 'nullable|numeric|min:0',
        ]);

        if (isset($validated['quoted_price']) && $validated['quoted_price'] > 0 && ! $customOrder->quoted_at) {
            $validated['quoted_at'] = now();
            $validated['status'] = 'quoted';
        }

        if (isset($validated['status'])) {
            if ($validated['status'] === 'accepted' && ! $customOrder->accepted_at) {
                $validated['accepted_at'] = now();
            }
            if ($validated['status'] === 'completed' && ! $customOrder->completed_at) {
                $validated['completed_at'] = now();
            }
        }

        $customOrder->update($validated);

        return back()->with('success', 'Custom order berhasil diperbarui!');
    }

    public function sendMessage(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('messages', 'public');
            }
        }

        $customOrder->messages()->create([
            'sender_type' => 'admin',
            'sender_id' => Auth::id(),
            'message' => $validated['message'],
            'attachments' => $attachmentPaths,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function storeMilestone(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'percentage' => 'required|integer|min:0|max:100',
        ]);

        $validated['sort_order'] = $customOrder->milestones()->max('sort_order') + 1;
        $validated['is_completed'] = false;

        $customOrder->milestones()->create($validated);

        return back()->with('success', 'Milestone berhasil ditambahkan!');
    }

    public function updateMilestone(Request $request, CustomOrderMilestone $milestone)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'percentage' => 'required|integer|min:0|max:100',
            'is_completed' => 'boolean',
        ]);

        $validated['is_completed'] = $request->boolean('is_completed');
        if ($validated['is_completed'] && ! $milestone->completed_at) {
            $validated['completed_at'] = now();
        } elseif (! $validated['is_completed']) {
            $validated['completed_at'] = null;
        }

        $milestone->update($validated);

        return back()->with('success', 'Milestone berhasil diperbarui!');
    }

    public function destroyMilestone(CustomOrderMilestone $milestone)
    {
        $milestone->delete();

        return back()->with('success', 'Milestone berhasil dihapus!');
    }

    public function destroy(CustomOrder $customOrder)
    {
        if (in_array($customOrder->status, ['in_progress', 'completed'])) {
            return back()->with('error', 'Custom order yang sedang berjalan atau selesai tidak dapat dihapus!');
        }

        if ($customOrder->attachments) {
            foreach ($customOrder->attachments as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $customOrder->messages()->delete();
        $customOrder->milestones()->delete();
        $customOrder->delete();

        return redirect()->route('custom-orders.index')->with('success', 'Custom order berhasil dihapus!');
    }
}
