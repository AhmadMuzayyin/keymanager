@extends('layouts.front')

@section('title', $seoData['title'])
@section('meta_description', $seoData['description'])
@section('meta_keywords', $seoData['keywords'])
@section('canonical_url', $seoData['url'])
@section('og_title', $seoData['title'])
@section('og_description', $seoData['description'])
@section('og_url', $seoData['url'])

@section('structured_data')
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => 'License Key',
    'description' => 'License key untuk mengaktifkan produk aplikasi Anda',
    'brand' => [
        '@type' => 'Brand',
        'name' => config('app.name')
    ],
    'offers' => [
        '@type' => 'AggregateOffer',
        'priceCurrency' => 'IDR',
        'lowPrice' => '150000',
        'highPrice' => '750000',
        'offerCount' => '3',
        'availability' => 'https://schema.org/InStock'
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => route('front.home')
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Order License Key',
            'item' => route('front.order.license-only')
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    <section class="bg-gradient-to-br from-[#009B4D] to-[#007a3d] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">Order License Key</h1>
                <p class="text-white/80 max-w-2xl mx-auto">
                    Beli license key untuk mengaktifkan produk Anda. Proses cepat dan aman dengan berbagai metode
                    pembayaran.
                </p>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <form action="{{ route('front.order.license.store') }}" method="POST" class="space-y-6"
                    x-data="{
                        licenseType: 'single',
                        prices: { single: 150000, multi: 350000, unlimited: 750000 },
                        get total() { return this.prices[this.licenseType] }
                    }">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="product_name" value="{{ old('product_name') }}" required
                            placeholder="Masukkan nama produk yang membutuhkan license" list="product-suggestions"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                        <datalist id="product-suggestions">
                            @foreach ($products as $product)
                                <option value="{{ $product->name }}">
                            @endforeach
                        </datalist>
                        <p class="text-xs text-slate-500 mt-1">Nama produk/aplikasi yang akan menggunakan license key</p>
                        @error('product_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-3">Tipe License <span
                                class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="license_type" value="single" x-model="licenseType"
                                    class="sr-only peer" checked>
                                <div
                                    class="p-5 bg-white border-2 rounded-xl peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all h-full">
                                    <div class="text-center">
                                        <div
                                            class="w-12 h-12 bg-[#c8e6c9] rounded-xl flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-[#009B4D]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-slate-800 mb-1">Single</h4>
                                        <p class="text-sm text-slate-500 mb-3">1 Domain/Device</p>
                                        <div class="text-xl font-bold text-[#009B4D]">Rp 150.000</div>
                                    </div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="license_type" value="multi" x-model="licenseType"
                                    class="sr-only peer">
                                <div
                                    class="p-5 bg-white border-2 rounded-xl peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all h-full relative">
                                    <span
                                        class="absolute -top-2 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-amber-400 text-amber-900 text-xs font-semibold rounded-full">Popular</span>
                                    <div class="text-center">
                                        <div
                                            class="w-12 h-12 bg-[#c8e6c9] rounded-xl flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-[#009B4D]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-slate-800 mb-1">Multi</h4>
                                        <p class="text-sm text-slate-500 mb-3">5 Domain/Device</p>
                                        <div class="text-xl font-bold text-[#009B4D]">Rp 350.000</div>
                                    </div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="license_type" value="unlimited" x-model="licenseType"
                                    class="sr-only peer">
                                <div
                                    class="p-5 bg-white border-2 rounded-xl peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all h-full">
                                    <div class="text-center">
                                        <div
                                            class="w-12 h-12 bg-[#c8e6c9] rounded-xl flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-[#009B4D]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-slate-800 mb-1">Unlimited</h4>
                                        <p class="text-sm text-slate-500 mb-3">Tanpa Batas</p>
                                        <div class="text-xl font-bold text-[#009B4D]">Rp 750.000</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('license_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="font-semibold text-slate-800 mb-4">Informasi Pembeli</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                                @error('customer_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                                @error('customer_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">No. WhatsApp</label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                                @error('customer_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Domain (Opsional)</label>
                                <input type="text" name="domain" value="{{ old('domain') }}"
                                    placeholder="example.com"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                                <p class="text-xs text-slate-500 mt-1">Domain utama untuk aktivasi license</p>
                                @error('domain')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="font-semibold text-slate-800 mb-4">Metode Pembayaran</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-data="{ payment: 'bank_transfer' }">
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" x-model="payment"
                                    class="sr-only peer" checked>
                                <div
                                    class="p-4 bg-white border-2 rounded-xl text-center peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                    <span class="font-medium text-slate-800">Transfer Bank</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="ewallet" x-model="payment"
                                    class="sr-only peer">
                                <div
                                    class="p-4 bg-white border-2 rounded-xl text-center peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium text-slate-800">E-Wallet</span>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Catatan (Opsional)</label>
                        <textarea name="notes" rows="3" placeholder="Catatan tambahan untuk order Anda..."
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">{{ old('notes') }}</textarea>
                    </div>

                    <div class="bg-[#FAF5E9] rounded-xl p-5">
                        <div class="flex items-center justify-between text-lg">
                            <span class="font-semibold text-slate-800">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-[#009B4D]"
                                x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-[#009B4D] to-[#007a3d] text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                        Lanjutkan Pembayaran
                    </button>
                </form>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-5 border border-slate-100 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-800 mb-1">License Resmi</h4>
                    <p class="text-sm text-slate-500">License key terverifikasi dan dapat dicek validitasnya</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-100 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-800 mb-1">Aktivasi Instan</h4>
                    <p class="text-sm text-slate-500">License key dikirim langsung setelah pembayaran dikonfirmasi</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-100 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-800 mb-1">Support 24/7</h4>
                    <p class="text-sm text-slate-500">Tim support siap membantu aktivasi dan troubleshooting</p>
                </div>
            </div>
        </div>
    </section>
@endsection
