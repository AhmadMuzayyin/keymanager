@extends('layouts.app')

@section('title', 'Kategori Produk')
@section('page-title', 'Kategori')

@section('content')
    <div class="space-y-6" x-data="{
        showCreateModal: false,
        showEditModal: false,
        editData: { id: null, name: '', slug: '', icon: '' }
    }">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Kategori Produk</h2>
                <p class="text-slate-500 mt-1">Kelola kategori untuk mengelompokkan produk</p>
            </div>
            <button @click="showCreateModal = true"
                class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </button>
        </div>

        <div class="glass-card rounded-2xl p-4 sm:p-6">
            <form action="{{ route('categories.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <x-input type="text" name="search" placeholder="Cari kategori..." :value="request('search')" />
                </div>
                <div class="flex gap-2">
                    <x-button-primary type="submit">Cari</x-button-primary>
                    <a href="{{ route('categories.index') }}"
                        class="px-4 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                        Reset
                    </a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Nama</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Slug</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Ikon</th>
                            <th class="text-left py-4 px-4 font-semibold text-slate-700">Jumlah Produk</th>
                            <th class="text-right py-4 px-4 font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-slate-800">{{ $category->name }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-slate-600 font-mono text-sm">{{ $category->slug }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($category->icon)
                                        <span class="text-2xl">{{ $category->icon }}</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button type="button"
                                            @click="editData = { id: {{ $category->id }}, name: '{{ $category->name }}', slug: '{{ $category->slug }}', icon: '{{ $category->icon }}' }; showEditModal = true"
                                            class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">Belum ada kategori</p>
                                        <p class="text-slate-400 text-sm mt-1">Mulai dengan menambahkan kategori baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="mt-6 border-t border-slate-200 pt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showCreateModal = false"></div>
                <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" @click.stop>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Tambah Kategori</h3>
                        <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                            <x-input type="text" name="name" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Slug (opsional)</label>
                            <x-input type="text" name="slug" placeholder="auto-generated" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ikon (emoji)</label>
                            <x-input type="text" name="icon" placeholder="📱" />
                        </div>
                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="showCreateModal = false"
                                class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                            <x-button-primary type="submit">Simpan</x-button-primary>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showEditModal = false"></div>
                <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" @click.stop>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Edit Kategori</h3>
                        <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form :action="'{{ route('categories.index') }}/' + editData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                            <input type="text" name="name" x-model="editData.name" required
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                            <input type="text" name="slug" x-model="editData.slug"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ikon (emoji)</label>
                            <input type="text" name="icon" x-model="editData.icon" placeholder="📱"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="showEditModal = false"
                                class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                            <x-button-primary type="submit">Update</x-button-primary>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
