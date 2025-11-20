<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Keranjang;
use App\Models\Alamat;
use App\Models\Meja;
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
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $buktiPath = time() . '.' . $request->bukti_pembayaran->extension();
        $request->bukti_pembayaran->move(public_path('images/payments'), $buktiPath);

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
            'order_type' => 'required|in:delivery,dine_in',
            'metode_pembayaran' => 'required|in:tunai,debit,kredit,e_wallet,qris',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string',
            'delivery_lokasi_toko_id' => 'required_if:order_type,delivery|exists:lokasi_tokos,id',
            'delivery_alamat_lengkap' => 'required_if:order_type,delivery|string',
            'delivery_kota' => 'required_if:order_type,delivery|string',
            'delivery_provinsi' => 'required_if:order_type,delivery|string',
            'delivery_kode_pos' => 'nullable|string',
            'delivery_no_telepon' => 'nullable|string',
            'dine_in_lokasi_toko_id' => 'required_if:order_type,dine_in|exists:lokasi_tokos,id',
            'meja_id' => 'required_if:order_type,dine_in|exists:mejas,id',
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

        $buktiPath = time() . '.' . $request->bukti_pembayaran->extension();
        $request->bukti_pembayaran->move(public_path('images/payments'), $buktiPath);

        if ($request->order_type === 'delivery') {
            $alamat = Alamat::create([
                'user_id' => Auth::id(),
                'alamat_lengkap' => $request->delivery_alamat_lengkap,
                'kota' => $request->delivery_kota,
                'provinsi' => $request->delivery_provinsi,
                'kode_pos' => $request->delivery_kode_pos,
                'no_telepon' => $request->delivery_no_telepon,
                'is_default' => false,
            ]);

            foreach ($keranjang as $item) {
                $item->order_type = 'delivery';
                $item->lokasi_toko_id = $request->delivery_lokasi_toko_id;
                $item->alamat_id = $alamat->id;
                $item->meja_id = null;
                $item->status_pembayaran = 'Dibayar';
                $item->save();
            }
        } else {
            $meja = Meja::where('id', $request->meja_id)
                ->where('lokasi_toko_id', $request->dine_in_lokasi_toko_id)
                ->where('status', 'kosong')
                ->first();

            if (!$meja) {
                return back()->withErrors([
                    'meja_id' => 'Meja yang dipilih sudah digunakan. Silakan pilih meja lain.',
                ])->withInput();
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'meja_id' => $meja->id,
                'status' => 'pending',
                'status_pembayaran' => 'Dibayar',
                'last_activity_at' => now(),
            ]);

            foreach ($keranjang as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item->menu_id,
                    'qty' => $item->qty,
                    'harga_satuan' => $item->menu->harga ?? ($item->qty > 0 ? $item->total_harga / $item->qty : $item->total_harga),
                    'subtotal' => $item->total_harga,
                ]);

                $item->delete();
            }

            $meja->status = 'digunakan';
            $meja->save();
        }

        return redirect()->route('keranjang.index')
            ->with('success', 'Pembayaran berhasil!');
    }
}
