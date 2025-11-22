@extends('layouts.mainlayout')

@section('title', 'Tambah Promo - Admin')

@section('content')
    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Tambah Promo Baru</h1>
            <p class="text-gray-700 text-lg">
                Isi form di bawah untuk menambahkan promo baru.
            </p>
        </div>
    </section>

    {{-- Form Section --}}
    <section class="my-8 py-6">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-md p-8">
                <form action="{{ route('admin.promos.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        {{-- Nama Promo --}}
                        <div>
                            <label for="nama_promo" class="block text-gray-700 font-medium mb-2">
                                Nama Promo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_promo" 
                                   name="nama_promo" 
                                   value="{{ old('nama_promo') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            @error('nama_promo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="deskripsi" class="block text-gray-700 font-medium mb-2">
                                Deskripsi
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kode Promo --}}
                        <div>
                            <label for="kode_promo" class="block text-gray-700 font-medium mb-2">
                                Kode Promo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="kode_promo" 
                                   name="kode_promo" 
                                   value="{{ old('kode_promo') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 font-mono">
                            @error('kode_promo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Diskon Type --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="diskon_persen" class="block text-gray-700 font-medium mb-2">
                                    Diskon Persen (%)
                                </label>
                                <input type="number" 
                                       id="diskon_persen" 
                                       name="diskon_persen" 
                                       value="{{ old('diskon_persen', 0) }}"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('diskon_persen')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="diskon_nominal" class="block text-gray-700 font-medium mb-2">
                                    Diskon Nominal (Rp)
                                </label>
                                <input type="number" 
                                       id="diskon_nominal" 
                                       name="diskon_nominal" 
                                       value="{{ old('diskon_nominal') }}"
                                       min="0"
                                       step="100"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('diskon_nominal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       id="tanggal_mulai" 
                                       name="tanggal_mulai" 
                                       value="{{ old('tanggal_mulai') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('tanggal_mulai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_berakhir" class="block text-gray-700 font-medium mb-2">
                                    Tanggal Berakhir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       id="tanggal_berakhir" 
                                       name="tanggal_berakhir" 
                                       value="{{ old('tanggal_berakhir') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('tanggal_berakhir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Min Pembelian & Max Diskon --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="min_pembelian" class="block text-gray-700 font-medium mb-2">
                                    Min Pembelian (Rp)
                                </label>
                                <input type="number" 
                                       id="min_pembelian" 
                                       name="min_pembelian" 
                                       value="{{ old('min_pembelian') }}"
                                       min="0"
                                       step="100"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('min_pembelian')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="max_diskon" class="block text-gray-700 font-medium mb-2">
                                    Max Diskon (Rp)
                                </label>
                                <input type="number" 
                                       id="max_diskon" 
                                       name="max_diskon" 
                                       value="{{ old('max_diskon') }}"
                                       min="0"
                                       step="100"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('max_diskon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-gray-700 font-medium mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                Simpan Promo
                            </button>
                            <a href="{{ route('admin.promos.index') }}" 
                               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors duration-200 text-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection











