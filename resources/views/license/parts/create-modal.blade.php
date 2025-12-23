<x-modal id="create-license" title="Tambah Lisensi Baru">
    <form action="{{ route('licenses.store') }}" method="POST">
        @csrf
        <x-input label="Produk" name="product" type="text" required placeholder="Nama produk" />

        <x-input label="Domain" name="domain" type="text" placeholder="example.com" />

        <x-input label="Tanggal Expired" name="expires_at" type="date" placeholder="Kosongkan untuk lifetime" />

        <x-input label="Maksimal Aktivasi" name="max_activation" type="number" value="1" required />

        <x-select label="Status" name="status" :options="['active' => 'Aktif', 'suspended' => 'Suspended']" selected="active" required />

        <div class="flex justify-end space-x-2 mt-6">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'create-license')">
                Batal
            </x-button-secondary>
            <x-button-primaryy type="submit">
                Simpan
            </x-button-primaryy>
        </div>
    </form>
</x-modal>
