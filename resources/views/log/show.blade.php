@extends('layouts.app')

@section('title', 'Detail Log IP')
@section('page-title', 'Detail Log Aktivitas')

@section('content')
    <div class="space-y-6">
        {{-- Back Button --}}
        <a href="{{ route('logs.index') }}"
            class="inline-flex items-center text-slate-600 hover:text-indigo-600 group transition-colors">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke List
        </a>

        {{-- Summary Cards --}}
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <h2 class="text-lg font-semibold text-slate-800">Ringkasan Aktivitas</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- IP Address --}}
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">IP Address</p>
                                <p class="text-lg font-bold text-slate-800 font-mono">{{ $ip }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Request --}}
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-5 border border-purple-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Total Request</p>
                                <p class="text-2xl font-bold text-slate-800">{{ $summary->total ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Valid --}}
                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-5 border border-emerald-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Valid</p>
                                <p class="text-2xl font-bold text-emerald-600">{{ $summary->valid ?? 0 }}
                                    <span
                                        class="text-sm font-normal text-slate-500">({{ $summary && $summary->total > 0 ? round(($summary->valid / $summary->total) * 100) : 0 }}%)</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Invalid --}}
                    <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl p-5 border border-red-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/20">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Invalid</p>
                                <p class="text-2xl font-bold text-red-600">{{ $summary->invalid ?? 0 }}
                                    <span
                                        class="text-sm font-normal text-slate-500">({{ $summary && $summary->total > 0 ? round(($summary->invalid / $summary->total) * 100) : 0 }}%)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-sm text-slate-500 mb-1">Domain</p>
                        <p class="text-base font-semibold text-slate-800">{{ $summary->request_domain ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-sm text-slate-500 mb-1">User Agent</p>
                        <p class="text-sm text-slate-700 truncate" title="{{ $summary->user_agent ?? '-' }}">
                            {{ $summary->user_agent ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Request History --}}
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-slate-800">Riwayat Request</h2>
                    <form method="GET" class="flex gap-3">
                        <input type="hidden" name="ip" value="{{ $ip }}">
                        <select name="status"
                            class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            <option value="">Semua Status</option>
                            <option value="valid" {{ request('status') === 'valid' ? 'selected' : '' }}>Valid</option>
                            <option value="invalid" {{ request('status') === 'invalid' ? 'selected' : '' }}>Invalid
                            </option>
                        </select>
                        <x-button-secondary type="submit">
                            Filter
                        </x-button-secondary>
                    </form>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($logs ?? [] as $log)
                    <div class="p-6 hover:bg-slate-50/50 transition-colors">
                        <div class="flex items-start gap-4">
                            {{-- Status Icon --}}
                            <div class="flex-shrink-0">
                                @if ($log->status === 'valid')
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-md shadow-emerald-500/20">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-md shadow-red-500/20">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        @if ($log->status === 'valid')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                VALID
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700">
                                                INVALID
                                            </span>
                                        @endif
                                        <span class="text-sm text-slate-500">
                                            {{ date('d M Y H:i:s', strtotime($log->checked_at)) }}
                                        </span>
                                    </div>
                                    <button type="button"
                                        @click="$dispatch('open-modal', 'view-log-{{ $log->id }}')"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                        Detail
                                    </button>
                                </div>

                                {{-- License Info --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div class="bg-slate-50 rounded-xl p-3">
                                        <p class="text-xs text-slate-500 mb-1">License Key</p>
                                        <code
                                            class="text-xs font-mono text-slate-700">{{ Str::limit($log->license_key, 20) }}</code>
                                    </div>
                                    <div class="bg-slate-50 rounded-xl p-3">
                                        <p class="text-xs text-slate-500 mb-1">Produk</p>
                                        <p class="text-sm font-medium text-slate-700">
                                            {{ $log->license_product_name ?? '-' }}</p>
                                    </div>
                                    <div class="bg-slate-50 rounded-xl p-3">
                                        <p class="text-xs text-slate-500 mb-1">Domain Request</p>
                                        <p class="text-sm text-slate-700">{{ $log->request_domain ?? '-' }}</p>
                                    </div>
                                    <div class="bg-slate-50 rounded-xl p-3">
                                        <p class="text-xs text-slate-500 mb-1">Status Lisensi</p>
                                        <p class="text-sm text-slate-700">{{ $log->license_status ?? '-' }}</p>
                                    </div>
                                </div>

                                @if ($log->status === 'invalid' && $log->invalid_reason)
                                    <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-xl">
                                        <p class="text-sm text-red-600">
                                            <span class="font-medium">Alasan:</span> {{ $log->invalid_reason }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- View Modal --}}
                    @include('log.partials.view-modal', ['log' => $log])
                @empty
                    <div class="p-16 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500 text-lg font-medium">Tidak ada riwayat request</p>
                    </div>
                @endforelse
            </div>

            @if (isset($logs) && $logs->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $logs->appends(['ip' => $ip])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
