@extends('layouts.app')

@section('title', 'Buat Pesanan')
@section('page-title', 'Buat Pesanan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Pesanan
            </a>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" class="space-y-6" x-data="orderForm({{ $products->toJson() }})">
            @csrf

            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Customer</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Customer <span
                                class="text-red-500">*</span></label>
                        <x-select name="customer_id" required>
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->email }}
                                </option>
                            @endforeach
                        </x-select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">Item Pesanan</h3>
                    <button type="button" @click="addItem()"
                        class="inline-flex items-center px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Item
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-xl mb-4">
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Produk</label>
                            <select :name="'items[' + index + '][product_id]'" x-model="item.product_id"
                                @change="updatePrices(index)"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                required>
                                <option value="">Pilih Produk</option>
                                <template x-for="product in products" :key="product.id">
                                    <option :value="product.id" x-text="product.name"></option>
                                </template>
                            </select>
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Paket Harga</label>
                            <select :name="'items[' + index + '][product_price_id]'" x-model="item.product_price_id"
                                @change="updateSubtotal(index)"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                required>
                                <option value="">Pilih Paket</option>
                                <template x-for="price in item.availablePrices" :key="price.id">
                                    <option :value="price.id"
                                        x-text="price.name + ' - Rp ' + formatNumber(price.price)">
                                    </option>
                                </template>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Qty</label>
                            <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity"
                                @input="updateSubtotal(index)" min="1"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                required>
                        </div>
                        <div class="md:col-span-2 flex items-end gap-2">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Subtotal</label>
                                <p class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl font-semibold text-slate-800"
                                    x-text="'Rp ' + formatNumber(item.subtotal)"></p>
                            </div>
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                class="p-2.5 text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex justify-end">
                        <div class="text-right">
                            <p class="text-sm text-slate-500 mb-1">Total</p>
                            <p class="text-3xl font-bold text-indigo-600" x-text="'Rp ' + formatNumber(total)"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Metode Pembayaran</label>
                        <x-select name="payment_method">
                            <option value="">Pilih Metode</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="cash">Cash</option>
                        </x-select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <x-select name="status">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                        </x-select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                        <x-textarea name="notes" rows="3">{{ old('notes') }}</x-textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('orders.index') }}"
                    class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <x-button-primary type="submit">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Buat Pesanan
                </x-button-primary>
            </div>
        </form>
    </div>

    <script>
        function orderForm(products) {
            return {
                products: products,
                items: [{
                    product_id: '',
                    product_price_id: '',
                    quantity: 1,
                    subtotal: 0,
                    availablePrices: []
                }],
                get total() {
                    return this.items.reduce((sum, item) => sum + item.subtotal, 0);
                },
                addItem() {
                    this.items.push({
                        product_id: '',
                        product_price_id: '',
                        quantity: 1,
                        subtotal: 0,
                        availablePrices: []
                    });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                updatePrices(index) {
                    const productId = parseInt(this.items[index].product_id);
                    const product = this.products.find(p => p.id === productId);
                    this.items[index].availablePrices = product ? product.prices : [];
                    this.items[index].product_price_id = '';
                    this.items[index].subtotal = 0;
                },
                updateSubtotal(index) {
                    const priceId = parseInt(this.items[index].product_price_id);
                    const price = this.items[index].availablePrices.find(p => p.id === priceId);
                    const quantity = parseInt(this.items[index].quantity) || 0;
                    this.items[index].subtotal = price ? price.price * quantity : 0;
                },
                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }
            }
        }
    </script>
@endsection
