@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        {{-- Welcome Banner --}}
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 text-white">
            <div class="absolute inset-0 bg-grid-white/10 bg-[size:20px_20px]"></div>
            <div class="relative z-10">
                <h1 class="text-2xl font-bold">Selamat Datang di Key Manager! 👋</h1>
                <p class="mt-2 text-indigo-100 max-w-xl">
                    Kelola lisensi, customer, dan pantau aktivitas aplikasi Anda dari satu dashboard yang powerful.
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('licenses.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl text-sm font-medium transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                        Kelola Lisensi
                    </a>
                    <a href="{{ route('customers.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl text-sm font-medium transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m12 5.197v1m-4-10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Kelola Customer
                    </a>
                </div>
            </div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Lisensi --}}
            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Lisensi</p>
                        <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalLicenses ?? 0 }}</p>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center flex-wrap gap-2 text-xs">
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-emerald-100 text-emerald-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                        {{ $activeLicenses ?? 0 }} aktif
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-amber-100 text-amber-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                        {{ $suspendedLicenses ?? 0 }} suspend
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                        {{ $revokedLicenses ?? 0 }} revoke
                    </span>
                </div>
            </div>

            {{-- Lisensi Aktif --}}
            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Lisensi Aktif</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $activeLicenses ?? 0 }}</p>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1.5">
                        <span>Persentase aktif</span>
                        <span
                            class="font-medium">{{ $totalLicenses > 0 ? round(($activeLicenses / $totalLicenses) * 100, 1) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-green-500 h-2 rounded-full transition-all duration-500"
                            style="width: {{ $totalLicenses > 0 ? round(($activeLicenses / $totalLicenses) * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Customer --}}
            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Customer</p>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalCustomers ?? 0 }}</p>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('customers.index') }}"
                        class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                        Kelola customer
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Log Hari Ini --}}
            <div class="glass-card p-6 hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Log Hari Ini</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $todayLogs ?? 0 }}</p>
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $validLogsToday ?? 0 }} valid
                    </span>
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">
                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ $invalidLogsToday ?? 0 }} invalid
                    </span>
                </div>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Statistik Pengecekan Lisensi</h3>
                        <p class="text-sm text-slate-500 mt-0.5">7 hari terakhir</p>
                    </div>
                    <a href="{{ route('logs.index') }}"
                        class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                        Lihat semua log
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if (!empty($chartData) && array_sum(array_column($chartData, 'count')) > 0)
                    <div class="flex items-end justify-between h-52 space-x-3">
                        @foreach ($chartData as $day)
                            <div class="flex-1 flex flex-col items-center group">
                                <div class="relative w-full flex flex-col items-center justify-end h-40">
                                    {{-- Tooltip --}}
                                    <div
                                        class="absolute -top-12 left-1/2 transform -translate-x-1/2 hidden group-hover:block z-10">
                                        <div
                                            class="bg-slate-800 text-white text-xs rounded-xl py-2 px-3 whitespace-nowrap shadow-xl">
                                            <div class="font-semibold mb-1">{{ $day['day'] }}</div>
                                            <div class="text-emerald-400">✓ {{ $day['valid'] }} valid</div>
                                            <div class="text-red-400">✗ {{ $day['invalid'] }} invalid</div>
                                            <div
                                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full">
                                                <div class="border-4 border-transparent border-t-slate-800"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Bar --}}
                                    <div class="w-full max-w-12 flex flex-col justify-end rounded-t-xl overflow-hidden"
                                        style="height: {{ max($day['percentage'], 5) }}%">
                                        @if ($day['count'] > 0)
                                            <div class="w-full bg-gradient-to-t from-emerald-600 to-emerald-400 transition-all duration-300"
                                                style="height: {{ $day['valid'] > 0 ? ($day['valid'] / $day['count']) * 100 : 0 }}%">
                                            </div>
                                            <div class="w-full bg-gradient-to-t from-red-500 to-red-400 transition-all duration-300"
                                                style="height: {{ $day['invalid'] > 0 ? ($day['invalid'] / $day['count']) * 100 : 0 }}%">
                                            </div>
                                        @else
                                            <div class="w-full bg-slate-200 rounded h-1"></div>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-sm text-slate-600 mt-3 font-medium">{{ $day['label'] }}</span>
                                <span class="text-xs text-slate-400">{{ $day['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-center space-x-6 mt-6 pt-4 border-t border-slate-100">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gradient-to-r from-emerald-500 to-emerald-400 rounded mr-2"></div>
                            <span class="text-sm text-slate-600">Valid</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gradient-to-r from-red-500 to-red-400 rounded mr-2"></div>
                            <span class="text-sm text-slate-600">Invalid</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500">Belum ada data statistik minggu ini</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Lisensi Akan Expired --}}
            <div class="glass-card overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Lisensi Akan Expired</h3>
                            <p class="text-sm text-slate-500 mt-0.5">30 hari ke depan</p>
                        </div>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 text-sm font-bold text-amber-700 bg-amber-100 rounded-xl">
                            {{ count($expiringLicenses ?? []) }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if (isset($expiringLicenses) && $expiringLicenses->count() > 0)
                        <div class="space-y-3">
                            @foreach ($expiringLicenses as $license)
                                <div
                                    class="flex items-center justify-between p-4 bg-amber-50/50 border border-amber-200/50 rounded-xl hover:bg-amber-50 transition-all group">
                                    <div class="flex-1">
                                        <p class="font-semibold text-slate-800">{{ $license->product_name }}</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            <code
                                                class="bg-white px-2 py-0.5 rounded-lg text-xs border border-slate-200 font-mono">{{ Str::limit($license->key, 25) }}</code>
                                        </p>
                                        @if ($license->customer)
                                            <p class="text-xs text-slate-500 mt-1.5">👤 {{ $license->customer->name }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-sm font-semibold text-amber-600">
                                            {{ $license->expires_at->diffForHumans() }}
                                        </p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $license->expires_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-5 pt-4 border-t border-slate-100">
                            <a href="{{ route('licenses.index') }}"
                                class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                                Lihat semua lisensi
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div
                                class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-emerald-600 font-medium">Tidak ada lisensi yang akan expired</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Log Aktivitas Terbaru --}}
            <div class="glass-card overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Log Aktivitas Terbaru</h3>
                            <p class="text-sm text-slate-500 mt-0.5">10 aktivitas terakhir</p>
                        </div>
                        <a href="{{ route('logs.index') }}"
                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                            Lihat semua
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                    @forelse ($recentLogs ?? [] as $log)
                        <div class="flex items-start space-x-4 p-4 hover:bg-slate-50/50 transition-colors">
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
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $log->license_product_name ?? ($log->request_domain ?? 'Unknown') }}
                                    </p>
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-lg {{ $log->status === 'valid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $log->status === 'valid' ? 'Valid' : 'Invalid' }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-500 mt-1">
                                    <code
                                        class="bg-slate-100 px-1.5 py-0.5 rounded text-xs font-mono">{{ Str::limit($log->license_key, 20) }}</code>
                                    <span class="mx-1.5">•</span>
                                    <span class="text-slate-400">{{ $log->ip_address }}</span>
                                </p>
                                @if ($log->status === 'invalid' && $log->invalid_reason)
                                    <p class="text-xs text-red-500 mt-1.5 bg-red-50 inline-block px-2 py-0.5 rounded-lg">
                                        {{ $log->invalid_reason }}
                                    </p>
                                @endif
                                <p class="text-xs text-slate-400 mt-1.5">
                                    {{ \Carbon\Carbon::parse($log->checked_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-slate-500">Belum ada log aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Customer Terbaru --}}
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Customer Terbaru</h3>
                        <p class="text-sm text-slate-500 mt-0.5">5 customer terakhir</p>
                    </div>
                    <a href="{{ route('customers.index') }}"
                        class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                        Kelola customer
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if (isset($recentCustomers) && $recentCustomers->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach ($recentCustomers as $customer)
                            <div
                                class="flex flex-col items-center p-5 bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-2xl hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer border border-slate-100">
                                <div
                                    class="h-14 w-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-3 shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                                    <span class="text-white font-bold text-lg">
                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                    </span>
                                </div>
                                <p class="text-sm font-semibold text-slate-800 text-center">
                                    {{ Str::limit($customer->name, 15) }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $customer->licenses_count }} lisensi</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500 mb-3">Belum ada customer</p>
                        <a href="{{ route('customers.index') }}"
                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium group">
                            Tambah customer pertama
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
