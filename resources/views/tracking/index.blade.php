@extends('layouts.front')

@section('title', 'Lacak Order - ' . config('app.name'))
@section('meta_description', 'Lacak status order dan lisensi Anda')

@section('content')
    <section class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[#FAF5E9]">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div
                    class="mx-auto w-20 h-20 bg-gradient-to-br from-[#009B4D] to-[#007a3d] rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-800">Lacak Order</h1>
                <p class="mt-2 text-slate-600">
                    Masukkan nomor order atau kode pembelian untuk melacak status pesanan Anda
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <form action="{{ route('tracking.search') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="block text-sm font-medium text-slate-700 mb-2">
                            Nomor Order / Kode Pembelian
                        </label>
                        <input type="text" name="code" id="code"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#009B4D] focus:border-[#009B4D]"
                            placeholder="Contoh: ORD-XXXXXXXX atau PUR-XXXXXXXX" value="{{ old('code') }}" required>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-[#009B4D] to-[#007a3d] text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lacak Order
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-slate-500">
                Nomor order dikirimkan ke email Anda setelah melakukan pembelian.
            </p>
        </div>
    </section>
@endsection
