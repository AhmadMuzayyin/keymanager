@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Dasar</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <x-input type="text" name="name" :value="old('name', $product->name)" required />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Slug</label>
                        <x-input type="text" name="slug" :value="old('slug', $product->slug)" />
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Aplikasi <span
                                class="text-red-500">*</span></label>
                        <x-select name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="android" {{ old('type', $product->type) === 'android' ? 'selected' : '' }}>
                                Android</option>
                            <option value="desktop" {{ old('type', $product->type) === 'desktop' ? 'selected' : '' }}>
                                Desktop</option>
                            <option value="web" {{ old('type', $product->type) === 'web' ? 'selected' : '' }}>Web
                            </option>
                        </x-select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Singkat</label>
                        <x-textarea name="description"
                            rows="2">{{ old('description', $product->description) }}</x-textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Lengkap</label>
                        <x-textarea name="long_description"
                            rows="5">{{ old('long_description', $product->long_description) }}</x-textarea>
                        @error('long_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Thumbnail URL</label>
                        @if ($product->thumbnail)
                            <div class="mb-2">
                                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                    class="w-24 h-24 rounded-xl object-cover border border-slate-200">
                            </div>
                        @endif
                        <x-input type="url" name="thumbnail" :value="old('thumbnail', $product->thumbnail)"
                            placeholder="https://ik.imagekit.io/..." />
                        <p class="text-xs text-slate-500 mt-1">Upload gambar ke ImageKit atau hosting lain, lalu tempel
                            URL-nya di sini</p>
                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Demo URL</label>
                        <x-input type="url" name="demo_url" :value="old('demo_url', $product->demo_url)" placeholder="https://demo.example.com" />
                        @error('demo_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                        @if ($categories->count() > 0)
                            <div class="flex flex-wrap gap-3">
                                @foreach ($categories as $category)
                                    <label
                                        class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-xl cursor-pointer hover:bg-indigo-100 transition-colors has-[:checked]:bg-indigo-100 has-[:checked]:ring-2 has-[:checked]:ring-indigo-500">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-slate-700">
                                            @if ($category->icon)
                                                {{ $category->icon }}
                                            @endif
                                            {{ $category->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-center">
                                <p class="text-slate-500 text-sm">Belum ada kategori.</p>
                                <a href="{{ route('categories.index') }}"
                                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    Tambah kategori terlebih dahulu →
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-slate-700">Produk Aktif</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-slate-700">Produk Unggulan</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('products.index') }}"
                    class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <x-button-primary type="submit">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Produk
                </x-button-primary>
            </div>
        </form>
    </div>
@endsection
