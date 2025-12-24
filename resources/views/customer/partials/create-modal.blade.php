<x-modal id="create-customer" title="Tambah Customer Baru">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <x-input label="Nama" name="name" type="text" required placeholder="Nama lengkap customer" />
        <x-input label="Email" name="email" type="email" required placeholder="email@example.com" />
        <x-input label="Phone (Opsional)" name="phone" type="text" placeholder="08xxxxxxxxxx" />

        <div class="mt-6 flex justify-end gap-3">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'create-customer')">
                Batal
            </x-button-secondary>
            <x-button-primary type="submit">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Simpan
            </x-button-primary>
        </div>
    </form>
</x-modal>
