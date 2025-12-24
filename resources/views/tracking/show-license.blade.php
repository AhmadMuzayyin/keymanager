<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lisensi - Key Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        {{-- Back Button --}}
        <a href="{{ route('tracking.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>

        {{-- License Info Card --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            {{-- Header --}}
            <div
                class="px-6 py-4 {{ $license->status === 'active' ? 'bg-green-500' : ($license->status === 'suspended' ? 'bg-yellow-500' : 'bg-red-500') }}">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-white">{{ $license->product_name }}</h1>
                        <p class="text-white/80 text-sm">Purchase Code: {{ $license->purchase_code }}</p>
                    </div>
                    <div class="text-right">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-white/20 text-white">
                            @if ($license->status === 'active')
                                ✓ Aktif
                            @elseif ($license->status === 'suspended')
                                ⏸ Suspended
                            @else
                                ✗ Revoked
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6">
                {{-- License Key --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">License Key</label>
                    <div class="flex items-center space-x-2">
                        <code id="license-key"
                            class="flex-1 bg-gray-100 px-4 py-3 rounded-lg text-sm font-mono text-gray-800 select-all">{{ $license->key }}</code>
                        <button onclick="copyToClipboard()" type="button"
                            class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <p id="copy-message" class="mt-2 text-sm text-green-600 hidden">✓ License key berhasil disalin!</p>
                </div>

                {{-- Details --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Domain Terdaftar</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $license->domain ?? 'Universal (Semua Domain)' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Masa Berlaku</p>
                        <p class="text-lg font-medium text-gray-900">
                            @if ($license->expires_at)
                                {{ $license->expires_at->format('d M Y') }}
                                @if ($license->expires_at->isPast())
                                    <span class="text-red-600 text-sm">(Expired)</span>
                                @elseif ($license->expires_at->diffInDays(now()) <= 7)
                                    <span class="text-yellow-600 text-sm">({{ $license->expires_at->diffInDays(now()) }}
                                        hari lagi)</span>
                                @endif
                            @else
                                Lifetime
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Maks. Aktivasi</p>
                        <p class="text-lg font-medium text-gray-900">{{ $license->max_activations }} device</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">Status</p>
                        <p
                            class="text-lg font-medium {{ $license->status === 'active' ? 'text-green-600' : ($license->status === 'suspended' ? 'text-yellow-600' : 'text-red-600') }}">
                            @if ($license->status === 'active')
                                Aktif
                            @elseif ($license->status === 'suspended')
                                Suspended
                            @else
                                Revoked
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Customer Info --}}
                @if ($license->customer)
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Pemilik Lisensi</h3>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <span class="text-blue-600 font-semibold text-sm">
                                    {{ strtoupper(substr($license->customer->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-900 font-medium">{{ $license->customer->name }}</p>
                                <p class="text-gray-500 text-sm">{{ $license->customer->email }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Recent Activity --}}
                @if ($recentLogs->count() > 0)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Aktivitas Terakhir</h3>
                        <div class="space-y-3">
                            @foreach ($recentLogs as $log)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center">
                                        @if ($log->status === 'valid')
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                        @else
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                                        @endif
                                        <span class="text-gray-600">{{ $log->request_domain }}</span>
                                    </div>
                                    <span class="text-gray-400">{{ $log->checked_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Help Text --}}
        <p class="text-center text-sm text-gray-500 mt-6">
            Ada masalah dengan lisensi Anda?
            <a href="mailto:support@example.com" class="text-blue-600 hover:underline">Hubungi Support</a>
        </p>
    </div>

    <script>
        function copyToClipboard() {
            const licenseKey = document.getElementById('license-key').textContent;
            navigator.clipboard.writeText(licenseKey).then(() => {
                const message = document.getElementById('copy-message');
                message.classList.remove('hidden');
                setTimeout(() => {
                    message.classList.add('hidden');
                }, 2000);
            });
        }
    </script>
</body>

</html>
