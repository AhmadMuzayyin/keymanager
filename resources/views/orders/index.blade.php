@extends('layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Pesanan')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Pesanan</h2>
                <p class="text-slate-500 mt-1">Kelola pesanan produk dari customer</p>
            </div>
            <a href="{{ route('orders.create') }}"
                class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Pesanan
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="glass-card rounded-2xl p-5 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Pesanan</p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Pending</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($stats['pending']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Dibayar</p>
                        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats['paid']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">Rp
                            {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-4 sm:p-6">
            <form action="{{ route('orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <x-input type="text" name="search" placeholder="Cari nomor pesanan atau customer..."
                        :value="request('search')" />
                </div>
                <div class="w-full sm:w-40">
                    <x-select name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </x-select>
                </div>
                <div class="flex gap-2">
                    <x-button-primary type="submit">Filter</x-button-primary>
                    <a href="{{ route('orders.index') }}"
                        class="px-4 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                        Reset
                    </a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">No. Pesanan</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Customer</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Total</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Status</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Tanggal</th>
                            <th class="text-right py-4 px-4 font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="font-mono font-semibold text-slate-800">{{ $order->order_number }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $order->customer->name ?? 'Guest' }}</p>
                                        <p class="text-sm text-slate-500">{{ $order->customer->email ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-slate-800">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'paid' => 'bg-emerald-100 text-emerald-700',
                                            'completed' => 'bg-blue-100 text-blue-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-slate-600">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('orders.show', $order) }}"
                                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if ($order->status === 'pending')
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">Belum ada pesanan</p>
                                        <p class="text-slate-400 text-sm mt-1">Pesanan baru akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="mt-6 border-t border-slate-200 pt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
