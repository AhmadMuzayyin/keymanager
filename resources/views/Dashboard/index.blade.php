@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Lisensi --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Lisensi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalLicenses ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('licenses.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat semua →
                    </a>
                </div>
            </div>

            {{-- Lisensi Aktif --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Lisensi Aktif</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $activeLicenses ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        {{ $activeLicenses > 0 ? round(($activeLicenses / max($totalLicenses, 1)) * 100, 1) : 0 }}% dari
                        total
                    </span>
                </div>
            </div>

            {{-- Lisensi Suspended --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Suspended</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $suspendedLicenses ?? 0 }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">
                        {{ $suspendedLicenses > 0 ? round(($suspendedLicenses / max($totalLicenses, 1)) * 100, 1) : 0 }}%
                        dari total
                    </span>
                </div>
            </div>

            {{-- Total Log Hari Ini --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Log Hari Ini</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $todayLogs ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('logs.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                        Lihat log →
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Lisensi Akan Expired --}}
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Lisensi Akan Expired</h3>
                    <p class="text-sm text-gray-500 mt-1">30 hari ke depan</p>
                </div>
                <div class="p-6">
                    @if (isset($expiringLicenses) && $expiringLicenses->count() > 0)
                        <div class="space-y-3">
                            @foreach ($expiringLicenses as $license)
                                <div
                                    class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $license->product_name }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <code
                                                class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $license->key }}</code>
                                        </p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-sm font-medium text-yellow-700">
                                            {{ $license->expires_at->diffForHumans() }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $license->expires_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Tidak ada lisensi yang akan expired</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Log Aktivitas Terbaru --}}
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Log Aktivitas Terbaru</h3>
                    <p class="text-sm text-gray-500 mt-1">10 aktivitas terakhir</p>
                </div>
                <div class="p-6">
                    @if (isset($recentLogs) && $recentLogs->count() > 0)
                        <div class="space-y-3">
                            @foreach ($recentLogs as $log)
                                <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex-shrink-0">
                                        @if ($log->status === 'valid')
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $log->domain ?? 'Unknown' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ Str::limit($log->license_key, 20) }} • {{ $log->ip_address }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ date('d M Y H:i:s', strtotime($log->checked_at)) }}
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $log->status === 'valid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $log->status === 'valid' ? 'Valid' : 'Invalid' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p>Belum ada log aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Chart Section (Optional) --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Statistik Pengecekan Lisensi</h3>
                <p class="text-sm text-gray-500 mt-1">7 hari terakhir</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-7 gap-2 h-48">
                    @foreach ($chartData ?? [] as $day)
                        <div class="flex flex-col items-center justify-end">
                            <div class="w-full bg-blue-200 rounded-t hover:bg-blue-300 transition"
                                style="height: {{ $day['percentage'] }}%" title="{{ $day['count'] }} pengecekan">
                            </div>
                            <span class="text-xs text-gray-600 mt-2">{{ $day['label'] }}</span>
                            <span class="text-xs font-semibold text-gray-800">{{ $day['count'] }}</span>
                        </div>
                    @endforeach
                </div>
                @if (empty($chartData))
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <p>Belum ada data statistik</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
            <h3 class="text-xl font-semibold mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('licenses.index') }}"
                    class="flex items-center p-4 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <div>
                        <p class="font-semibold">Tambah Lisensi</p>
                        <p class="text-sm opacity-90">Buat lisensi baru</p>
                    </div>
                </a>
                <a href="{{ route('logs.index') }}"
                    class="flex items-center p-4 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <div>
                        <p class="font-semibold">Lihat Log</p>
                        <p class="text-sm opacity-90">Monitor aktivitas</p>
                    </div>
                </a>
                <a href="{{ route('licenses.index') }}"
                    class="flex items-center p-4 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold">Pengaturan</p>
                        <p class="text-sm opacity-90">Konfigurasi sistem</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
