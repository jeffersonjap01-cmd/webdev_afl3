@extends('layouts.mainlayout')

@section('title', 'Buat Order - Alvca Matcha')

@section('content')
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
            <h1 class="text-4xl font-bold text-green-800 mb-3">Buat Order</h1>
            <p class="text-gray-700 text-lg">
                Pilih lokasi dan meja untuk order Anda.
            </p>
        </div>
    </section>

    {{-- Order Form Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Summary --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold text-green-800 mb-4">Ringkasan Pesanan</h2>
                        <div class="space-y-4">
                            @php
                                $total = 0;
                            @endphp
                            @foreach($keranjang as $item)
                                @php
                                    $total += $item->total_harga;
                                @endphp
                                <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                                    <img src="{{ asset('images/' . $item->menu->gambar) }}" 
                                         alt="{{ $item->menu->nama }}"
                                         class="w-20 h-20 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-green-800">{{ $item->menu->nama }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $item->menu->deskripsi }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-700">x{{ $item->qty }}</p>
                                        <p class="font-semibold text-green-700">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</p>
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
                </div>

                {{-- Order Form --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-4">
                        <h2 class="text-2xl font-bold text-green-800 mb-6">Pilih Lokasi & Meja</h2>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf

                            <div class="space-y-6">
                                @foreach($lokasiToko as $lokasi)
                                    @if($lokasi->mejas->count() > 0)
                                        <div class="border border-green-200 rounded-lg p-4">
                                            <h3 class="font-bold text-green-800 mb-3">{{ $lokasi->nama_lokasi }}</h3>
                                            @if($lokasi->alamat)
                                                <p class="text-gray-600 text-sm mb-3">{{ $lokasi->alamat }}</p>
                                            @endif
                                            
                                            <div class="space-y-2">
                                                <label class="block text-gray-700 font-medium text-sm mb-2">Pilih Meja:</label>
                                                <div class="grid grid-cols-3 gap-2">
                                                    @foreach($lokasi->mejas as $meja)
                                                        <label class="relative">
                                                            <input type="radio" 
                                                                   name="meja_id" 
                                                                   value="{{ $meja->id }}" 
                                                                   class="peer hidden"
                                                                   required>
                                                            <div class="border-2 border-gray-300 rounded-lg p-3 text-center cursor-pointer hover:border-green-500 transition-colors peer-checked:border-green-600 peer-checked:bg-green-50">
                                                                <p class="font-semibold text-gray-700 peer-checked:text-green-700">Meja {{ $meja->nomor_meja }}</p>
                                                                <p class="text-xs text-gray-500 mt-1">Kosong</p>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @if($lokasiToko->flatMap->mejas->isEmpty())
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <p class="text-yellow-800 text-sm">Tidak ada meja yang tersedia saat ini.</p>
                                    </div>
                                @endif

                                <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                        {{ $lokasiToko->flatMap->mejas->isEmpty() ? 'disabled' : '' }}>
                                    Buat Order
                                </button>

                                <a href="{{ route('keranjang.index') }}" 
                                   class="block text-center text-gray-600 hover:text-green-600 transition-colors text-sm">
                                    Kembali ke Keranjang
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection












