@extends('layouts.mainlayout')

@section('title', 'Detail Order - Alvca Matcha')

@section('content')
    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Detail Order #{{ $order->id }}</h1>
        </div>
    </section>

    {{-- Order Detail Section --}}
    <section class="my-8 py-6">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-md p-8">
                {{-- Order Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Informasi Order</h3>
                        <p class="text-gray-600 text-sm">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-gray-600 text-sm">Status: 
                            @php
                                $statusColors = [
                                    'pending' => 'text-yellow-600',
                                    'proses' => 'text-blue-600',
                                    'paid' => 'text-green-600',
                                    'done' => 'text-gray-600'
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'proses' => 'Diproses',
                                    'paid' => 'Dibayar',
                                    'done' => 'Selesai'
                                ];
                            @endphp
                            <span class="font-semibold {{ $statusColors[$order->status] ?? 'text-gray-600' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Lokasi & Meja</h3>
                        <p class="text-gray-600 text-sm">{{ $order->meja->lokasiToko->nama_lokasi }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->meja->lokasiToko->alamat }}</p>
                        <p class="text-gray-600 text-sm">Meja: {{ $order->meja->nomor_meja }}</p>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-semibold text-green-800 mb-4">Item Pesanan</h3>
                    <div class="space-y-4">
                        @php
                            $total = 0;
                        @endphp
                        @foreach($order->items as $item)
                            @php
                                $total += $item->subtotal;
                            @endphp
                            <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                                <img src="{{ asset('images/' . $item->menu->gambar) }}" 
                                     alt="{{ $item->menu->nama }}"
                                     class="w-20 h-20 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-green-800">{{ $item->menu->nama }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $item->menu->deskripsi }}</p>
                                    <p class="text-gray-600 text-sm mt-1">Jumlah: {{ $item->qty }} × Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-green-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-4 border-t-2 border-green-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-green-800">Total:</span>
                            <span class="text-2xl font-bold text-green-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('orders.index') }}" 
                       class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors duration-200">
                        Kembali ke Daftar Order
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection








