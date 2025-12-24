<x-modal id="edit-license-{{ $license->id }}" title="Edit Lisensi" maxWidth="xl">
    <form action="{{ route('licenses.update', $license->id) }}" method="POST" x-data="{
        licensePlan: '{{ $license->license_plan ?? 'starter' }}',
        customType: 'months',
        customValue: 1
    }">
        @csrf
        @method('PATCH')

        <div class="space-y-5">
            {{-- License Key Display --}}
            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border border-indigo-100">
                <label class="block text-xs font-medium text-slate-500 mb-1">License Key</label>
                <div class="flex items-center gap-2">
                    <code class="text-sm font-mono text-slate-800 break-all">{{ $license->key }}</code>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $license->key }}')"
                        class="p-1.5 text-indigo-500 hover:bg-indigo-100 rounded-lg transition-colors" title="Copy">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Customer Select --}}
            <div>
                <label for="customer_id_edit_{{ $license->id }}"
                    class="block text-sm font-medium text-slate-700 mb-1.5">Customer (Opsional)</label>
                <select name="customer_id" id="customer_id_edit_{{ $license->id }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
                    <option value="">-- Pilih Customer --</option>
                    @foreach (\App\Models\Customer::orderBy('name')->get() as $customer)
                        <option value="{{ $customer->id }}"
                            {{ $license->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} ({{ $customer->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <x-input label="Produk" name="product" type="text" required :value="$license->product_name"
                placeholder="Nama produk" />

            <x-input label="Domain" name="domain" type="text" :value="$license->domain"
                placeholder="example.com (kosongkan untuk universal)" />

            {{-- License Plan --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Paket Lisensi <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 transition-all"
                        :class="licensePlan === 'starter' ? 'border-indigo-500 bg-indigo-50 shadow-md shadow-indigo-500/10' :
                            'border-slate-200 hover:bg-slate-50 hover:border-slate-300'">
                        <input type="radio" name="license_plan" value="starter" class="sr-only" x-model="licensePlan">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                :class="licensePlan === 'starter' ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-500'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold"
                                    :class="licensePlan === 'starter' ? 'text-indigo-900' : 'text-slate-800'">Starter</span>
                                <span class="text-xs"
                                    :class="licensePlan === 'starter' ? 'text-indigo-600' : 'text-slate-500'">1
                                    Tahun</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 transition-all"
                        :class="licensePlan === 'pro' ? 'border-indigo-500 bg-indigo-50 shadow-md shadow-indigo-500/10' :
                            'border-slate-200 hover:bg-slate-50 hover:border-slate-300'">
                        <input type="radio" name="license_plan" value="pro" class="sr-only" x-model="licensePlan">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                :class="licensePlan === 'pro' ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-500'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold"
                                    :class="licensePlan === 'pro' ? 'text-indigo-900' : 'text-slate-800'">Pro</span>
                                <span class="text-xs"
                                    :class="licensePlan === 'pro' ? 'text-indigo-600' : 'text-slate-500'">2
                                    Tahun</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 transition-all"
                        :class="licensePlan === 'unlimited' ? 'border-indigo-500 bg-indigo-50 shadow-md shadow-indigo-500/10' :
                            'border-slate-200 hover:bg-slate-50 hover:border-slate-300'">
                        <input type="radio" name="license_plan" value="unlimited" class="sr-only"
                            x-model="licensePlan">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                :class="licensePlan === 'unlimited' ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-500'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold"
                                    :class="licensePlan === 'unlimited' ? 'text-indigo-900' : 'text-slate-800'">Unlimited</span>
                                <span class="text-xs"
                                    :class="licensePlan === 'unlimited' ? 'text-indigo-600' : 'text-slate-500'">Selamanya</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 transition-all"
                        :class="licensePlan === 'custom' ? 'border-indigo-500 bg-indigo-50 shadow-md shadow-indigo-500/10' :
                            'border-slate-200 hover:bg-slate-50 hover:border-slate-300'">
                        <input type="radio" name="license_plan" value="custom" class="sr-only"
                            x-model="licensePlan">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                :class="licensePlan === 'custom' ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-500'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold"
                                    :class="licensePlan === 'custom' ? 'text-indigo-900' : 'text-slate-800'">Custom</span>
                                <span class="text-xs"
                                    :class="licensePlan === 'custom' ? 'text-indigo-600' : 'text-slate-500'">Sesuai
                                    Kebutuhan</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Custom Duration --}}
            <div x-show="licensePlan === 'custom'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Durasi Custom</label>
                <div class="flex gap-3">
                    <input type="number" name="custom_duration" min="1" x-model="customValue"
                        class="w-24 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
                    <select name="custom_type" x-model="customType"
                        class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all">
                        <option value="days">Hari</option>
                        <option value="months">Bulan</option>
                        <option value="years">Tahun</option>
                    </select>
                </div>
            </div>

            <x-input label="Maksimal Aktivasi" name="max_activation" type="number" :value="$license->max_activation" required />

            <x-select label="Status" name="status" :options="['active' => 'Aktif', 'suspended' => 'Suspended', 'revoked' => 'Revoked']" :selected="$license->status" required />
        </div>

        <div class="flex justify-end gap-3 mt-6 pt-5 border-t border-slate-100">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'edit-license-{{ $license->id }}')">
                Batal
            </x-button-secondary>
            <x-button-primary type="submit">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Lisensi
            </x-button-primary>
        </div>
    </form>
</x-modal>
