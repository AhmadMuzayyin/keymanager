<x-modal id="show-customer-{{ $customer->id }}" title="Detail Customer" maxWidth="2xl">
    <div class="space-y-6">
        {{-- Customer Header --}}
        <div
            class="flex items-start gap-4 p-5 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100">
            <div
                class="h-16 w-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <span class="text-white font-bold text-xl">
                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                </span>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-slate-800">{{ $customer->name }}</h3>
                <div class="mt-2 space-y-1">
                    <p class="text-slate-600 flex items-center text-sm">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $customer->email }}
                    </p>
                    @if ($customer->phone)
                        <p class="text-slate-600 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            {{ $customer->phone }}
                        </p>
                    @endif
                </div>
                <p class="text-slate-500 text-xs mt-2">
                    Bergabung sejak {{ $customer->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        {{-- License Section --}}
        <div class="border-t border-slate-100 pt-6">
            <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
                Lisensi Dimiliki ({{ $customer->licenses->count() }})
            </h4>

            @if ($customer->licenses->count() > 0)
                <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                    @foreach ($customer->licenses as $license)
                        <div
                            class="bg-slate-50 rounded-xl p-4 border border-slate-100 hover:bg-slate-100/50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span
                                            class="text-sm font-semibold text-slate-800">{{ $license->product_name }}</span>
                                        @if ($license->status === 'active')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-700">
                                                <span class="w-1 h-1 rounded-full bg-emerald-500 mr-1"></span>
                                                Aktif
                                            </span>
                                        @elseif($license->status === 'suspended')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-lg bg-amber-100 text-amber-700">
                                                <span class="w-1 h-1 rounded-full bg-amber-500 mr-1"></span>
                                                Suspended
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-lg bg-red-100 text-red-700">
                                                <span class="w-1 h-1 rounded-full bg-red-500 mr-1"></span>
                                                Revoked
                                            </span>
                                        @endif
                                    </div>
                                    <code
                                        class="text-xs text-slate-500 font-mono bg-white px-2 py-1 rounded-lg border border-slate-200">{{ Str::limit($license->key, 30) }}</code>
                                    <div class="mt-2 flex items-center gap-4 text-xs text-slate-500">
                                        <span>{{ $license->domain ?? 'Universal' }}</span>
                                        <span>•</span>
                                        <span>{{ $license->expires_at ? $license->expires_at->format('d M Y') : '∞ Lifetime' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-slate-50 rounded-xl">
                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-slate-500 text-sm">Belum memiliki lisensi</p>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'show-customer-{{ $customer->id }}')">
                Tutup
            </x-button-secondary>
            <x-button-primary type="button"
                @click="$dispatch('close-modal', 'show-customer-{{ $customer->id }}'); $dispatch('open-modal', 'edit-customer-{{ $customer->id }}')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit
            </x-button-primary>
        </div>
    </div>
</x-modal>
