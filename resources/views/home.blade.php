@extends('layouts.mainlayout')

@section('title', 'Beranda - Matcha Website')

@section('content')
    {{-- 🌿 Hero Section --}}
    <section class="hero" 
        style="background-image: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url('{{ asset('images/matcha_header.jpg') }}');">
        <div class="container px-3 text-center">
            <h1>Welcome to <span class="text-success">Alvca Matcha</span></h1>
            <p>Discover the fresh, authentic taste of matcha with our handcrafted drinks and treats.</p>
        </div>
    </section>

    {{-- 🪴 Product Section --}}
    <div class="container my-5 py-4">
        <div class="row g-4">
            @foreach($menus as $menu)
                <div class="menu col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('images/' . $menu->gambar) }}" 
                             alt="{{ $menu->nama }}"
                             class="card-img-top"
                             style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $menu->nama }}</h5>
                            <p class="card-text">{{ $menu->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
