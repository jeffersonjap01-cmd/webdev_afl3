@extends('layouts.mainlayout')

@section('title', 'Produk - Alvca Matcha')

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
    @if($errors->any())
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Produk Alvca Matcha</h1>
            <p class="text-gray-700 text-lg">
                Temukan berbagai pilihan matcha terbaik — dari minuman segar hingga dessert premium.
            </p>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            @foreach($menus as $index => $menu)
                <div class="mb-8 py-6 {{ $index % 2 == 0 ? 'bg-white rounded-2xl shadow-md' : 'bg-green-50 rounded-2xl shadow-sm' }}">
                    <div class="flex flex-col md:flex-row items-center gap-6 px-6">
                        {{-- Product Image --}}
                        <div class="w-full md:w-2/5">
                            <img src="{{ asset('images/' . $menu->gambar) }}" 
                                 alt="{{ $menu->nama }}"
                                 class="w-full h-64 md:h-80 object-cover rounded-xl shadow-lg">
                        </div>
                        
                        {{-- Product Info --}}
                        <div class="w-full md:w-3/5 text-center md:text-left">
                            <h2 class="text-3xl font-bold text-green-800 mb-3">{{ $menu->nama }}</h2>
                            <p class="text-gray-700 mb-4 leading-relaxed">{{ $menu->deskripsi }}</p>
                            
                            <p class="text-2xl font-semibold text-green-700 mb-4">
                                Rp {{ number_format($menu->harga ?? 0, 0, ',', '.') }}
                            </p>

                            {{-- Stock Display --}}
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ ($menu->stok ?? 0) > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    Stok: {{ $menu->stok ?? 0 }}
                                </span>
                            </div>

                            {{-- Order Options --}}
                            @auth
                                @if(($menu->stok ?? 0) <= 0)
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <p class="text-red-800 font-semibold">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                            Produk ini sedang habis stok.
                                        </p>
                                    </div>
                                @else
                                <div class="space-y-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <label for="qty_{{ $menu->id }}" class="text-gray-700 font-medium">Jumlah:</label>
                                        <input type="number" 
                                               id="qty_{{ $menu->id }}" 
                                               name="qty_{{ $menu->id }}"
                                               value="1" 
                                               min="1" 
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>

                                    {{-- Delivery - Add to Cart with Lokasi Selection --}}
                                    <form action="{{ route('keranjang.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="qty" id="qty_cart_{{ $menu->id }}" value="1">
                                        
                                        <div class="mb-3">
                                            <label for="lokasi_delivery_{{ $menu->id }}" class="block text-gray-700 font-medium text-sm mb-2">
                                                Pilih Lokasi Cabang:
                                            </label>
                                            <select name="lokasi_toko_id" 
                                                    id="lokasi_delivery_{{ $menu->id }}"
                                                    required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">-- Pilih Lokasi --</option>
                                                @php
                                                    $lokasiToko = \App\Models\LokasiToko::all();
                                                @endphp
                                                @foreach($lokasiToko as $lokasi)
                                                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alamat_delivery_{{ $menu->id }}" class="block text-gray-700 font-medium text-sm mb-2">
                                                Alamat Pengiriman:
                                            </label>
                                            <textarea name="alamat_lengkap" 
                                                      id="alamat_delivery_{{ $menu->id }}"
                                                      required
                                                      rows="3"
                                                      placeholder="Masukkan alamat lengkap pengiriman"
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                            <div class="mt-2 grid grid-cols-2 gap-2">
                                                <input type="text" 
                                                       name="kota" 
                                                       placeholder="Kota"
                                                       required
                                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <input type="text" 
                                                       name="provinsi" 
                                                       placeholder="Provinsi"
                                                       required
                                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <input type="text" 
                                                   name="kode_pos" 
                                                   placeholder="Kode Pos (Opsional)"
                                                   class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <input type="text" 
                                                   name="no_telepon" 
                                                   placeholder="No. Telepon (Opsional)"
                                                   class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        
                                        <button type="submit" 
                                                onclick="document.getElementById('qty_cart_{{ $menu->id }}').value = document.getElementById('qty_{{ $menu->id }}').value"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-full transition-colors duration-200 shadow-md hover:shadow-lg">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Add to Cart (Delivery)
                                            </span>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800 mb-2">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Silakan <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold underline">login</a> untuk menambahkan produk ke keranjang.
                                    </p>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
