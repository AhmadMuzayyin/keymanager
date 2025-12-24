@extends('layouts.front')

@section('title', $seoData['title'])
@section('meta_description', $seoData['description'])
@section('meta_keywords', $seoData['keywords'])
@section('canonical_url', $seoData['url'])
@section('og_title', $seoData['title'])
@section('og_description', $seoData['description'])
@section('og_image', $seoData['image'] ?? asset('images/og-default.jpg'))
@section('og_url', $seoData['url'])

@section('structured_data')
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => $product->description,
    'image' => $product->thumbnail,
    'brand' => [
        '@type' => 'Brand',
        'name' => config('app.name')
    ],
    'offers' => [
        '@type' => 'Offer',
        'priceCurrency' => 'IDR',
        'price' => $selectedPrice?->price ?? 0,
        'availability' => 'https://schema.org/InStock',
        'seller' => [
            '@type' => 'Organization',
            'name' => config('app.name')
        ]
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
            'name' => 'Produk',
            'item' => route('front.products')
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $product->name,
            'item' => route('front.product.detail', $product->slug)
        ],
        [
            '@type' => 'ListItem',
            'position' => 4,
            'name' => 'Order',
            'item' => route('front.order.bundle', $product->slug)
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    <nav class="bg-white border-b py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('front.home') }}" class="text-slate-500 hover:text-[#009B4D]">Home</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li><a href="{{ route('front.products') }}" class="text-slate-500 hover:text-[#009B4D]">Produk</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li><a href="{{ route('front.product.detail', $product->slug) }}"
                        class="text-slate-500 hover:text-[#009B4D]">{{ $product->name }}</a></li>
                <li><span class="text-slate-300">/</span></li>
                <li class="text-slate-800 font-medium">Order</li>
            </ol>
        </div>
    </nav>

    <section class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                        <h1 class="text-2xl font-bold text-slate-800 mb-6">Order Produk & License Key</h1>

                        <form action="{{ route('front.order.bundle.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="bg-[#FAF5E9] rounded-xl p-5 mb-6">
                                <div class="flex items-start gap-4">
                                    @if ($product->thumbnail)
                                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                            class="w-20 h-20 rounded-xl object-cover">
                                    @else
                                        <div class="w-20 h-20 rounded-xl bg-[#c8e6c9] flex items-center justify-center">
                                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-slate-800">{{ $product->name }}</h3>
                                        <p class="text-sm text-slate-500 mt-1">{{ Str::limit($product->description, 80) }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-2">
                                            @php
                                                $typeColors = [
                                                    'android' => 'bg-green-100 text-green-700',
                                                    'desktop' => 'bg-blue-100 text-blue-700',
                                                    'web' => 'bg-purple-100 text-purple-700',
                                                ];
                                            @endphp
                                            <span
                                                class="px-2 py-0.5 {{ $typeColors[$product->type] ?? 'bg-slate-100 text-slate-700' }} text-xs rounded-full">
                                                {{ ucfirst($product->type) }}
                                            </span>
                                            @if ($product->latestVersion)
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded-full">
                                                    v{{ $product->latestVersion->version }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($product->prices->count() > 1)
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-3">Pilih Paket Harga</label>
                                    <div class="space-y-3" x-data="{ selected: '{{ $selectedPrice?->id ?? $product->prices->first()->id }}' }">
                                        @foreach ($product->prices as $price)
                                            <label class="block cursor-pointer">
                                                <input type="radio" name="price_id" value="{{ $price->id }}"
                                                    x-model="selected" class="sr-only peer"
                                                    {{ ($selectedPrice?->id ?? $product->prices->first()->id) == $price->id ? 'checked' : '' }}>
                                                <div
                                                    class="p-4 bg-white border-2 rounded-xl peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h4 class="font-semibold text-slate-800">{{ $price->name }}
                                                            </h4>
                                                            @if ($price->features)
                                                                <p class="text-sm text-slate-500 mt-1">
                                                                    @if (is_array($price->features))
                                                                        {{ implode(', ', $price->features) }}
                                                                    @else
                                                                        {{ $price->features }}
                                                                    @endif
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="text-right">
                                                            @if ($price->hasDiscount())
                                                                <span class="text-sm text-slate-400 line-through">Rp
                                                                    {{ number_format($price->original_price, 0, ',', '.') }}</span>
                                                            @endif
                                                            <div class="text-xl font-bold text-[#009B4D]">Rp
                                                                {{ number_format($price->price, 0, ',', '.') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('price_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="price_id" value="{{ $product->prices->first()?->id }}">
                            @endif

                            <div class="border-t border-slate-200 pt-6">
                                <h3 class="font-semibold text-slate-800 mb-4">Informasi Pembeli</h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                                            required
                                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                                        @error('customer_name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Email <span
                                                class="text-red-500">*</span></label>
                                        <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                            required
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
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Domain
                                            (Opsional)</label>
                                        <input type="text" name="domain" value="{{ old('domain') }}"
                                            placeholder="example.com"
                                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                                        <p class="text-xs text-slate-500 mt-1">Domain tempat aplikasi akan digunakan</p>
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
                                        <input type="radio" name="payment_method" value="bank_transfer"
                                            x-model="payment" class="sr-only peer" checked>
                                        <div
                                            class="p-4 bg-white border-2 rounded-xl text-center peer-checked:border-[#009B4D] peer-checked:bg-[#e8f5e9] hover:border-slate-300 transition-all">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
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
                                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
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

                            <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-[#009B4D] to-[#007a3d] text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                                Lanjutkan Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                        <h3 class="font-semibold text-slate-800 mb-4">Ringkasan Order</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Produk</span>
                                <span class="font-medium text-slate-800">{{ $product->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Paket</span>
                                <span
                                    class="font-medium text-slate-800">{{ $selectedPrice?->name ?? $product->prices->first()?->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">License Key</span>
                                <span class="font-medium text-green-600">Termasuk</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Source Code</span>
                                <span class="font-medium text-green-600">Termasuk</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Update</span>
                                <span class="font-medium text-green-600">Gratis Selamanya</span>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 mt-4 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-slate-800">Total</span>
                                <span class="text-2xl font-bold text-[#009B4D]">
                                    Rp
                                    {{ number_format($selectedPrice?->price ?? ($product->prices->first()?->price ?? 0), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-green-50 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-green-800">Jaminan Keamanan</h4>
                                    <p class="text-sm text-green-700 mt-1">Pembayaran aman & terenkripsi. License key resmi
                                        dengan verifikasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
