@extends('layouts.front')

@section('title', 'Order Tidak Ditemukan - ' . config('app.name'))

@section('content')
    <section class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[#FAF5E9]">
        <div class="max-w-md w-full text-center">
            <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-slate-800">Order Tidak Ditemukan</h1>

            <p class="mt-3 text-slate-600">
                Kode <code class="bg-slate-200 px-2 py-1 rounded text-sm font-mono">{{ $code }}</code> tidak
                ditemukan dalam sistem kami.
            </p>

            <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4 text-left">
                <p class="text-sm font-medium text-amber-800">Kemungkinan penyebab:</p>
                <ul class="mt-2 text-sm text-amber-700 list-disc list-inside space-y-1">
                    <li>Nomor order atau kode pembelian salah ketik</li>
                    <li>Pembelian belum diproses</li>
                    <li>Order sudah dihapus dari sistem</li>
                </ul>
            </div>

            <div class="mt-6 space-y-3">
                <a href="{{ route('tracking.index') }}"
                    class="w-full inline-flex justify-center py-4 px-4 bg-gradient-to-r from-[#009B4D] to-[#007a3d] text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all">
                    Coba Lagi
                </a>

                <p class="text-sm text-slate-500">
                    Butuh bantuan? <a href="mailto:support@example.com" class="text-[#009B4D] hover:underline">Hubungi
                        Support</a>
                </p>
            </div>
        </div>
    </section>
@endsection

</html>
