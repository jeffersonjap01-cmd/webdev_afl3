<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan semua order user
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['meja.lokasiToko', 'items.menu'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Menampilkan detail order
    public function show(Order $order)
    {
        // Pastikan user hanya bisa lihat order mereka sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['meja.lokasiToko', 'items.menu', 'user']);

        return view('orders.show', compact('order'));
    }

    // Menampilkan form create order
    public function create()
    {
        $lokasiToko = \App\Models\LokasiToko::with(['mejas' => function($query) {
            $query->where('status', 'kosong');
        }])->get();

        $keranjang = \App\Models\Keranjang::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang Anda kosong. Tambahkan produk terlebih dahulu!');
        }

        return view('orders.create', compact('lokasiToko', 'keranjang'));
    }

    // Membuat order baru dari keranjang
    public function store(Request $request)
    {
        $request->validate([
            'meja_id' => 'required|exists:mejas,id'
        ]);

        // Cek apakah meja sedang dipakai
        $meja = Meja::findOrFail($request->meja_id);

        if ($meja->status !== 'kosong') {
            return back()->with('error', 'Meja ini sedang dipakai!');
        }

        // Ambil semua item dari keranjang
        $keranjang = \App\Models\Keranjang::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong!');
        }

        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'meja_id' => $meja->id,
            'status' => 'pending',
            'last_activity_at' => now(),
        ]);

        // Pindahkan item dari keranjang ke order
        foreach ($keranjang as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item->menu_id,
                'qty' => $item->qty,
                'harga_satuan' => $item->menu->harga,
                'subtotal' => $item->total_harga,
            ]);
        }

        // Hapus semua item dari keranjang
        $keranjang->each->delete();

        // Tandai meja sebagai digunakan
        $meja->status = 'digunakan';
        $meja->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dibuat!');
    }

    // Mengubah status order (misal menjadi selesai)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,paid,done'
        ]);

        $order->status = $request->status;
        $order->save();

        // Jika order selesai → kosongkan meja
        if ($request->status === 'done') {
            $meja = $order->meja;
            $meja->status = 'kosong';
            $meja->save();
        }

        return back()->with('success', 'Status order diperbarui!');
    }

    // Menghapus order
    public function destroy(Order $order)
    {
        // Jika masih ada order → kosongkan meja
        $meja = $order->meja;
        $meja->status = 'kosong';
        $meja->save();

        $order->delete();

        return back()->with('success', 'Order dihapus!');
    }

    // Order Dine In langsung dari produk
    public function dineIn(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'meja_id' => 'required|exists:mejas,id',
            'qty' => 'required|integer|min:1'
        ]);

        $menu = \App\Models\Menu::findOrFail($request->menu_id);
        $meja = Meja::findOrFail($request->meja_id);

        // Validate stock
        if (($menu->stok ?? 0) <= 0) {
            return redirect()->route('orders.index')
                ->with('error', 'Produk ini sedang habis stok.');
        }

        if ($request->qty > ($menu->stok ?? 0)) {
            return redirect()->route('orders.index')
                ->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        // Validate that menu has a price
        if (!$menu->harga || $menu->harga <= 0) {
            return redirect()->route('orders.index')
                ->with('error', 'Produk ini belum memiliki harga.');
        }

        // Cek apakah meja sedang dipakai
        if ($meja->status !== 'kosong') {
            return redirect()->route('orders.index')
                ->with('error', 'Meja ini sedang dipakai! Silakan pilih meja lain.');
        }

        // Cek apakah user sudah punya order aktif di meja ini
        $existingOrder = Order::where('user_id', Auth::id())
            ->where('meja_id', $meja->id)
            ->whereIn('status', ['pending', 'proses'])
            ->first();

        if ($existingOrder) {
            // Tambahkan item ke order yang sudah ada
            \App\Models\OrderItem::create([
                'order_id' => $existingOrder->id,
                'menu_id' => $menu->id,
                'qty' => $request->qty,
                'harga_satuan' => $menu->harga,
                'subtotal' => $request->qty * $menu->harga,
            ]);
        } else {
            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'meja_id' => $meja->id,
                'status' => 'pending',
                'status_pembayaran' => 'Belum Bayar',
                'last_activity_at' => now(),
            ]);

            // Tambahkan item ke order
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'qty' => $request->qty,
                'harga_satuan' => $menu->harga,
                'subtotal' => $request->qty * $menu->harga,
            ]);

            // Tandai meja sebagai digunakan
            $meja->status = 'digunakan';
            $meja->save();
        }

        // Decrease stock
        $menu->stok = max(0, ($menu->stok ?? 0) - $request->qty);
        $menu->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order dine in berhasil dibuat!');
    }
}
