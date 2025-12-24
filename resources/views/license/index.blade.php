@extends('layouts.app')

@section('title', 'Kelola Lisensi')
@section('page-title', 'Kelola Lisensi')

@section('content')
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Lisensi</h1>
                <p class="text-slate-500 mt-1">Kelola semua lisensi aplikasi Anda</p>
            </div>
            <x-button-primary @click="$dispatch('open-modal', 'create-license')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Lisensi
            </x-button-primary>
        </div>

        {{-- Filter & Search --}}
        <div class="glass-card p-4">
            <form method="GET" action="{{ route('licenses.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari lisensi, customer, atau produk..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
                    </div>
                </div>
                <div class="flex gap-3">
                    <select name="status"
                        class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended
                        </option>
                        <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                    </select>
                    <x-button-secondary type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filter
                    </x-button-secondary>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                License Key / Purchase Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Expired</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($licenses ?? [] as $license)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2">
                                            <code
                                                class="text-sm bg-slate-100 px-2.5 py-1 rounded-lg font-mono text-slate-700">{{ Str::limit($license->key, 30) }}</code>
                                            <button onclick="navigator.clipboard.writeText('{{ $license->key }}')"
                                                class="p-1 text-slate-400 hover:text-indigo-600 transition-colors"
                                                title="Copy">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        @if ($license->purchase_code)
                                            <code
                                                class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-lg font-mono">{{ $license->purchase_code }}</code>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md shadow-indigo-500/20">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $license->product_name }}</p>
                                            <p class="text-xs text-slate-500">{{ $license->domain ?? 'Universal' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($license->customer)
                                        <a href="{{ route('customers.show', $license->customer) }}"
                                            class="inline-flex items-center gap-2 group">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-md shadow-emerald-500/20">
                                                {{ strtoupper(substr($license->customer->name, 0, 2)) }}
                                            </div>
                                            <span
                                                class="text-sm text-slate-700 group-hover:text-indigo-600 transition-colors">{{ $license->customer->name }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($license->expires_at)
                                        <div>
                                            <p class="text-sm font-medium text-slate-700">
                                                {{ $license->expires_at->format('d M Y') }}</p>
                                            <p
                                                class="text-xs {{ $license->expires_at->isPast() ? 'text-red-500' : ($license->expires_at->diffInDays(now()) <= 30 ? 'text-amber-500' : 'text-slate-400') }}">
                                                {{ $license->expires_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-medium">
                                            ∞ Lifetime
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($license->status === 'active')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Aktif
                                        </span>
                                    @elseif ($license->status === 'suspended')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-lg bg-amber-100 text-amber-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                            Suspended
                                        </span>
                                    @elseif ($license->status === 'revoked')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-lg bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                            Revoked
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                            @click.prevent="$dispatch('open-modal', 'edit-license-{{ $license->id }}')"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('licenses.destroy', $license->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus lisensi ini?')"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Hapus">
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
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 text-lg font-medium">Belum ada data lisensi</p>
                                        <p class="text-slate-400 text-sm mt-1">Klik tombol "Tambah Lisensi" untuk membuat
                                            lisensi baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (isset($licenses) && $licenses->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $licenses->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('license.parts.create-modal')

    @foreach ($licenses ?? [] as $license)
        @include('license.parts.edit-modal', ['license' => $license])
    @endforeach
@endsection
