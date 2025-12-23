@extends('layouts.app')

@section('title', 'Detail Log IP')
@section('page-title', 'Detail Log Aktivitas')

@section('content')
    <div class="mb-4">
        <a href="{{ route('logs.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke List
        </a>
    </div>

    {{-- Summary Card --}}
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Ringkasan Aktivitas</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">IP Address</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $ip }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                            </path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Request</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $summary->total ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Valid</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $summary->valid ?? 0 }}
                                <span
                                    class="text-sm text-gray-500">({{ $summary && $summary->total > 0 ? round(($summary->valid / $summary->total) * 100) : 0 }}%)</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Invalid</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $summary->invalid ?? 0 }}
                                <span
                                    class="text-sm text-gray-500">({{ $summary && $summary->total > 0 ? round(($summary->invalid / $summary->total) * 100) : 0 }}%)</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Domain</p>
                        <p class="text-base font-medium text-gray-900">{{ $summary->request_domain ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">User Agent</p>
                        <p class="text-base text-gray-900 truncate" title="{{ $summary->user_agent ?? '-' }}">
                            {{ $summary->user_agent ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Request History --}}
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Riwayat Request</h2>
                <form method="GET" class="flex space-x-2">
                    <select name="status"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="valid" {{ request('status') === 'valid' ? 'selected' : '' }}>Valid</option>
                        <option value="invalid" {{ request('status') === 'invalid' ? 'selected' : '' }}>Invalid</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($logs ?? [] as $log)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    @if ($log->status === 'valid')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            VALID
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            INVALID
                                        </span>
                                    @endif
                                    <span class="text-sm text-gray-500">
                                        {{ date('d M Y H:i:s', strtotime($log->checked_at)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">License Key</p>
                                    <code
                                        class="text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $log->license_key }}</code>
                                </div>
                                <div>
                                    <p class="text-gray-600">Produk</p>
                                    <p class="text-gray-900 font-medium">{{ $log->license_product_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Status Lisensi</p>
                                    @if ($log->license_status === 'active')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @elseif($log->license_status === 'suspended')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Suspended
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $log->license_status ?? 'Unknown' }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-gray-600">Domain Terdaftar</p>
                                    <p class="text-gray-900">{{ $log->license_domain ?? 'Universal' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Expired</p>
                                    <p class="text-gray-900">
                                        {{ $log->license_expires_at ? date('d M Y', strtotime($log->license_expires_at)) : 'Lifetime' }}
                                    </p>
                                </div>
                                @if ($log->status === 'invalid' && $log->invalid_reason)
                                    <div>
                                        <p class="text-gray-600">Alasan Invalid</p>
                                        <p class="text-red-600 font-medium">
                                            @switch($log->invalid_reason)
                                                @case('license_not_found')
                                                    Lisensi tidak ditemukan
                                                @break

                                                @case('license_expired')
                                                    Lisensi sudah expired
                                                @break

                                                @case('license_suspended')
                                                    Lisensi di-suspend
                                                @break

                                                @case('license_revoked')
                                                    Lisensi dicabut
                                                @break

                                                @case('domain_mismatch')
                                                    Domain tidak sesuai
                                                @break

                                                @default
                                                    {{ $log->invalid_reason }}
                                            @endswitch
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <button type="button"
                                @click.prevent="$dispatch('open-modal', 'view-log-{{ $log->id }}')"
                                class="mt-3 text-sm text-blue-600 hover:text-blue-800">
                                Lihat Detail Lengkap →
                            </button>
                        </div>
                    </div>
                </div>

                @include('log.partials.view-modal')
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        Tidak ada log untuk IP ini.
                    </div>
                @endforelse
            </div>

            @if (isset($logs) && $logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    @endsection
