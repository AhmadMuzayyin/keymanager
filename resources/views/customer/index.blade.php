@extends('layouts.app')

@section('title', 'Kelola Customer')
@section('page-title', 'Kelola Customer')

@section('content')
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Customer</h1>
                <p class="text-slate-500 mt-1">Kelola data customer dan lisensi mereka</p>
            </div>
            <x-button-primary @click="$dispatch('open-modal', 'create-customer')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Tambah Customer
            </x-button-primary>
        </div>

        {{-- Search Bar --}}
        <div class="glass-card p-4">
            <form method="GET" action="{{ route('customers.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, email, atau nomor telepon..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
                    </div>
                </div>
                <x-button-secondary type="submit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </x-button-secondary>
            </form>
        </div>

        {{-- Customer Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($customers ?? [] as $customer)
                <div class="glass-card p-6 hover-lift group">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                                <span class="text-white font-bold text-lg">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800">{{ $customer->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $customer->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button type="button"
                                @click.prevent="$dispatch('open-modal', 'show-customer-{{ $customer->id }}')"
                                class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                title="Lihat">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                            <button type="button"
                                @click.prevent="$dispatch('open-modal', 'edit-customer-{{ $customer->id }}')"
                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xs text-slate-500 mb-1">Telepon</p>
                            <p class="text-sm font-medium text-slate-700">{{ $customer->phone ?? '-' }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xs text-slate-500 mb-1">Lisensi</p>
                            <p class="text-sm font-medium text-slate-700">{{ $customer->licenses_count }} lisensi</p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs text-slate-400">
                            Bergabung {{ $customer->created_at->format('d M Y') }}
                        </p>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus customer ini?')"
                                class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="glass-card p-16 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500 text-lg font-medium">Belum ada data customer</p>
                        <p class="text-slate-400 text-sm mt-1">Klik tombol "Tambah Customer" untuk menambahkan</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if (isset($customers) && $customers->hasPages())
            <div class="glass-card p-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    @include('customer.partials.create-modal')

    @foreach ($customers ?? [] as $customer)
        @include('customer.partials.edit-modal', ['customer' => $customer])
        @include('customer.partials.show-modal', ['customer' => $customer])
    @endforeach
@endsection
