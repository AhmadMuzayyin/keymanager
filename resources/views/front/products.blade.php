@extends('layouts.front')

@section('title', ($activeCategory ? $activeCategory->name . ' - ' : '') . 'Produk Aplikasi')
@section('meta_description',
    'Jelajahi koleksi aplikasi ' .
    ($activeCategory
    ? $activeCategory->name
    : 'Android, Desktop
    & Web') .
    ' terbaik dengan license key resmi.')
@section('meta_keywords', 'aplikasi ' . ($activeCategory ? strtolower($activeCategory->name) : 'android desktop web') .
    ', source code, license key')

@section('structured_data')
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => $activeCategory ? $activeCategory->name : 'Semua Produk',
    'description' => 'Koleksi aplikasi ' . ($activeCategory ? $activeCategory->name : 'Android, Desktop & Web') . ' terbaik',
    'url' => url()->current()
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    <section class="bg-gradient-to-br from-[#009B4D] to-[#007a3d] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    {{ $activeCategory ? $activeCategory->name : 'Semua Produk' }}
                </h1>
                <p class="text-white/80 max-w-2xl mx-auto">
                    {{ $activeCategory ? "Jelajahi koleksi aplikasi {$activeCategory->name} terbaik" : 'Temukan aplikasi Android, Desktop & Web berkualitas dengan license key resmi' }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-10 bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('front.products') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <select name="type"
                        class="px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D] bg-white">
                        <option value="">Semua Tipe</option>
                        <option value="android" {{ request('type') === 'android' ? 'selected' : '' }}>Android</option>
                        <option value="desktop" {{ request('type') === 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="web" {{ request('type') === 'web' ? 'selected' : '' }}>Web</option>
                    </select>
                    <select name="sort"
                        class="px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D] bg-white">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi
                        </option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                    <button type="submit"
                        class="px-6 py-3 bg-[#009B4D] text-white rounded-xl hover:bg-[#007a3d] transition-colors font-medium">
                        Filter
                    </button>
                    @if (request()->hasAny(['search', 'type', 'sort', 'category']))
                        <a href="{{ route('front.products') }}"
                            class="px-6 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-[#FAF5E9] transition-colors font-medium">
                            Reset
                        </a>
                    @endif
                </div>
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>
        </div>
    </section>

    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 sticky top-24">
                        <h3 class="font-bold text-slate-800 mb-4">Kategori</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('front.products') }}"
                                    class="flex items-center justify-between px-3 py-2 rounded-lg {{ !request('category') ? 'bg-[#e8f5e9] text-[#009B4D]' : 'text-slate-600 hover:bg-[#FAF5E9]' }} transition-colors">
                                    <span>Semua Kategori</span>
                                    <span class="text-sm">{{ $products->total() }}</span>
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('front.products', ['category' => $category->slug]) }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg {{ request('category') === $category->slug ? 'bg-[#e8f5e9] text-[#009B4D]' : 'text-slate-600 hover:bg-[#FAF5E9]' }} transition-colors">
                                        <span class="flex items-center">
                                            <span class="mr-2">{{ $category->icon ?? '📦' }}</span>
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-sm">{{ $category->products_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                <div class="flex-1">
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($products as $product)
                                <article
                                    class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover border border-slate-100"
                                    itemscope itemtype="https://schema.org/Product">
                                    <a href="{{ route('front.product.detail', $product->slug) }}" class="block">
                                        <div
                                            class="aspect-video bg-gradient-to-br from-[#e8f5e9] to-[#c8e6c9] relative overflow-hidden">
                                            @if ($product->thumbnail)
                                                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover" itemprop="image">
                                            @else
                                                <div class="flex items-center justify-center h-full">
                                                    <svg class="w-16 h-16 text-[#81c784]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                            @php
                                                $typeColors = [
                                                    'android' => 'bg-green-500',
                                                    'desktop' => 'bg-blue-500',
                                                    'web' => 'bg-purple-500',
                                                ];
                                            @endphp
                                            <span
                                                class="absolute top-3 left-3 px-3 py-1 {{ $typeColors[$product->type] ?? 'bg-[#FAF5E9]0' }} text-white text-xs font-medium rounded-full">
                                                {{ ucfirst($product->type) }}
                                            </span>
                                            @if ($product->is_featured)
                                                <span
                                                    class="absolute top-3 right-3 px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-medium rounded-full">
                                                    ⭐ Featured
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="p-5">
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach ($product->categories->take(2) as $category)
                                                <span
                                                    class="px-2 py-1 bg-slate-100 text-slate-600 text-xs rounded-lg">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                        <a href="{{ route('front.product.detail', $product->slug) }}">
                                            <h2 class="font-bold text-slate-800 text-lg mb-2 hover:text-[#009B4D] transition-colors"
                                                itemprop="name">{{ $product->name }}</h2>
                                        </a>
                                        <p class="text-slate-500 text-sm mb-4 line-clamp-2" itemprop="description">
                                            {{ $product->description }}</p>
                                        <div class="flex items-center justify-between" itemprop="offers" itemscope
                                            itemtype="https://schema.org/Offer">
                                            <meta itemprop="priceCurrency" content="IDR">
                                            <div>
                                                @if ($product->prices->first())
                                                    <span class="text-xl font-bold text-[#009B4D]" itemprop="price"
                                                        content="{{ $product->prices->first()->price }}">
                                                        Rp
                                                        {{ number_format($product->prices->first()->price, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <a href="{{ route('front.order.bundle', $product->slug) }}"
                                                class="px-4 py-2 bg-[#009B4D] text-white text-sm font-medium rounded-xl hover:bg-[#007a3d] transition-colors">
                                                Beli
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-10">
                            {{ $products->links('vendor.pagination.custom') }}
                        </div>
                    @else
                        <div class="text-center py-20">
                            <svg class="w-20 h-20 mx-auto text-slate-300 mb-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h3 class="text-xl font-semibold text-slate-700 mb-2">Produk tidak ditemukan</h3>
                            <p class="text-slate-500 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
                            <a href="{{ route('front.products') }}"
                                class="inline-flex items-center px-6 py-3 bg-[#009B4D] text-white rounded-xl hover:bg-[#007a3d] transition-colors">
                                Lihat Semua Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
