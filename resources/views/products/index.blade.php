@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Produk')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Produk</h2>
                <p class="text-slate-500 mt-1">Kelola produk aplikasi yang dijual</p>
            </div>
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk
            </a>
        </div>

        <div class="glass-card rounded-2xl p-4 sm:p-6">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <x-input type="text" name="search" placeholder="Cari produk..." :value="request('search')" />
                </div>
                <div class="w-full sm:w-40">
                    <x-select name="type">
                        <option value="">Semua Tipe</option>
                        <option value="android" {{ request('type') === 'android' ? 'selected' : '' }}>Android</option>
                        <option value="desktop" {{ request('type') === 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="web" {{ request('type') === 'web' ? 'selected' : '' }}>Web</option>
                    </x-select>
                </div>
                <div class="w-full sm:w-40">
                    <x-select name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </x-select>
                </div>
                <div class="flex gap-2">
                    <x-button-primary type="submit">Filter</x-button-primary>
                    <a href="{{ route('products.index') }}"
                        class="px-4 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                        Reset
                    </a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Produk</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Tipe</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Harga</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Kategori</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Status</th>
                            <th class="text-right py-4 px-4 font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3">
                                        @if ($product->thumbnail)
                                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                                class="w-12 h-12 rounded-xl object-cover border border-slate-200">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $product->name }}</p>
                                            <p class="text-sm text-slate-500">{{ Str::limit($product->description, 40) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
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
                                </td>
                                <td class="py-4 px-4">
                                    @if ($product->lowestPrice())
                                        <span class="font-semibold text-slate-800">
                                            Rp {{ number_format($product->lowestPrice()->price, 0, ',', '.') }}
                                        </span>
                                        @if ($product->prices->count() > 1)
                                            <span class="text-xs text-slate-500">+{{ $product->prices->count() - 1 }}
                                                lainnya</span>
                                        @endif
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($product->categories->take(2) as $category)
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs">
                                                {{ $category->name }}
                                            </span>
                                        @empty
                                            <span class="text-slate-400">-</span>
                                        @endforelse
                                        @if ($product->categories->count() > 2)
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs">
                                                +{{ $product->categories->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($product->is_active)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
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
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">Belum ada produk</p>
                                        <p class="text-slate-400 text-sm mt-1">Mulai dengan menambahkan produk baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="mt-6 border-t border-slate-200 pt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
