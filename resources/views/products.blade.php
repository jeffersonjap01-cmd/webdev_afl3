@extends('layouts.mainlayout')

@section('title', 'Produk - Alvca Matcha')

@section('content')
    <section class="py-5 text-center bg-light border-bottom">
        <div class="container">
            <h1 class="fw-bold text-success mb-3">Produk Alvca Matcha</h1>
            <p class="text-muted mb-0">
                Temukan berbagai pilihan matcha terbaik — dari minuman segar hingga dessert premium.
            </p>
        </div>
    </section>

    <div class="container my-5">
        @foreach($menus as $index => $menu)
            <div class="row align-items-center mb-5 py-4 {{ $index % 2 == 0 ? 'bg-light rounded-4 shadow-sm' : '' }}">
                <div class="col-md-5 mb-3 mb-md-0">
                    <img src="{{ asset('images/' . $menu->gambar) }}" 
                         alt="{{ $menu->nama }}"
                         class="img-fluid rounded-4 shadow-sm"
                         style="width: 100%; height: 300px; object-fit: cover;">
                </div>
                <div class="col-md-7">
                    <h2 class="fw-bold text-success mb-3">{{ $menu->nama }}</h2>
                    <p class="text-muted mb-4">{{ $menu->deskripsi }}</p>
                    <a href="#" class="btn btn-success px-4 py-2 rounded-pill">
                        <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
