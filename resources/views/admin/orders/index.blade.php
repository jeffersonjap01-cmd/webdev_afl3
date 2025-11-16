@extends('layouts.mainlayout')

@section('title', 'Admin - Kelola Order')

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
            <h1 class="text-4xl font-bold text-green-800 mb-3">Kelola Order</h1>
            <p class="text-gray-700 text-lg">
                Lihat dan kelola semua order dari pelanggan.
            </p>
        </div>
    </section>

    {{-- Orders Table Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            @if($orders->count() > 0)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold">ID Order</th>
                                    <th class="px-6 py-4 text-left font-semibold">Customer</th>
                                    <th class="px-6 py-4 text-left font-semibold">Lokasi & Meja</th>
                                    <th class="px-6 py-4 text-center font-semibold">Total</th>
                                    <th class="px-6 py-4 text-center font-semibold">Status</th>
                                    <th class="px-6 py-4 text-center font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    @php
                                        $total = $order->items->sum('subtotal');
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'proses' => 'bg-blue-100 text-blue-800',
                                            'done' => 'bg-gray-100 text-gray-800'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'proses' => 'Diproses',
                                            'done' => 'Selesai'
                                        ];
                                    @endphp
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-green-800">#{{ $order->id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-700">{{ $order->meja->lokasiToko->nama_lokasi }}</p>
                                            <p class="text-sm text-gray-600">Meja {{ $order->meja->nomor_meja }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-semibold text-green-700">
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" 
                                                        onchange="this.form.submit()"
                                                        class="px-3 py-1 rounded-full font-semibold text-sm border-0 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}"
                                                        {{ $order->status_pembayaran !== 'Dibayar' && $order->status !== 'done' ? '' : '' }}>
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }} {{ $order->status_pembayaran !== 'Dibayar' ? 'disabled' : '' }}>Selesai</option>
                                                </select>
                                                @if($order->status_pembayaran !== 'Dibayar' && $order->status !== 'done')
                                                    <p class="text-xs text-red-600 mt-1">Order harus dibayar terlebih dahulu</p>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-gray-600 text-sm">
                                                {{ $order->created_at->format('d M Y') }}<br>
                                                {{ $order->created_at->format('H:i') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                                Detail
                                            </a>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Order</h2>
                    <p class="text-gray-600">Tidak ada order yang terdaftar saat ini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection


