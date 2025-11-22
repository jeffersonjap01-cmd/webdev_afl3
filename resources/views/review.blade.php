@extends('layouts.mainlayout')

@section('title', 'Review - Alvca Matcha')

@section('content')
    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Review Produk</h1>
            <p class="text-gray-700 text-lg">
                Bagikan pengalaman Anda dengan produk kami.
            </p>
        </div>
    </section>

    {{-- Review Section --}}
    <section class="my-12 py-8">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Add Review Form (Only for authenticated users, not admins) --}}
            @auth
                @if(auth()->user()->role !== 'admin')
                    <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold text-green-800 mb-6">Tulis Review</h2>
                    <form action="{{ route('review.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="menu_id" class="block text-gray-700 font-medium mb-2">Pilih Produk</label>
                            <select name="menu_id" id="menu_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="rating" class="block text-gray-700 font-medium mb-2">Rating</label>
                            <select name="rating" id="rating" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="5">5 ⭐ (Sangat Baik)</option>
                                <option value="4">4 ⭐ (Baik)</option>
                                <option value="3">3 ⭐ (Cukup)</option>
                                <option value="2">2 ⭐ (Kurang)</option>
                                <option value="1">1 ⭐ (Sangat Kurang)</option>
                            </select>
                        </div>

                        <div>
                            <label for="komentar" class="block text-gray-700 font-medium mb-2">Komentar</label>
                            <textarea name="komentar" id="komentar" rows="4"
                                      placeholder="Bagikan pengalaman Anda..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            Kirim Review
                        </button>
                    </form>
                    </div>
                @endif
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
                    <p class="text-yellow-800">
                        Silakan <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold underline">login</a> untuk menulis review.
                    </p>
                </div>
            @endauth

            {{-- Reviews List --}}
            <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                <h2 class="text-2xl font-bold text-green-800 mb-6">Review Pengguna</h2>
                @if($reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="border-b border-gray-200 pb-6 last:border-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="font-semibold text-green-800">{{ $review->user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $review->menu->nama }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-yellow-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    ⭐
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                @if($review->komentar)
                                    <p class="text-gray-700">{{ $review->komentar }}</p>
                                @endif
                                @auth
                                    {{-- Only users (not admins) can delete their own reviews --}}
                                    @if(auth()->user()->role !== 'admin' && $review->user_id === Auth::id())
                                        <div class="mt-4 flex gap-2">
                                            <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-8">Belum ada review.</p>
                @endif

                {{-- Pagination --}}
                @if($reviews->hasPages())
                    <div class="mt-8 flex items-center justify-center">
                        <div class="flex items-center gap-2">
                            {{-- Previous Page Link --}}
                            @if($reviews->onFirstPage())
                                <span class="px-3 py-2 text-gray-400 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $reviews->previousPageUrl() }}" 
                                   class="px-3 py-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Numbers --}}
                            <div class="flex items-center gap-1">
                                @foreach($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                                    @if($page == $reviews->currentPage())
                                        <span class="px-3 py-2 bg-green-600 text-white rounded-lg font-medium">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" 
                                           class="px-3 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Next Page Link --}}
                            @if($reviews->hasMorePages())
                                <a href="{{ $reviews->nextPageUrl() }}" 
                                   class="px-3 py-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="px-3 py-2 text-gray-400 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Page Info --}}
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Menampilkan {{ $reviews->firstItem() ?? 0 }} - {{ $reviews->lastItem() ?? 0 }} dari {{ $reviews->total() }} review
                        </p>
                    </div>
                @endif
            </div>

            {{-- Contact Information --}}
            <div class="bg-white rounded-2xl shadow-md p-8">
                <h2 class="text-3xl font-bold text-green-800 mb-6">Informasi Kontak</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800 mb-1">Alamat</h3>
                            <p class="text-gray-700">
                                Jl. Matcha No. 123<br>
                                Jakarta Selatan, 12345<br>
                                Indonesia
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800 mb-1">Telepon</h3>
                            <p class="text-gray-700">
                                <a href="tel:+6281234567890" class="hover:text-green-600 transition-colors">
                                    +62 812 3456 7890
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800 mb-1">Email</h3>
                            <p class="text-gray-700">
                                <a href="mailto:info@alvcamatcha.com" class="hover:text-green-600 transition-colors">
                                    info@alvcamatcha.com
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

