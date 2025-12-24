@extends('layouts.app')

@section('title', $product->name)
@section('page-title', 'Detail Produk')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center text-slate-600 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                <h2 class="text-2xl font-bold text-slate-800">{{ $product->name }}</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product) }}"
                    class="inline-flex items-center px-4 py-2.5 bg-amber-100 text-amber-700 rounded-xl hover:bg-amber-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-start space-x-4">
                        @if ($product->thumbnail)
                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                class="w-24 h-24 rounded-xl object-cover border border-slate-200">
                        @else
                            <div
                                class="w-24 h-24 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                @php
                                    $typeColors = [
                                        'android' => 'bg-green-100 text-green-700',
                                        'desktop' => 'bg-blue-100 text-blue-700',
                                        'web' => 'bg-purple-100 text-purple-700',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium {{ $typeColors[$product->type] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($product->type) }}
                                </span>
                                @if ($product->is_active)
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                                @if ($product->is_featured)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        ⭐ Unggulan
                                    </span>
                                @endif
                            </div>
                            <p class="text-slate-600">{{ $product->description ?: 'Tidak ada deskripsi' }}</p>
                            @if ($product->demo_url)
                                <a href="{{ $product->demo_url }}" target="_blank"
                                    class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mt-2 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                    Lihat Demo
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($product->long_description)
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <h4 class="font-semibold text-slate-800 mb-3">Deskripsi Lengkap</h4>
                            <div class="prose prose-slate max-w-none text-slate-600">
                                {!! nl2br(e($product->long_description)) !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="glass-card rounded-2xl p-6" x-data="{ openPriceModal: false }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Paket Harga</h3>
                        <button type="button" @click="openPriceModal = true"
                            class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">+ Tambah Harga</button>
                    </div>

                    {{-- Modal Tambah Harga --}}
                    <template x-teleport="body">
                        <div x-show="openPriceModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true"
                            @keydown.escape.window="openPriceModal = false">
                            {{-- Backdrop --}}
                            <div x-show="openPriceModal" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                                @click="openPriceModal = false">
                            </div>

                            {{-- Modal Container --}}
                            <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                                <div x-show="openPriceModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-90 translate-y-8" @click.stop
                                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-slate-800">Tambah Paket Harga</h3>
                                            <button type="button" @click="openPriceModal = false"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('products.prices.store', $product) }}" method="POST"
                                            class="space-y-4">
                                            @csrf
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama
                                                    Paket</label>
                                                <x-input type="text" name="name" required />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Harga
                                                    (Rp)</label>
                                                <x-input type="number" name="price" required />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Fitur (pisah
                                                    dengan koma)</label>
                                                <x-textarea name="features" rows="3"></x-textarea>
                                            </div>
                                            <div class="flex justify-end gap-2 pt-2">
                                                <button type="button" @click="openPriceModal = false"
                                                    class="px-4 py-2.5 text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                                                <x-button-primary type="submit">Simpan</x-button-primary>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    @if ($product->prices->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($product->prices as $price)
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-semibold text-slate-800">{{ $price->name }}</h4>
                                        <div class="flex items-center gap-1">
                                            <form action="{{ route('products.prices.destroy', $price) }}" method="POST"
                                                onsubmit="return confirm('Hapus harga ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-red-500 hover:text-red-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold text-indigo-600">
                                        Rp {{ number_format($price->price, 0, ',', '.') }}
                                    </p>
                                    @if ($price->features)
                                        <ul class="mt-3 space-y-1 text-sm text-slate-600">
                                            @foreach (explode(',', $price->features) as $feature)
                                                <li class="flex items-center">
                                                    <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{ trim($feature) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-slate-500 py-8">Belum ada paket harga</p>
                    @endif
                </div>

                <div class="glass-card rounded-2xl p-6" x-data="{ openVersionModal: false }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Versi</h3>
                        <button type="button" @click="openVersionModal = true"
                            class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">+ Tambah Versi</button>
                    </div>

                    {{-- Modal Tambah Versi --}}
                    <template x-teleport="body">
                        <div x-show="openVersionModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true"
                            @keydown.escape.window="openVersionModal = false">
                            {{-- Backdrop --}}
                            <div x-show="openVersionModal" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                                @click="openVersionModal = false">
                            </div>

                            {{-- Modal Container --}}
                            <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                                <div x-show="openVersionModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-90 translate-y-8" @click.stop
                                    class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-slate-800">Tambah Versi</h3>
                                            <button type="button" @click="openVersionModal = false"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('products.versions.store', $product) }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor
                                                    Versi</label>
                                                <x-input type="text" name="version" placeholder="1.0.0" required />
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-slate-700 mb-1">Changelog</label>
                                                <x-textarea name="changelog" rows="3"></x-textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">File
                                                    Download</label>
                                                <input type="file" name="file"
                                                    class="w-full px-4 py-2 border border-slate-300 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                            </div>
                                            <div>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="is_latest" value="1"
                                                        class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                                    <span class="ml-2 text-sm text-slate-700">Tandai sebagai versi
                                                        terbaru</span>
                                                </label>
                                            </div>
                                            <div class="flex justify-end gap-2 pt-2">
                                                <button type="button" @click="openVersionModal = false"
                                                    class="px-4 py-2.5 text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                                                <x-button-primary type="submit">Simpan</x-button-primary>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    @if ($product->versions->count() > 0)
                        <div class="space-y-3">
                            @foreach ($product->versions as $version)
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-slate-800">v{{ $version->version }}</span>
                                            @if ($version->is_latest)
                                                <span
                                                    class="px-2 py-0.5 text-xs bg-emerald-100 text-emerald-700 rounded-full">Latest</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $version->released_at?->format('d M Y') }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if ($version->download_url)
                                            <a href="{{ Storage::url($version->download_url) }}"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                        <form action="{{ route('products.versions.destroy', $version) }}" method="POST"
                                            onsubmit="return confirm('Hapus versi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-slate-500 py-8">Belum ada versi</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Kategori</h3>
                    @if ($product->categories->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->categories as $category)
                                <span class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 text-sm">Tidak ada kategori</p>
                    @endif
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Dibuat</dt>
                            <dd class="text-slate-800">{{ $product->created_at->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Diperbarui</dt>
                            <dd class="text-slate-800">{{ $product->updated_at->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Slug</dt>
                            <dd class="text-slate-800 font-mono text-xs">{{ $product->slug }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
