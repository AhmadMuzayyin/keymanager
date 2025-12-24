<x-modal id="view-log-{{ $log->id }}" title="Detail Log #{{ $log->id }}" maxWidth="2xl">
    <div class="space-y-6">
        {{-- Status Header --}}
        <div
            class="flex items-center justify-between p-4 rounded-xl {{ $log->status === 'valid' ? 'bg-emerald-50 border border-emerald-100' : 'bg-red-50 border border-red-100' }}">
            @if ($log->status === 'valid')
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-emerald-100 text-emerald-700">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    VALID
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-red-100 text-red-700">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    INVALID
                </span>
            @endif
            <span class="text-sm text-slate-500">
                {{ date('d M Y H:i:s', strtotime($log->checked_at)) }}
            </span>
        </div>

        {{-- License Info --}}
        <div class="bg-slate-50 rounded-xl p-5">
            <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
                Informasi Lisensi
            </h4>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">License Key</p>
                    <code class="text-sm text-slate-800 font-mono break-all">{{ $log->license_key }}</code>
                </div>
                <div class="bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Produk</p>
                    <p class="text-sm font-medium text-slate-800">{{ $log->license_product_name ?? 'N/A' }}</p>
                </div>
                <div class="bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Status Lisensi</p>
                    @if ($log->license_status === 'active')
                        <span
                            class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-700">Aktif</span>
                    @elseif($log->license_status === 'suspended')
                        <span
                            class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-lg bg-amber-100 text-amber-700">Suspended</span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-lg bg-red-100 text-red-700">{{ $log->license_status ?? 'Unknown' }}</span>
                    @endif
                </div>
                <div class="bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Domain Terdaftar</p>
                    <p class="text-sm text-slate-800">{{ $log->license_domain ?? 'Universal' }}</p>
                </div>
                <div class="col-span-2 bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Expired</p>
                    <p class="text-sm text-slate-800">
                        {{ $log->license_expires_at ? date('d M Y', strtotime($log->license_expires_at)) : '∞ Lifetime' }}
                    </p>
                </div>
            </div>

            @if ($log->status === 'invalid' && $log->invalid_reason)
                <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100">
                    <p class="text-xs text-slate-600 mb-1">Alasan Invalid</p>
                    <p class="text-sm text-red-700 font-semibold">
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

        {{-- Request Info --}}
        <div class="bg-slate-50 rounded-xl p-5">
            <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                    </path>
                </svg>
                Informasi Request
            </h4>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">IP Address</p>
                    <code class="text-sm text-slate-800 font-mono">{{ $log->ip_address }}</code>
                </div>
                <div class="bg-white rounded-lg p-3 border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Request Domain</p>
                    <p class="text-sm text-slate-800">{{ $log->request_domain ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-4 bg-white rounded-lg p-3 border border-slate-100">
                <p class="text-xs text-slate-500 mb-1">User Agent</p>
                <p class="text-xs text-slate-700 break-all">{{ $log->user_agent ?? '-' }}</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex justify-end pt-2">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'view-log-{{ $log->id }}')">
                Tutup
            </x-button-secondary>
        </div>
    </div>
</x-modal>
