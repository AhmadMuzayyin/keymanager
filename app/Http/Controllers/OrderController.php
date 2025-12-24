<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items.product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::whereIn('status', ['paid', 'completed'])->count(),
            'revenue' => Order::whereIn('status', ['paid', 'completed'])->sum('total'),
        ];

        return view('orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product', 'items.productPrice']);
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::with('prices')->where('is_active', true)->orderBy('name')->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_price_id' => 'required|exists:product_prices,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
            'status' => 'nullable|in:pending,paid,completed,cancelled',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $price = \App\Models\ProductPrice::find($item['product_price_id']);
                $subtotal = $price->price * $item['quantity'];
                $total += $subtotal;

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'product_price_id' => $item['product_price_id'],
                    'price_name' => $price->name,
                    'price' => $price->price,
                    'quantity' => $item['quantity'],
                ];
            }

            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'total' => $total,
                'payment_method' => $validated['payment_method'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['status'] ?? 'pending',
                'paid_at' => in_array($validated['status'] ?? '', ['paid', 'completed']) ? now() : null,
            ]);

            foreach ($itemsData as $item) {
                $order->items()->create($item);
            }

            DB::commit();
            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->status = $validated['status'];

        if (in_array($validated['status'], ['paid', 'completed']) && !$order->paid_at) {
            $order->paid_at = now();

            if ($validated['status'] === 'paid' && $oldStatus !== 'paid') {
                $this->generateLicensesForOrder($order);
            }
        }

        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    protected function generateLicensesForOrder(Order $order)
    {
        foreach ($order->items as $item) {
            for ($i = 0; $i < $item->quantity; $i++) {
                License::create([
                    'customer_id' => $order->customer_id,
                    'license_key' => strtoupper(bin2hex(random_bytes(16))),
                    'purchase_code' => 'PC-' . strtoupper(bin2hex(random_bytes(8))),
                    'product_name' => $item->product->name ?? 'Unknown Product',
                    'type' => $item->product->type ?? 'unknown',
                    'is_active' => true,
                ]);
            }
        }
    }

    public function destroy(Order $order)
    {
        if ($order->status === 'paid' || $order->status === 'completed') {
            return back()->with('error', 'Pesanan yang sudah dibayar tidak dapat dihapus!');
        }

        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
