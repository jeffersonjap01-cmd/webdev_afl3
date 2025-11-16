@extends('layouts.mainlayout')

@section('title', 'Admin - Kelola Delivery')

@section('content')
    {{-- Success Message --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Kelola Delivery</h1>
            <p class="text-gray-700 text-lg">
                Lihat semua delivery (keranjang) dari pelanggan beserta alamat pengiriman.
            </p>
        </div>
    </section>

    {{-- Deliveries Table Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            @if($deliveries->count() > 0)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold">ID</th>
                                    <th class="px-6 py-4 text-left font-semibold">Customer</th>
                                    <th class="px-6 py-4 text-left font-semibold">Produk</th>
                                    <th class="px-6 py-4 text-left font-semibold">Lokasi Cabang</th>
                                    <th class="px-6 py-4 text-left font-semibold">Alamat Pengiriman</th>
                                    <th class="px-6 py-4 text-center font-semibold">Qty</th>
                                    <th class="px-6 py-4 text-center font-semibold">Total Harga</th>
                                    <th class="px-6 py-4 text-center font-semibold">Status Pembayaran</th>
                                    <th class="px-6 py-4 text-center font-semibold">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($deliveries as $delivery)
                                    @php
                                        $paymentColors = [
                                            'Belum Bayar' => 'bg-yellow-100 text-yellow-800',
                                            'Dibayar' => 'bg-green-100 text-green-800',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-green-800">#{{ $delivery->id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-800">{{ $delivery->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $delivery->user->email }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-800">{{ $delivery->menu->nama }}</p>
                                            <p class="text-sm text-gray-600">Rp {{ number_format($delivery->menu->harga, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($delivery->lokasiToko)
                                                <p class="text-gray-700">{{ $delivery->lokasiToko->nama_lokasi }}</p>
                                                <p class="text-sm text-gray-600">{{ $delivery->lokasiToko->alamat }}</p>
                                            @else
                                                <p class="text-gray-400 italic">Tidak ada lokasi</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($delivery->alamat)
                                                <div class="text-sm text-gray-700">
                                                    <p class="font-medium">{{ $delivery->alamat->alamat_lengkap }}</p>
                                                    <p class="text-gray-600">{{ $delivery->alamat->kota }}, {{ $delivery->alamat->provinsi }}</p>
                                                    @if($delivery->alamat->kode_pos)
                                                        <p class="text-gray-600">Kode Pos: {{ $delivery->alamat->kode_pos }}</p>
                                                    @endif
                                                    @if($delivery->alamat->no_telepon)
                                                        <p class="text-gray-600">Telp: {{ $delivery->alamat->no_telepon }}</p>
                                                    @endif
                                                </div>
                                            @else
                                                <p class="text-gray-400 italic">Tidak ada alamat</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-semibold text-gray-800">{{ $delivery->qty }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-semibold text-green-700">
                                                Rp {{ number_format($delivery->total_harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 rounded-full font-semibold text-sm {{ $paymentColors[$delivery->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $delivery->status_pembayaran }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-gray-600 text-sm">
                                                {{ $delivery->created_at->format('d M Y') }}<br>
                                                {{ $delivery->created_at->format('H:i') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Delivery</h2>
                    <p class="text-gray-600">Tidak ada delivery yang terdaftar saat ini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

