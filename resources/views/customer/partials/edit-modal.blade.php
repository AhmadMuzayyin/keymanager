<x-modal id="edit-customer-{{ $customer->id }}" title="Edit Customer">
    <form action="{{ route('customers.update', $customer) }}" method="POST">
        @csrf
        @method('PUT')

        <x-input label="Nama" name="name" type="text" required :value="$customer->name"
            placeholder="Nama lengkap customer" />
        <x-input label="Email" name="email" type="email" required :value="$customer->email"
            placeholder="email@example.com" />
        <x-input label="Phone (Opsional)" name="phone" type="text" :value="$customer->phone" placeholder="08xxxxxxxxxx" />

        <div class="mt-6 flex justify-end gap-3">
            <x-button-secondary type="button" @click="$dispatch('close-modal', 'edit-customer-{{ $customer->id }}')">
                Batal
            </x-button-secondary>
            <x-button-primary type="submit">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update
            </x-button-primary>
        </div>
    </form>
</x-modal>
