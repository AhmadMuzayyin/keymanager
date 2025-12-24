@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

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

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Dasar</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <x-input type="text" name="name" :value="old('name')" required />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Slug</label>
                        <x-input type="text" name="slug" :value="old('slug')" placeholder="auto-generated" />
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Aplikasi <span
                                class="text-red-500">*</span></label>
                        <x-select name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="android" {{ old('type') === 'android' ? 'selected' : '' }}>Android</option>
                            <option value="desktop" {{ old('type') === 'desktop' ? 'selected' : '' }}>Desktop</option>
                            <option value="web" {{ old('type') === 'web' ? 'selected' : '' }}>Web</option>
                        </x-select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Singkat</label>
                        <x-textarea name="description" rows="2">{{ old('description') }}</x-textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Lengkap</label>
                        <x-textarea name="long_description" rows="5">{{ old('long_description') }}</x-textarea>
                        @error('long_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Thumbnail URL</label>
                        <x-input type="url" name="thumbnail" :value="old('thumbnail')"
                            placeholder="https://ik.imagekit.io/..." />
                        <p class="text-xs text-slate-500 mt-1">Upload gambar ke ImageKit atau hosting lain, lalu tempel
                            URL-nya di sini</p>
                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Demo URL</label>
                        <x-input type="url" name="demo_url" :value="old('demo_url')" placeholder="https://demo.example.com" />
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
                                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
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
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-slate-700">Produk Aktif</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-slate-700">Produk Unggulan</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6" x-data="{ prices: [{ name: '', price: '', features: '' }] }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">Paket Harga</h3>
                    <button type="button" @click="prices.push({ name: '', price: '', features: '' })"
                        class="inline-flex items-center px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Harga
                    </button>
                </div>

                <template x-for="(price, index) in prices" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-xl mb-4">
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Paket</label>
                            <input type="text" :name="'prices[' + index + '][name]'" x-model="price.name"
                                placeholder="Contoh: Basic"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                            <input type="number" :name="'prices[' + index + '][price]'" x-model="price.price"
                                placeholder="0"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div class="md:col-span-5">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Fitur (pisah dengan koma)</label>
                            <input type="text" :name="'prices[' + index + '][features]'" x-model="price.features"
                                placeholder="Fitur 1, Fitur 2, ..."
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <button type="button" @click="prices.splice(index, 1)" x-show="prices.length > 1"
                                class="p-2.5 text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
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
                    Simpan Produk
                </x-button-primary>
            </div>
        </form>
    </div>
@endsection
