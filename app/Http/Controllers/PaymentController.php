<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Payment for Order (Dine In)
    public function storeOrder(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status_pembayaran === 'Dibayar') {
            return back()->with('error', 'Order ini sudah dibayar.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,debit,kredit,e_wallet,qris',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // Calculate total from order items
        $total = $order->items->sum('subtotal');

        // Apply promo if exists
        if ($request->has('promo_id')) {
            $promo = \App\Models\Promo::find($request->promo_id);
            if ($promo && $promo->status === 'aktif' && now()->between($promo->tanggal_mulai, $promo->tanggal_berakhir)) {
                if ($total >= ($promo->min_pembelian ?? 0)) {
                    if ($promo->diskon_persen > 0) {
                        $diskon = ($total * $promo->diskon_persen) / 100;
                        if ($promo->max_diskon) {
                            $diskon = min($diskon, $promo->max_diskon);
                        }
                        $total -= $diskon;
                    } elseif ($promo->diskon_nominal) {
                        $total -= $promo->diskon_nominal;
                    }
                }
            }
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = time() . '.' . $request->bukti_pembayaran->extension();
            $request->bukti_pembayaran->move(public_path('images/payments'), $buktiPath);
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah' => $total,
            'status' => 'berhasil',
            'tanggal_bayar' => now(),
            'bukti_pembayaran' => $buktiPath,
            'catatan' => $request->catatan,
        ]);

        // Update order payment status
        $order->status_pembayaran = 'Dibayar';
        $order->save();

        // Delete promo if applied
        if ($request->has('promo_id')) {
            $promo = \App\Models\Promo::find($request->promo_id);
            if ($promo) {
                $promo->delete();
            }
        }

        return redirect()->route('orders.index')
            ->with('success', 'Pembayaran berhasil!');
    }

    // Payment for Cart (Delivery)
    public function storeCart(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,debit,kredit,e_wallet,qris',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $keranjang = Keranjang::with('menu')
            ->where('user_id', Auth::id())
            ->where('status_pembayaran', 'Belum Bayar')
            ->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong atau sudah dibayar.');
        }

        $total = $keranjang->sum('total_harga');

        // Apply promo if exists
        if ($request->has('promo_id')) {
            $promo = \App\Models\Promo::find($request->promo_id);
            if ($promo && $promo->status === 'aktif' && now()->between($promo->tanggal_mulai, $promo->tanggal_berakhir)) {
                if ($total >= ($promo->min_pembelian ?? 0)) {
                    if ($promo->diskon_persen > 0) {
                        $diskon = ($total * $promo->diskon_persen) / 100;
                        if ($promo->max_diskon) {
                            $diskon = min($diskon, $promo->max_diskon);
                        }
                        $total -= $diskon;
                    } elseif ($promo->diskon_nominal) {
                        $total -= $promo->diskon_nominal;
                    }
                    // Delete promo after use
                    $promo->delete();
                }
            }
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = time() . '.' . $request->bukti_pembayaran->extension();
            $request->bukti_pembayaran->move(public_path('images/payments'), $buktiPath);
        }

        // Update all cart items
        foreach ($keranjang as $item) {
            $item->status_pembayaran = 'Dibayar';
            $item->save();
        }

        return redirect()->route('keranjang.index')
            ->with('success', 'Pembayaran berhasil!');
    }
}
