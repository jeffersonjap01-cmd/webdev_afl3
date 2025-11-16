<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'meja.lokasiToko', 'items.menu'])
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'meja.lokasiToko', 'items.menu']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,done'
        ]);

        // Prevent setting status to 'done' if payment is not paid
        if ($request->status === 'done' && $order->status_pembayaran !== 'Dibayar') {
            return back()->with('error', 'Tidak dapat menyelesaikan order yang belum dibayar!');
        }

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
}
