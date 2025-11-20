@extends('layouts.mainlayout')

@section('title', 'Tentang Kami - Alvca Matcha')

@section('content')
    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Tentang Alvca Matcha</h1>
            <p class="text-gray-700 text-lg">
                Menemukan keindahan dan kebaikan matcha dalam setiap cangkir.
            </p>
        </div>
    </section>

    {{-- About Content Section --}}
    <section class="my-12 py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-green-800 mb-4">Cerita Kami</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Alvca Matcha lahir dari kecintaan terhadap matcha tradisional Jepang yang autentik. 
                        Kami berkomitmen untuk menyajikan produk matcha berkualitas tinggi yang dipilih dengan 
                        teliti dari perkebunan terbaik di Jepang.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Setiap produk kami dibuat dengan penuh dedikasi untuk memberikan pengalaman matcha 
                        yang luar biasa, mulai dari minuman segar hingga dessert premium yang menggugah selera.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Dengan fokus pada kualitas, keaslian, dan kepuasan pelanggan, kami hadir untuk 
                        membawa keindahan matcha ke dalam kehidupan sehari-hari Anda.
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <img src="{{ asset('images/matcha_header.jpg') }}" 
                         alt="Matcha" 
                         class="w-full h-80 object-cover">
                </div>
            </div>

            {{-- Values Section --}}
            <div class="bg-green-50 rounded-2xl p-8 mb-12">
                <h2 class="text-3xl font-bold text-green-800 mb-8 text-center">Nilai-Nilai Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-green-800 mb-2">Kualitas Premium</h3>
                        <p class="text-gray-600">Hanya menggunakan matcha grade terbaik dengan standar kualitas internasional.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-green-800 mb-2">Dibuat dengan Cinta</h3>
                        <p class="text-gray-600">Setiap produk dibuat dengan dedikasi dan passion untuk memberikan pengalaman terbaik.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-green-800 mb-2">Pelayanan Terbaik</h3>
                        <p class="text-gray-600">Komitmen untuk memberikan pelayanan terbaik dan kepuasan pelanggan.</p>
                    </div>
                </div>
            </div>

            {{-- Mission Section --}}
            <div class="bg-white rounded-2xl shadow-md p-8">
                <h2 class="text-3xl font-bold text-green-800 mb-6 text-center">Misi Kami</h2>
                <p class="text-gray-700 text-lg leading-relaxed text-center max-w-3xl mx-auto">
                    Menjadi destinasi utama bagi para pecinta matcha dengan menyediakan produk berkualitas tinggi, 
                    pengalaman berbelanja yang menyenangkan, dan komitmen terhadap kepuasan pelanggan. 
                    Kami percaya bahwa setiap cangkir matcha membawa cerita dan kenangan yang istimewa.
                </p>
            </div>
        </div>
    </section>
@endsection








