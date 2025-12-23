<x-modal id="edit-license-{{ $license->id }}" title="Edit Lisensi">
    <form action="{{ route('licenses.update', $license->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-input label="License Key" name="license_key" type="text" :value="$license->key" readonly disabled />

        <x-input label="Produk" name="product" type="text" :value="$license->product_name" required />

        <x-input label="Domain" name="domain" type="text" :value="$license->domain" />

        <x-input label="Tanggal Expired" name="expires_at" type="date" :value="$license->expires_at ? $license->expires_at->format('Y-m-d') : ''" />

        <x-input label="Maksimal Aktivasi" name="max_activation" type="number" :value="$license->max_activations" required />

        <x-select label="Status" name="status" :options="['active' => 'Aktif', 'suspended' => 'Suspended', 'revoked' => 'Revoked']" :selected="$license->status" required />

        <div class="flex justify-end space-x-2 mt-6">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'edit-license-{{ $license->id }}')">
                Batal
            </x-button-secondary>
            <x-button-primaryy type="submit">
                Update
            </x-button-primaryy>
        </div>
    </form>
</x-modal>
