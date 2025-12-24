@extends('layouts.front')

@section('title', 'Order ' . $order->order_number . ' - ' . config('app.name'))
@section('meta_description', 'Detail order ' . $order->order_number)

@section('content')
    <section class="py-10 bg-[#FAF5E9] min-h-[70vh]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('tracking.index') }}"
                class="inline-flex items-center text-[#009B4D] hover:text-[#006030] mb-6">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-[#009B4D] to-[#007a3d] text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/70 text-sm">Nomor Order</p>
                            <h1 class="text-2xl font-bold">{{ $order->order_number }}</h1>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-400 text-yellow-900',
                                'processing' => 'bg-blue-400 text-blue-900',
                                'completed' => 'bg-green-400 text-green-900',
                                'cancelled' => 'bg-red-400 text-red-900',
                            ];
                        @endphp
                        <span
                            class="px-4 py-2 {{ $statusColors[$order->status] ?? 'bg-slate-400' }} rounded-full font-medium">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-2">Informasi Customer</h3>
                            <div class="bg-[#FAF5E9] rounded-xl p-4">
                                <p class="font-semibold text-slate-800">{{ $order->customer->name }}</p>
                                <p class="text-slate-600">{{ $order->customer->email }}</p>
                                @if ($order->customer->phone)
                                    <p class="text-slate-600">{{ $order->customer->phone }}</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-2">Detail Order</h3>
                            <div class="bg-[#FAF5E9] rounded-xl p-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tanggal Order</span>
                                    <span class="font-medium">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Metode Pembayaran</span>
                                    <span
                                        class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Total</span>
                                    <span class="font-bold text-[#009B4D]">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-slate-500 mb-3">Item Order</h3>
                        <div class="bg-[#FAF5E9] rounded-xl divide-y divide-slate-200">
                            @foreach ($order->items as $item)
                                <div class="p-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $item->product_name }}</p>
                                        <p class="text-sm text-slate-500">{{ $item->price_name ?? 'License Key' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-slate-800">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <p class="text-sm text-slate-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($order->licenses->count() > 0)
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-3">License Keys</h3>
                            <div class="space-y-3">
                                @foreach ($order->licenses as $license)
                                    <div class="bg-[#FAF5E9] rounded-xl p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm text-slate-600">{{ $license->product_name }}</span>
                                            @php
                                                $licenseStatusColors = [
                                                    'active' => 'bg-green-100 text-green-700',
                                                    'suspended' => 'bg-yellow-100 text-yellow-700',
                                                    'revoked' => 'bg-red-100 text-red-700',
                                                ];
                                            @endphp
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $licenseStatusColors[$license->status] ?? 'bg-slate-100' }}">
                                                {{ ucfirst($license->status) }}
                                            </span>
                                        </div>
                                        <div
                                            class="font-mono text-sm bg-white rounded-lg p-3 border border-slate-200 break-all">
                                            {{ $license->key }}
                                        </div>
                                        <p class="text-xs text-slate-500 mt-2">
                                            Purchase Code: {{ $license->purchase_code }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($order->status === 'pending')
                        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-yellow-800">Menunggu Pembayaran</h4>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Silakan lakukan pembayaran sesuai dengan metode yang dipilih. License key akan aktif
                                        setelah pembayaran dikonfirmasi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
