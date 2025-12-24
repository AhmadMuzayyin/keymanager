<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('licenses')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Gagal menambahkan customer.'])->withInput();
        }
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Gagal mengupdate customer.'])->withInput();
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            DB::beginTransaction();
            $customer->delete();
            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Gagal menghapus customer.']);
        }
    }

    public function show(Customer $customer)
    {
        $customer->load('licenses');
        
        return view('customer.show', compact('customer'));
    }
}
