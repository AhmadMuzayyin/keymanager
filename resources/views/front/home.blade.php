@extends('layouts.front')

@section('title', 'Marketplace Aplikasi Android, Desktop & Web')
@section('meta_description',
    'Temukan aplikasi Android, Desktop & Web terbaik dengan license key resmi. Dapatkan source
    code berkualitas dengan harga terjangkau dan support penuh.')
@section('meta_keywords',
    'marketplace aplikasi, aplikasi android, aplikasi desktop, aplikasi web, source code, license
    key, beli aplikasi')

@section('structured_data')
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => config('app.name'),
    'url' => url('/'),
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => route('front.products') . '?search={search_term_string}',
        'query-input' => 'required name=search_term_string'
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    {{-- HERO BANNER - Branding & Value Proposition --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#009B4D] via-[#007a3d] to-[#005a2d]">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-[#FFCC00]/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[#FFCC00]/5 rounded-full blur-3xl">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur rounded-full text-white/90 text-sm mb-6">
                        <span class="w-2 h-2 bg-[#FFCC00] rounded-full animate-pulse"></span>
                        <span>🎉 Promo Akhir Tahun - Diskon hingga 50%</span>
                    </div>

                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-6 leading-tight">
                        Solusi Aplikasi
                        <span class="text-[#FFCC00]">Siap Pakai</span>
                        untuk Bisnis Anda
                    </h1>

                    <p class="text-lg text-white/80 mb-8 max-w-xl">
                        Temukan 500+ aplikasi Android, Desktop & Web berkualitas dengan source code lengkap,
                        license resmi, dan support profesional.
                    </p>

                    {{-- Search Bar --}}
                    <form action="{{ route('front.products') }}" method="GET" class="mb-8">
                        <div class="flex bg-white rounded-2xl p-2 shadow-2xl shadow-black/20">
                            <div class="flex-1 relative">
                                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" name="search"
                                    placeholder="Cari aplikasi POS, E-Commerce, Inventory..."
                                    class="w-full pl-12 pr-4 py-4 border-0 focus:ring-0 text-slate-800 placeholder-slate-400 bg-transparent text-lg">
                            </div>
                            <button type="submit"
                                class="px-8 py-4 bg-[#009B4D] text-white font-semibold rounded-xl hover:bg-[#007a3d] transition-all">
                                Cari
                            </button>
                        </div>
                    </form>

                    {{-- Trust Badges --}}
                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 text-white/70 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#FFCC00]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>License Resmi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#FFCC00]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Source Code Full</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#FFCC00]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Support 24/7</span>
                        </div>
                    </div>
                </div>

                {{-- Stats Card --}}
                <div class="hidden lg:block">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="text-4xl font-bold text-white mb-2">500+</div>
                            <div class="text-white/70">Aplikasi Tersedia</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="text-4xl font-bold text-[#FFCC00] mb-2">1000+</div>
                            <div class="text-white/70">Customer Happy</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <div class="text-4xl font-bold text-white mb-2">99%</div>
                            <div class="text-white/70">Kepuasan Customer</div>
                        </div>
                        <div class="bg-[#FFCC00] rounded-2xl p-6">
                            <div class="text-4xl font-bold text-[#007a3d] mb-2">24/7</div>
                            <div class="text-[#007a3d]/80">Support Online</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 50L60 45.7C120 41 240 33 360 35.3C480 38 600 51 720 55.2C840 60 960 55 1080 48.5C1200 42 1320 33 1380 28.8L1440 25V100H1380C1320 100 1200 100 1080 100C960 100 840 100 720 100C600 100 480 100 360 100C240 100 120 100 60 100H0V50Z"
                    fill="#FAF5E9" />
            </svg>
        </div>
    </section>

    {{-- KATEGORI - Visual & Clickable --}}
    <section class="py-12 bg-[#FAF5E9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Jelajahi Kategori</h2>
                    <p class="text-slate-500 mt-1">Pilih kategori sesuai kebutuhan Anda</p>
                </div>
                <a href="{{ route('front.products') }}"
                    class="text-[#009B4D] hover:text-[#007a3d] font-medium flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                {{-- Android --}}
                <a href="{{ route('front.products', ['type' => 'android']) }}"
                    class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl hover:shadow-green-500/10 transition-all border border-slate-100 hover:border-[#009B4D]/30">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-3xl">📱</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 group-hover:text-[#009B4D]">Android</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $products->where('type', 'android')->count() }}+ Apps</p>
                </a>

                {{-- Desktop --}}
                <a href="{{ route('front.products', ['type' => 'desktop']) }}"
                    class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl hover:shadow-blue-500/10 transition-all border border-slate-100 hover:border-blue-500/30">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🖥️</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 group-hover:text-blue-600">Desktop</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $products->where('type', 'desktop')->count() }}+ Apps</p>
                </a>

                {{-- Web --}}
                <a href="{{ route('front.products', ['type' => 'web']) }}"
                    class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl hover:shadow-purple-500/10 transition-all border border-slate-100 hover:border-purple-500/30">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🌐</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 group-hover:text-purple-600">Web App</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $products->where('type', 'web')->count() }}+ Apps</p>
                </a>

                {{-- Source Code --}}
                <a href="{{ route('front.products', ['category' => 'source-code']) }}"
                    class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl hover:shadow-amber-500/10 transition-all border border-slate-100 hover:border-amber-500/30">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-3xl">💻</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 group-hover:text-amber-600">Source Code</h3>
                    <p class="text-sm text-slate-500 mt-1">Full Access</p>
                </a>

                {{-- E-Commerce --}}
                <a href="{{ route('front.products', ['category' => 'e-commerce']) }}"
                    class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl hover:shadow-pink-500/10 transition-all border border-slate-100 hover:border-pink-500/30">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🛒</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 group-hover:text-pink-600">E-Commerce</h3>
                    <p class="text-sm text-slate-500 mt-1">Siap Jualan</p>
                </a>

                {{-- License Key --}}
                <a href="{{ route('front.order.license-only') }}"
                    class="group bg-gradient-to-br from-[#009B4D] to-[#007a3d] rounded-2xl p-6 text-center hover:shadow-xl hover:shadow-green-500/20 transition-all">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-[#FFCC00] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🔑</span>
                    </div>
                    <h3 class="font-semibold text-white">License Key</h3>
                    <p class="text-sm text-white/70 mt-1">Beli Sekarang</p>
                </a>
            </div>
        </div>
    </section>

    {{-- FEATURED PRODUCTS - Highlight Utama --}}
    @if ($featuredProducts->count() > 0)
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#FFCC00] rounded-xl flex items-center justify-center">
                            <span class="text-xl">⭐</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Produk Unggulan</h2>
                            <p class="text-slate-500">Pilihan terbaik dari tim kami</p>
                        </div>
                    </div>
                    <a href="{{ route('front.products') }}"
                        class="hidden sm:flex items-center gap-1 px-4 py-2 bg-[#FAF5E9] text-[#009B4D] rounded-lg hover:bg-[#009B4D] hover:text-white transition-all font-medium">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                    @foreach ($featuredProducts->take(10) as $product)
                        <article
                            class="group bg-white rounded-2xl overflow-hidden border border-slate-100 hover:border-[#009B4D]/30 hover:shadow-xl hover:shadow-green-500/10 transition-all">
                            <a href="{{ route('front.product.detail', $product->slug) }}" class="block">
                                <div
                                    class="aspect-square relative overflow-hidden bg-gradient-to-br from-slate-100 to-slate-50">
                                    @if ($product->thumbnail)
                                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Badges --}}
                                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                                        @php
                                            $typeConfig = [
                                                'android' => ['bg' => 'bg-green-500', 'icon' => '📱'],
                                                'desktop' => ['bg' => 'bg-blue-500', 'icon' => '🖥️'],
                                                'web' => ['bg' => 'bg-purple-500', 'icon' => '🌐'],
                                            ];
                                            $config = $typeConfig[$product->type] ?? [
                                                'bg' => 'bg-slate-500',
                                                'icon' => '📦',
                                            ];
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 {{ $config['bg'] }} text-white text-xs font-medium rounded-lg flex items-center gap-1">
                                            <span>{{ $config['icon'] }}</span>
                                            {{ ucfirst($product->type) }}
                                        </span>
                                    </div>

                                    <div class="absolute top-3 right-3">
                                        <span class="px-2.5 py-1 bg-[#FFCC00] text-[#007a3d] text-xs font-bold rounded-lg">
                                            ⭐ Featured
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <div class="p-4">
                                <a href="{{ route('front.product.detail', $product->slug) }}">
                                    <h3
                                        class="font-semibold text-slate-800 mb-2 line-clamp-2 group-hover:text-[#009B4D] transition-colors min-h-[48px]">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <div class="flex items-center gap-2 mb-3">
                                    @foreach ($product->categories->take(1) as $category)
                                        <span
                                            class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $category->name }}</span>
                                    @endforeach
                                </div>

                                @if ($product->prices->first())
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if ($product->prices->first()->original_price)
                                                <span class="text-xs text-slate-400 line-through">
                                                    Rp
                                                    {{ number_format($product->prices->first()->original_price, 0, ',', '.') }}
                                                </span>
                                            @endif
                                            <div class="text-lg font-bold text-[#009B4D]">
                                                Rp {{ number_format($product->prices->first()->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- PROMO BANNER --}}
    <section class="py-8 bg-[#FAF5E9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Banner 1 --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#009B4D] to-[#007a3d] p-8">
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-[#FFCC00]/20 rounded-full -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div class="relative z-10">
                        <span
                            class="inline-block px-3 py-1 bg-[#FFCC00] text-[#007a3d] text-xs font-bold rounded-full mb-4">PROMO
                            SPESIAL</span>
                        <h3 class="text-2xl font-bold text-white mb-2">Diskon 50% License Key</h3>
                        <p class="text-white/80 mb-4">Untuk pembelian pertama. Berlaku hingga akhir bulan!</p>
                        <a href="{{ route('front.order.license-only') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#009B4D] font-semibold rounded-xl hover:bg-[#FFCC00] transition-colors">
                            Beli Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Banner 2 --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 p-8">
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-[#FFCC00]/10 rounded-full -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div class="relative z-10">
                        <span
                            class="inline-block px-3 py-1 bg-[#FFCC00] text-slate-900 text-xs font-bold rounded-full mb-4">GRATIS</span>
                        <h3 class="text-2xl font-bold text-white mb-2">Konsultasi Gratis</h3>
                        <p class="text-white/80 mb-4">Bingung pilih aplikasi? Tim kami siap membantu 24/7!</p>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#25D366] text-white font-semibold rounded-xl hover:bg-[#128C7E] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ALL PRODUCTS - Grid Rapi --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Semua Produk</h2>
                    <p class="text-slate-500 mt-1">{{ $products->total() }} aplikasi siap digunakan</p>
                </div>

                <div class="flex items-center gap-3">
                    <select onchange="window.location.href=this.value"
                        class="px-4 py-2.5 bg-[#FAF5E9] border-0 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-[#009B4D]">
                        <option value="{{ route('front.home') }}" {{ !request('type') ? 'selected' : '' }}>Semua Tipe
                        </option>
                        <option value="{{ route('front.products', ['type' => 'android']) }}"
                            {{ request('type') == 'android' ? 'selected' : '' }}>📱 Android</option>
                        <option value="{{ route('front.products', ['type' => 'desktop']) }}"
                            {{ request('type') == 'desktop' ? 'selected' : '' }}>🖥️ Desktop</option>
                        <option value="{{ route('front.products', ['type' => 'web']) }}"
                            {{ request('type') == 'web' ? 'selected' : '' }}>🌐 Web</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @forelse ($products as $product)
                    <article
                        class="group bg-white rounded-2xl overflow-hidden border border-slate-100 hover:border-[#009B4D]/30 hover:shadow-lg transition-all">
                        <a href="{{ route('front.product.detail', $product->slug) }}" class="block">
                            <div
                                class="aspect-square relative overflow-hidden bg-gradient-to-br from-slate-100 to-slate-50">
                                @if ($product->thumbnail)
                                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif

                                @php
                                    $typeConfig = [
                                        'android' => ['bg' => 'bg-green-500', 'icon' => '📱'],
                                        'desktop' => ['bg' => 'bg-blue-500', 'icon' => '🖥️'],
                                        'web' => ['bg' => 'bg-purple-500', 'icon' => '🌐'],
                                    ];
                                    $config = $typeConfig[$product->type] ?? ['bg' => 'bg-slate-500', 'icon' => '📦'];
                                @endphp
                                <span
                                    class="absolute top-2 left-2 px-2 py-1 {{ $config['bg'] }} text-white text-xs font-medium rounded-lg">
                                    {{ $config['icon'] }} {{ ucfirst($product->type) }}
                                </span>

                                @if ($product->is_featured)
                                    <span
                                        class="absolute top-2 right-2 px-2 py-1 bg-[#FFCC00] text-[#007a3d] text-xs font-bold rounded-lg">⭐</span>
                                @endif
                            </div>
                        </a>

                        <div class="p-4">
                            <a href="{{ route('front.product.detail', $product->slug) }}">
                                <h3
                                    class="font-medium text-slate-800 text-sm mb-2 line-clamp-2 group-hover:text-[#009B4D] transition-colors min-h-[40px]">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            @if ($product->prices->first())
                                <div class="font-bold text-[#009B4D]">
                                    Rp {{ number_format($product->prices->first()->price, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum ada produk</h3>
                        <p class="text-slate-500">Produk akan segera tersedia</p>
                    </div>
                @endforelse
            </div>

            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                <div class="mt-10">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </section>

    {{-- WHY CHOOSE US - Trust Building --}}
    <section class="py-16 bg-[#FAF5E9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Kenapa Pilih Kami?</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Kami berkomitmen memberikan produk dan layanan terbaik untuk
                    kesuksesan bisnis Anda</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-shadow">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-[#009B4D] to-[#007a3d] rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">License Resmi</h3>
                    <p class="text-slate-500 text-sm">Semua produk dilengkapi license key resmi yang terverifikasi</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-shadow">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-[#FFCC00] to-[#f5b800] rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-[#007a3d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Source Code Full</h3>
                    <p class="text-slate-500 text-sm">Akses penuh ke source code, bebas modifikasi sesuai kebutuhan</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-shadow">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Update Gratis</h3>
                    <p class="text-slate-500 text-sm">Dapatkan update fitur dan perbaikan bug secara gratis selamanya</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-shadow">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Support 24/7</h3>
                    <p class="text-slate-500 text-sm">Tim support kami siap membantu Anda kapan saja</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="py-16 bg-gradient-to-r from-[#009B4D] to-[#007a3d] relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-[#FFCC00]/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Siap Memulai Bisnis Anda?</h2>
            <p class="text-xl text-white/80 mb-8">Pilih aplikasi yang tepat dan mulai bisnis Anda hari ini</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.products') }}"
                    class="px-8 py-4 bg-white text-[#009B4D] font-bold rounded-xl hover:bg-[#FFCC00] hover:text-[#007a3d] transition-all text-lg">
                    Lihat Semua Produk
                </a>
                <a href="{{ route('front.order.license-only') }}"
                    class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-[#009B4D] transition-all text-lg">
                    Beli License Key
                </a>
            </div>
        </div>
    </section>
@endsection
