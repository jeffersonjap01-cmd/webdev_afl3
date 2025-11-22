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

    {{-- Search Section --}}
    <section class="py-6 bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <form method="GET" action="{{ route('products') }}" class="relative">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $query ?? '' }}" 
                               placeholder="Cari produk berdasarkan nama atau deskripsi..."
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button type="submit" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                    @if($query ?? false)
                        <div class="mt-3 flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                Menampilkan hasil untuk: <span class="font-semibold text-green-700">"{{ $query }}"</span>
                            </p>
                            <a href="{{ route('products') }}" class="text-sm text-green-600 hover:text-green-700 underline">
                                Lihat Semua Produk
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            @if($menus->count() > 0)
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

                                    {{-- Add to Cart --}}
                                    <form action="{{ route('keranjang.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="qty" id="qty_cart_{{ $menu->id }}" value="1">
                                        
                                        <button type="submit" 
                                                onclick="document.getElementById('qty_cart_{{ $menu->id }}').value = document.getElementById('qty_{{ $menu->id }}').value"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-full transition-colors duration-200 shadow-md hover:shadow-lg">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Tambah ke Keranjang
                                            </span>
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">
                                            Pilih metode pengambilan dan detail lokasi di halaman keranjang.
                                        </p>
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
            @else
                <div class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <div class="mb-4">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-600 mb-4">
                            @if($query ?? false)
                                Tidak ada produk yang sesuai dengan pencarian "{{ $query }}".
                            @else
                                Belum ada produk yang tersedia saat ini.
                            @endif
                        </p>
                        @if($query ?? false)
                            <a href="{{ route('products') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Lihat Semua Produk
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
