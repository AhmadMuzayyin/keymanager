@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center text-slate-600 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                <h2 class="text-2xl font-bold text-slate-800">{{ $order->order_number }}</h2>
            </div>
            <div class="flex gap-2">
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-700',
                        'paid' => 'bg-emerald-100 text-emerald-700',
                        'completed' => 'bg-blue-100 text-blue-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <span
                    class="px-4 py-2 rounded-xl text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Item Pesanan</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="text-left py-3 px-4 font-semibold text-slate-700">Produk</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-700">Paket</th>
                                    <th class="text-right py-3 px-4 font-semibold text-slate-700">Harga</th>
                                    <th class="text-right py-3 px-4 font-semibold text-slate-700">Qty</th>
                                    <th class="text-right py-3 px-4 font-semibold text-slate-700">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="py-4 px-4">
                                            <span
                                                class="font-medium text-slate-800">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-slate-600">{{ $item->price_name }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <span class="text-slate-600">Rp
                                                {{ number_format($item->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <span class="text-slate-600">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <span class="font-semibold text-slate-800">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-slate-200">
                                    <td colspan="4" class="py-4 px-4 text-right font-semibold text-slate-800">Total</td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-xl font-bold text-indigo-600">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-3">Catatan</h3>
                        <p class="text-slate-600">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Customer</h3>
                    @if ($order->customer)
                        <div class="flex items-center space-x-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $order->customer->name }}</p>
                                <p class="text-sm text-slate-500">{{ $order->customer->email }}</p>
                            </div>
                        </div>
                        @if ($order->customer->phone)
                            <div class="flex items-center text-sm text-slate-600 mb-2">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $order->customer->phone }}
                            </div>
                        @endif
                    @else
                        <p class="text-slate-500">Tidak ada data customer</p>
                    @endif
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Pesanan</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Dibuat</dt>
                            <dd class="text-slate-800">{{ $order->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        @if ($order->paid_at)
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Dibayar</dt>
                                <dd class="text-slate-800">{{ $order->paid_at->format('d M Y H:i') }}</dd>
                            </div>
                        @endif
                        @if ($order->payment_method)
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Metode Pembayaran</dt>
                                <dd class="text-slate-800">{{ $order->payment_method }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Update Status</h3>
                    <form action="{{ route('orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-select name="status" class="mb-4">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </x-select>
                        <x-button-primary type="submit" class="w-full">Update Status</x-button-primary>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
