@extends('layouts.front')

@section('title', 'Order Berhasil - ' . $order->order_number)
@section('meta_description', 'Order Anda berhasil dibuat. Silakan lakukan pembayaran untuk mengaktifkan license key.')

@section('content')
    <section class="py-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">Order Berhasil Dibuat!</h1>
                <p class="text-slate-600 mb-6">Terima kasih telah melakukan order. Silakan lakukan pembayaran untuk
                    mengaktifkan license key Anda.</p>

                <div class="bg-[#FAF5E9] rounded-xl p-6 mb-6 text-left">
                    <h3 class="font-semibold text-slate-800 mb-4">Detail Order</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Nomor Order</span>
                            <span class="font-mono font-semibold text-slate-800">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tanggal</span>
                            <span class="text-slate-800">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Status</span>
                            <span
                                class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Menunggu
                                Pembayaran</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Metode Pembayaran</span>
                            <span
                                class="text-slate-800 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 mt-4 pt-4">
                        <h4 class="font-medium text-slate-800 mb-3">Item Order</h4>
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-medium text-slate-800">{{ $item->product_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $item->price_name }}</p>
                                </div>
                                <span class="font-semibold text-slate-800">Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-200 mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800">Total</span>
                            <span class="text-xl font-bold text-[#009B4D]">Rp
                                {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if ($order->payment_method === 'bank_transfer')
                    <div class="bg-[#e8f5e9] rounded-xl p-6 mb-6 text-left">
                        <h3 class="font-semibold text-indigo-800 mb-4">Informasi Pembayaran</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-[#009B4D] font-medium">Bank BCA</p>
                                <p class="text-slate-800 font-mono text-lg">1234567890</p>
                                <p class="text-slate-600">a.n. {{ config('app.name') }}</p>
                            </div>
                            <div class="pt-3 border-t border-indigo-100">
                                <p class="text-[#009B4D] font-medium">Bank Mandiri</p>
                                <p class="text-slate-800 font-mono text-lg">0987654321</p>
                                <p class="text-slate-600">a.n. {{ config('app.name') }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-[#007a3d] mt-4 bg-[#c8e6c9] p-3 rounded-lg">
                            💡 Transfer sesuai nominal total untuk mempercepat proses verifikasi
                        </p>
                    </div>
                @endif

                <div class="bg-amber-50 rounded-xl p-4 mb-6 text-left">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-sm text-amber-800">
                                Setelah melakukan pembayaran, konfirmasi ke WhatsApp <strong>08xxxxxxxxxx</strong> dengan
                                menyertakan bukti transfer dan nomor order.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('tracking.show', $order->items->first()?->license?->purchase_code ?? $order->order_number) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-[#009B4D] text-white rounded-xl font-medium hover:bg-[#007a3d] transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        Lacak Order
                    </a>
                    <a href="{{ route('front.home') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-[#FAF5E9] transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm">
                    Detail order juga telah dikirim ke email <strong>{{ $order->customer->email }}</strong>
                </p>
            </div>
        </div>
    </section>
@endsection
