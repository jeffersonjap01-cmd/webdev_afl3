@extends('layouts.mainlayout')

@section('title', 'Order Saya - Alvca Matcha')

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
            <h1 class="text-4xl font-bold text-green-800 mb-3">Order Saya</h1>
            <p class="text-gray-700 text-lg">
                Lihat semua order yang telah Anda buat.
            </p>
        </div>
    </section>

    {{-- Create Dine In Order Section --}}
    @auth
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                <h2 class="text-2xl font-bold text-green-800 mb-6">Buat Order Dine In</h2>
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('orders.dineIn') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="menu_id" class="block text-gray-700 font-medium mb-2">Pilih Produk</label>
                        <select name="menu_id" id="menu_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">-- Pilih Produk --</option>
                            @php
                                $menus = \App\Models\Menu::where('stok', '>', 0)->get();
                            @endphp
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}" data-price="{{ $menu->harga }}" data-stock="{{ $menu->stok }}">
                                    {{ $menu->nama }} - Rp {{ number_format($menu->harga, 0, ',', '.') }} (Stok: {{ $menu->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="qty" class="block text-gray-700 font-medium mb-2">Jumlah</label>
                        <input type="number" 
                               name="qty" 
                               id="qty"
                               value="1" 
                               min="1" 
                               max="1"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <p class="text-sm text-gray-500 mt-1" id="stock_info"></p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-3">Pilih Lokasi & Meja:</label>
                        <div class="space-y-4">
                            @php
                                $lokasiToko = \App\Models\LokasiToko::with(['mejas' => function($query) {
                                    $query->where('status', 'kosong');
                                }])->get();
                            @endphp
                            @foreach($lokasiToko as $lokasi)
                                @if($lokasi->mejas->count() > 0)
                                    <div class="border border-green-200 rounded-lg p-4">
                                        <h5 class="font-semibold text-green-800 mb-2">{{ $lokasi->nama_lokasi }}</h5>
                                        @if($lokasi->alamat)
                                            <p class="text-gray-600 text-sm mb-3">{{ $lokasi->alamat }}</p>
                                        @endif
                                        
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach($lokasi->mejas as $meja)
                                                <label class="relative">
                                                    <input type="radio" 
                                                           name="meja_id" 
                                                           value="{{ $meja->id }}" 
                                                           class="peer hidden"
                                                           required>
                                                    <div class="border-2 border-gray-300 rounded-lg p-3 text-center cursor-pointer hover:border-green-500 transition-colors peer-checked:border-green-600 peer-checked:bg-green-50">
                                                        <p class="font-semibold text-sm text-gray-700 peer-checked:text-green-700">Meja {{ $meja->nomor_meja }}</p>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if($lokasiToko->flatMap->mejas->isEmpty())
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800 text-sm">Tidak ada meja yang tersedia saat ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                            {{ $lokasiToko->flatMap->mejas->isEmpty() ? 'disabled' : '' }}>
                        Buat Order Dine In
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('menu_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            const qtyInput = document.getElementById('qty');
            const stockInfo = document.getElementById('stock_info');
            
            if (stock) {
                qtyInput.setAttribute('max', stock);
                stockInfo.textContent = 'Stok tersedia: ' + stock;
            } else {
                qtyInput.setAttribute('max', '1');
                stockInfo.textContent = '';
            }
        });
    </script>
    @endauth

    {{-- Orders Section --}}
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="text-xl font-bold text-green-800">Order #{{ $order->id }}</h3>
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                                Dine In
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                            <span>
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </span>
                                            <span>
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $order->meja->lokasiToko->nama_lokasi }} - Meja {{ $order->meja->nomor_meja }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'proses' => 'bg-blue-100 text-blue-800',
                                                'paid' => 'bg-green-100 text-green-800',
                                                'done' => 'bg-gray-100 text-gray-800'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Menunggu',
                                                'proses' => 'Diproses',
                                                'paid' => 'Dibayar',
                                                'done' => 'Selesai'
                                            ];
                                        @endphp
                                        <span class="px-4 py-2 rounded-full font-semibold text-sm {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                        <span class="px-4 py-2 rounded-full font-semibold text-sm {{ $order->status_pembayaran === 'Dibayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $order->status_pembayaran ?? 'Belum Bayar' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="font-semibold text-green-800 mb-3">Item Pesanan:</h4>
                                    <div class="space-y-2">
                                        @php
                                            $orderTotal = 0;
                                        @endphp
                                        @foreach($order->items as $item)
                                            @php
                                                $orderTotal += $item->subtotal;
                                            @endphp
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-700">
                                                    {{ $item->menu->nama }} x{{ $item->qty }}
                                                </span>
                                                <span class="font-semibold text-gray-800">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                                        <span class="font-bold text-green-800">Total:</span>
                                        <span class="text-xl font-bold text-green-700">Rp {{ number_format($orderTotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                    <div class="mt-4 pt-4 border-t border-gray-200 flex gap-3">
                                    <a href="{{ route('orders.show', $order->id) }}" 
                                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors duration-200">
                                        Lihat Detail
                                    </a>
                                    @if($order->status_pembayaran === 'Belum Bayar')
                                        <button onclick="openPaymentModal({{ $order->id }}, {{ $orderTotal }})" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors duration-200">
                                            Bayar Sekarang
                                        </button>
                                    @else
                                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                                            Sudah Dibayar
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Order Dine In</h2>
                    <p class="text-gray-600 mb-6">Buat order dine in pertama Anda menggunakan form di atas!</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Payment Modal --}}
    @auth
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-green-800">Pembayaran Order</h3>
                    <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="paymentForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="promo_id" id="modal_promo_id">

                    {{-- Promo Code --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Kode Promo (Opsional)</label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   id="promo_code_input"
                                   placeholder="Masukkan kode promo"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <button type="button" 
                                    onclick="applyPromo()"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors">
                                Terapkan
                            </button>
                        </div>
                        <div id="promo_message" class="mt-2"></div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="tunai">Tunai</option>
                            <option value="debit">Debit</option>
                            <option value="kredit">Kredit</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Bukti Pembayaran <span class="text-red-500">*</span></label>
                        <input type="file" 
                               name="bukti_pembayaran" 
                               accept="image/*"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>

                    <div class="mb-6 p-4 bg-green-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-green-800">Total Pembayaran:</span>
                            <span class="text-2xl font-bold text-green-700" id="modal_total">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" 
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            Bayar Sekarang
                        </button>
                        <button type="button" 
                                onclick="closePaymentModal()"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentOrderId = null;
        let currentTotal = 0;
        let appliedPromo = null;

        function openPaymentModal(orderId, total) {
            currentOrderId = orderId;
            currentTotal = total;
            document.getElementById('modal_total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            document.getElementById('paymentForm').action = '/orders/' + orderId + '/payment';
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('promo_code_input').value = '';
            document.getElementById('promo_message').innerHTML = '';
            document.getElementById('modal_promo_id').value = '';
            appliedPromo = null;
        }

        function applyPromo() {
            const code = document.getElementById('promo_code_input').value;
            if (!code) {
                document.getElementById('promo_message').innerHTML = '<div class="text-red-600 text-sm">Masukkan kode promo</div>';
                return;
            }

            fetch('/promo/apply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ kode_promo: code })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => Promise.reject(data));
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    document.getElementById('promo_message').innerHTML = '<div class="text-red-600 text-sm">' + data.error + '</div>';
                } else if (data.promo) {
                    appliedPromo = data.promo;
                    document.getElementById('modal_promo_id').value = data.promo.id;
                    let discount = 0;
                    if (data.promo.diskon_persen > 0) {
                        discount = (currentTotal * data.promo.diskon_persen) / 100;
                        if (data.promo.max_diskon) {
                            discount = Math.min(discount, data.promo.max_diskon);
                        }
                    } else if (data.promo.diskon_nominal) {
                        discount = data.promo.diskon_nominal;
                    }
                    const finalTotal = Math.max(0, currentTotal - discount);
                    document.getElementById('modal_total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalTotal);
                    document.getElementById('promo_message').innerHTML = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded text-sm">Promo diterapkan: ' + data.promo.nama_promo + '</div>';
                }
            })
            .catch(error => {
                const errorMsg = error.error || error.message || 'Terjadi kesalahan';
                document.getElementById('promo_message').innerHTML = '<div class="text-red-600 text-sm">' + errorMsg + '</div>';
            });
        }

        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });
    </script>
    @endauth
@endsection

