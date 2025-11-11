@extends('layouts.mainlayout')

@section('title', 'Beranda - Matcha Website')

@section('content')
    {{-- 🌿 Hero Section --}}
    <section class="hero" 
        style="background-image: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url('{{ asset('images/matcha_header.jpg') }}');">
        <div class="max-w-6xl mx-auto text-center px-4">
            <h1>Welcome to <span>Alvca Matcha</span></h1>
            <p>Discover the fresh, authentic taste of matcha with our handcrafted drinks and treats.</p>
            <button class="btn-hero mt-4">Shop Now</button>
        </div>
    </section>

    {{-- 🍵 Product Section --}}
    <section class="my-5 py-4 matcha-section">
        <div class="max-w-6xl mx-auto text-center px-4">
            <h2 class="section-title">Our Products</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($menus as $menu)
                    <div class="product-card bg-white rounded-xl overflow-hidden shadow-sm transition-transform duration-300">
                        <img src="{{ asset('images/' . $menu->gambar) }}" 
                             alt="{{ $menu->nama }}" 
                             class="w-full h-64 object-cover">
                        <div class="p-4 text-left">
                            <h5 class="text-lg font-semibold mb-2">{{ $menu->nama }}</h5>
                            <p class="text-gray-700 text-sm">{{ $menu->deskripsi }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
