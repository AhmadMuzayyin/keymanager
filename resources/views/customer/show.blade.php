@extends('layouts.app')

@section('title', 'Detail Customer')
@section('page-title', 'Detail Customer')

@section('content')
    <div class="mb-4">
        <a href="{{ route('customers.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke List
        </a>
    </div>

    {{-- Customer Info --}}
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Informasi Customer</h2>
        </div>
        <div class="p-6">
            <div class="flex items-start">
                <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center mr-6">
                    <span class="text-blue-600 font-bold text-xl">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </span>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-gray-600">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $customer->email }}
                        </p>
                        @if ($customer->phone)
                            <p class="text-gray-600">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $customer->phone }}
                            </p>
                        @endif
                        <p class="text-gray-500 text-sm">
                            Bergabung sejak {{ $customer->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Licenses --}}
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Lisensi Dimiliki ({{ $customer->licenses->count() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase
                            Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">License
                            Key</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customer->licenses as $license)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code
                                    class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $license->purchase_code }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $license->key }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $license->product_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($license->status === 'active')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @elseif ($license->status === 'suspended')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Suspended
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Revoked
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $license->expires_at ? $license->expires_at->format('d M Y') : 'Lifetime' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Customer ini belum memiliki lisensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
