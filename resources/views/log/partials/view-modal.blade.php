<x-modal id="view-log-{{ $log->id }}" title="Detail Log Aktivitas">
    <div class="space-y-4">
        {{-- License Information --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Lisensi (Snapshot)</h4>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">License Key:</span>
                    <code class="text-sm bg-white px-2 py-1 rounded border">{{ $log->license_key }}</code>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Produk:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $log->license_product_name ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Status Lisensi:</span>
                    @if ($log->license_status === 'active')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Aktif
                        </span>
                    @elseif($log->license_status === 'suspended')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Suspended
                        </span>
                    @elseif($log->license_status === 'revoked')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            Revoked
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            Unknown
                        </span>
                    @endif
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Domain Terdaftar:</span>
                    <span class="text-sm text-gray-900">{{ $log->license_domain ?? 'Universal' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Expired:</span>
                    <span class="text-sm text-gray-900">
                        {{ $log->license_expires_at ? date('d M Y', strtotime($log->license_expires_at)) : 'Lifetime' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Request Information --}}
        <div class="bg-blue-50 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Request</h4>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Domain Request:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $log->request_domain }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">IP Address:</span>
                    <span class="text-sm text-gray-900">{{ $log->ip_address }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">User Agent:</span>
                    <span class="text-sm text-gray-900 text-right max-w-xs truncate" title="{{ $log->user_agent }}">
                        {{ $log->user_agent }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Waktu Pengecekan:</span>
                    <span class="text-sm text-gray-900">{{ date('d M Y H:i:s', strtotime($log->checked_at)) }}</span>
                </div>
            </div>
        </div>

        {{-- Validation Result --}}
        <div class="{{ $log->status === 'valid' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Hasil Validasi</h4>

            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Status Validasi:</span>
                @if ($log->status === 'valid')
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-green-800">VALID</span>
                    </div>
                @else
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-red-800">INVALID</span>
                    </div>
                @endif
            </div>

            @if ($log->status === 'invalid' && $log->invalid_reason)
                <div class="mt-3 pt-3 border-t border-red-200">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">Alasan:</span>
                    </p>
                    <p class="mt-1 text-sm text-red-600 font-medium">
                        @switch($log->invalid_reason)
                            @case('license_not_found')
                                Lisensi tidak ditemukan di database
                            @break

                            @case('license_expired')
                                Lisensi sudah melewati tanggal expired
                            @break

                            @case('license_suspended')
                                Lisensi dalam status suspended
                            @break

                            @case('license_revoked')
                                Lisensi telah dicabut
                            @break

                            @case('domain_mismatch')
                                Domain request tidak sesuai dengan domain yang terdaftar
                                <br>
                                <span class="text-xs">(Terdaftar: {{ $log->license_domain ?? '-' }}, Request:
                                    {{ $log->request_domain }})</span>
                            @break

                            @default
                                {{ $log->invalid_reason }}
                        @endswitch
                    </p>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex justify-end pt-2">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'view-log-{{ $log->id }}')">
                Tutup
            </x-button-secondary>
        </div>
    </div>
</x-modal>
