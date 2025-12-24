@extends('layouts.front')

@section('title', $product->name . ' - Beli Aplikasi dengan License Key')
@section('meta_description', Str::limit($product->description ?? "Beli {$product->name} dengan license key resmi.
    Dapatkan source code lengkap, update gratis, dan dukungan teknis.", 160))
@section('meta_keywords', "{$product->name}, {$product->type} app, license key, source code, beli aplikasi")
@section('canonical_url', route('front.product.detail', $product->slug))
@section('og_title', $product->name)
@section('og_description', Str::limit($product->description, 160))
@section('og_image', $product->thumbnail)
@section('og_url', route('front.product.detail', $product->slug))

@section('structured_data')
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ $product->description }}",
    "image": "{{ $product->thumbnail }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ config('app.name') }}"
    },
    "offers": {
        "@type": "AggregateOffer",
        "priceCurrency": "IDR",
        "lowPrice": "{{ $product->prices->min('price') }}",
        "highPrice": "{{ $product->prices->max('price') }}",
        "offerCount": "{{ $product->prices->count() }}",
        "availability": "https://schema.org/InStock"
    },
    "category": "{{ $product->categories->pluck('name')->join(', ') }}"
}
</script>
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ route('front.home') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "Produk",
            "item": "{{ route('front.products') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $product->name }}",
            "item": "{{ route('front.product.detail', $product->slug) }}"
        }
    ]
}
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
                <li class="text-slate-800 font-medium">{{ $product->name }}</li>
            </ol>
        </div>
    </nav>

    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                        <div class="aspect-video bg-gradient-to-br from-[#e8f5e9] to-[#c8e6c9] relative">
                            @if ($product->thumbnail)
                                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-24 h-24 text-[#81c784]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-3 mt-4">
                            @foreach ($product->images as $image)
                                <div
                                    class="aspect-video bg-slate-100 rounded-xl overflow-hidden cursor-pointer hover:ring-2 hover:ring-[#009B4D] transition-all">
                                    <img src="{{ $image->url }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        @php
                            $typeColors = [
                                'android' => 'bg-green-100 text-green-700',
                                'desktop' => 'bg-blue-100 text-blue-700',
                                'web' => 'bg-purple-100 text-purple-700',
                            ];
                        @endphp
                        <span
                            class="px-3 py-1 {{ $typeColors[$product->type] ?? 'bg-slate-100 text-slate-700' }} text-sm font-medium rounded-full">
                            {{ ucfirst($product->type) }}
                        </span>
                        @if ($product->is_featured)
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-medium rounded-full">
                                ⭐ Featured
                            </span>
                        @endif
                        @if ($product->latestVersion)
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-full">
                                v{{ $product->latestVersion->version }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-4">{{ $product->name }}</h1>

                    <p class="text-slate-600 text-lg mb-6">{{ $product->description }}</p>

                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach ($product->categories as $category)
                            <a href="{{ route('front.products', ['category' => $category->slug]) }}"
                                class="px-3 py-1.5 bg-[#e8f5e9] text-[#009B4D] rounded-lg text-sm hover:bg-[#c8e6c9] transition-colors">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    @if ($product->prices->count() > 0)
                        <div class="bg-[#FAF5E9] rounded-2xl p-6 mb-6">
                            <h3 class="font-semibold text-slate-800 mb-4">Pilih Paket</h3>
                            <div class="space-y-3">
                                @foreach ($product->prices as $price)
                                    <a href="{{ route('front.order.bundle', [$product->slug, $price->id]) }}"
                                        class="block p-4 bg-white rounded-xl border-2 border-slate-200 hover:border-[#009B4D] transition-all group">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4
                                                    class="font-semibold text-slate-800 group-hover:text-[#009B4D] transition-colors">
                                                    {{ $price->name }}</h4>
                                                @if ($price->features)
                                                    <p class="text-sm text-slate-500 mt-1">
                                                        @if (is_array($price->features))
                                                            {{ implode(', ', array_slice($price->features, 0, 3)) }}
                                                        @else
                                                            {{ Str::limit($price->features, 50) }}
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
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex gap-4">
                        <a href="{{ route('front.order.bundle', $product->slug) }}"
                            class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#009B4D] to-[#007a3d] text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Beli Sekarang
                        </a>
                        @if ($product->demo_url)
                            <a href="{{ $product->demo_url }}" target="_blank"
                                class="px-6 py-4 border-2 border-slate-300 text-slate-700 rounded-xl font-semibold hover:bg-[#FAF5E9] transition-colors">
                                Demo
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($product->long_description)
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Deskripsi Lengkap</h2>
                    <div class="prose prose-slate max-w-none">
                        {!! nl2br(e($product->long_description)) !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($product->versions->count() > 0)
        <section class="py-10 bg-[#FAF5E9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Riwayat Versi</h2>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="divide-y divide-slate-100">
                        @foreach ($product->versions->take(5) as $version)
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="px-3 py-1 bg-[#c8e6c9] text-[#007a3d] text-sm font-semibold rounded-full">v{{ $version->version }}</span>
                                        @if ($version->is_latest)
                                            <span
                                                class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Latest</span>
                                        @endif
                                    </div>
                                    <span
                                        class="text-sm text-slate-500">{{ $version->released_at?->format('d M Y') }}</span>
                                </div>
                                @if ($version->changelog)
                                    <p class="text-slate-600 mt-2 text-sm">{{ $version->changelog }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($relatedProducts->count() > 0)
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <article class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover border border-slate-100">
                            <a href="{{ route('front.product.detail', $related->slug) }}" class="block">
                                <div
                                    class="aspect-video bg-gradient-to-br from-[#e8f5e9] to-[#c8e6c9] relative overflow-hidden">
                                    @if ($related->thumbnail)
                                        <img src="{{ $related->thumbnail }}" alt="{{ $related->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <svg class="w-12 h-12 text-[#81c784]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('front.product.detail', $related->slug) }}">
                                    <h3
                                        class="font-bold text-slate-800 mb-1 hover:text-[#009B4D] transition-colors line-clamp-1">
                                        {{ $related->name }}</h3>
                                </a>
                                @if ($related->prices->first())
                                    <div class="font-bold text-[#009B4D]">
                                        Rp {{ number_format($related->prices->first()->price, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
