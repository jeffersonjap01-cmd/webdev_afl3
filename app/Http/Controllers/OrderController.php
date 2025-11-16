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
            ->with('meja')
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Membuat order baru
    public function store(Request $request)
    {
        $request->validate([
            'meja_id' => 'required|exists:mejas,id'
        ]);

        // Cek apakah meja sedang dipakai
        $meja = Meja::findOrFail($request->meja_id);

        if ($meja->is_occupied) {
            return back()->with('error', 'Meja ini sedang dipakai!');
        }

        // Tandai meja sebagai terpakai
        $meja->is_occupied = true;
        $meja->save();

        // Buat order
        Order::create([
            'user_id' => Auth::id(),
            'meja_id' => $meja->id,
            'status' => 'pending',
            'last_activity_at' => now(),
        ]);

        return back()->with('success', 'Order berhasil dibuat!');
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
            $meja->is_occupied = false;
            $meja->save();
        }

        return back()->with('success', 'Status order diperbarui!');
    }

    // Menghapus order
    public function destroy(Order $order)
    {
        // Jika masih ada order → kosongkan meja
        $meja = $order->meja;
        $meja->is_occupied = false;
        $meja->save();

        $order->delete();

        return back()->with('success', 'Order dihapus!');
    }
}
