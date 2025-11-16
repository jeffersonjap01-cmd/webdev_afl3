@extends('layouts.mainlayout')

@section('title', 'Admin - Kelola Promo')

@section('content')
    {{-- Success Message --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Header Section --}}
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Kelola Promo</h1>
            <p class="text-gray-700 text-lg">
                Tambah, edit, atau hapus promo dari sistem.
            </p>
        </div>
    </section>

    {{-- Promos Table Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-green-800">Daftar Promo</h2>
                <a href="{{ route('admin.promos.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Promo Baru
                </a>
            </div>

            @if($promos->count() > 0)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold">Nama Promo</th>
                                    <th class="px-6 py-4 text-left font-semibold">Kode Promo</th>
                                    <th class="px-6 py-4 text-center font-semibold">Diskon</th>
                                    <th class="px-6 py-4 text-center font-semibold">Periode</th>
                                    <th class="px-6 py-4 text-center font-semibold">Status</th>
                                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($promos as $promo)
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-green-800">{{ $promo->nama_promo }}</span>
                                            @if($promo->deskripsi)
                                                <p class="text-gray-600 text-sm mt-1">{{ \Illuminate\Support\Str::limit($promo->deskripsi, 50) }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono bg-gray-100 px-3 py-1 rounded text-sm">{{ $promo->kode_promo }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($promo->diskon_persen > 0)
                                                <span class="text-green-700 font-semibold">{{ $promo->diskon_persen }}%</span>
                                                @if($promo->max_diskon)
                                                    <p class="text-xs text-gray-600">Max: Rp {{ number_format($promo->max_diskon, 0, ',', '.') }}</p>
                                                @endif
                                            @elseif($promo->diskon_nominal)
                                                <span class="text-green-700 font-semibold">Rp {{ number_format($promo->diskon_nominal, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm">
                                            <div>{{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}</div>
                                            <div class="text-gray-600">s/d</div>
                                            <div>{{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $promo->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($promo->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.promos.edit', $promo->id) }}" 
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.promos.destroy', $promo->id) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Promo</h2>
                    <p class="text-gray-600 mb-6">Mulai dengan menambahkan promo pertama Anda!</p>
                    <a href="{{ route('admin.promos.create') }}" 
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full transition-colors duration-200">
                        Tambah Promo
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

