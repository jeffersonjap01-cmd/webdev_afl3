<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Alamat;
use App\Models\LokasiToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $keranjang = Keranjang::with(['menu', 'lokasiToko', 'meja', 'alamat'])
            ->where('user_id', Auth::id())
            ->get();

        $lokasiTokos = LokasiToko::with(['mejas' => function ($query) {
            $query->where('status', 'kosong');
        }])->get();

        $unpaidItems = $keranjang->where('status_pembayaran', 'Belum Bayar');

        $defaultOrderType = $unpaidItems
            ->pluck('order_type')
            ->filter()
            ->first() ?? 'delivery';

        $grandTotal = $unpaidItems->sum('total_harga');
        $promoApplied = session('promo_applied');
        $promoDiscount = 0;

        if ($promoApplied) {
            $now = now();
            $isActive = (!isset($promoApplied->status) || $promoApplied->status === 'aktif')
                && (!isset($promoApplied->tanggal_mulai) || $promoApplied->tanggal_mulai <= $now)
                && (!isset($promoApplied->tanggal_berakhir) || $promoApplied->tanggal_berakhir >= $now);

            if ($isActive && $grandTotal >= ($promoApplied->min_pembelian ?? 0)) {
                if (($promoApplied->diskon_persen ?? 0) > 0) {
                    $promoDiscount = ($grandTotal * $promoApplied->diskon_persen) / 100;
                    if ($promoApplied->max_diskon) {
                        $promoDiscount = min($promoDiscount, $promoApplied->max_diskon);
                    }
                } elseif ($promoApplied->diskon_nominal) {
                    $promoDiscount = $promoApplied->diskon_nominal;
                }
            }
        }

        $payableTotal = max(0, $grandTotal - $promoDiscount);

        return view('keranjang.keranjang', [
            'keranjang' => $keranjang,
            'lokasiTokos' => $lokasiTokos,
            'defaultOrderType' => $defaultOrderType,
            'grandTotal' => $grandTotal,
            'promoApplied' => $promoApplied,
            'promoDiscount' => $promoDiscount,
            'payableTotal' => $payableTotal,
        ]);
        // klo blm ada view 
        //return response()->json($keranjang);
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty'     => 'required|integer|min:1',
            'lokasi_toko_id' => 'nullable|exists:lokasi_tokos,id',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        // Validate stock
        if (($menu->stok ?? 0) <= 0) {
            return back()->withErrors(['menu_id' => 'Produk ini sedang habis stok.'])->withInput();
        }

        if ($request->qty > ($menu->stok ?? 0)) {
            return back()->withErrors(['qty' => 'Jumlah melebihi stok yang tersedia.'])->withInput();
        }

        // Validate that menu has a price
        if (!$menu->harga || $menu->harga <= 0) {
            return back()->withErrors(['menu_id' => 'Produk ini belum memiliki harga.'])->withInput();
        }

        $alamatId = null;
        if ($request->filled('alamat_lengkap') || $request->filled('kota') || $request->filled('provinsi')) {
            $request->validate([
                'alamat_lengkap' => 'required|string',
                'kota' => 'required|string',
                'provinsi' => 'required|string',
                'kode_pos' => 'nullable|string',
                'no_telepon' => 'nullable|string',
            ]);

            $alamat = Alamat::create([
                'user_id' => Auth::id(),
                'alamat_lengkap' => $request->alamat_lengkap,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'no_telepon' => $request->no_telepon,
                'is_default' => false,
            ]);

            $alamatId = $alamat->id;
        }

        // Cek apakah item sudah ada dengan lokasi yang sama
        $item = Keranjang::where('user_id', Auth::id())
            ->where('menu_id', $menu->id)
            ->where('lokasi_toko_id', $request->lokasi_toko_id)
            ->where('status_pembayaran', 'Belum Bayar')
            ->first();

        if ($item) {
            // Check if new total qty exceeds stock
            if (($item->qty + $request->qty) > ($menu->stok ?? 0)) {
                return back()->withErrors(['qty' => 'Jumlah melebihi stok yang tersedia.'])->withInput();
            }
            
            $item->qty += $request->qty;
            $item->total_harga = $item->qty * $menu->harga;
            if ($alamatId) {
                $item->alamat_id = $alamatId;
            }
            $item->save();
        } else {
            Keranjang::create([
                'user_id'     => Auth::id(),
                'menu_id'     => $menu->id,
                'lokasi_toko_id' => $request->lokasi_toko_id,
                'alamat_id' => $alamatId,
                'qty'         => $request->qty,
                'total_harga' => $request->qty * $menu->harga,
                'status_pembayaran' => 'Belum Bayar',
            ]);
        }

        // Decrease stock
        $menu->stok = max(0, ($menu->stok ?? 0) - $request->qty);
        $menu->save();

        return back()->with('success', 'Berhasil menambahkan ke keranjang!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keranjang $keranjang)
    {
        if ($keranjang->status_pembayaran === 'Dibayar') {
            return back()->withErrors(['qty' => 'Item yang sudah dibayar tidak dapat diubah.']);
        }

        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $menu = $keranjang->menu;
        $oldQty = $keranjang->qty;
        $newQty = $request->qty;

        // Check stock availability
        $availableStock = ($menu->stok ?? 0) + $oldQty; // Add back old qty
        if ($newQty > $availableStock) {
            return back()->withErrors(['qty' => 'Jumlah melebihi stok yang tersedia.'])->withInput();
        }

        $keranjang->qty = $newQty;
        $keranjang->total_harga = $keranjang->qty * $menu->harga;
        $keranjang->save();

        // Update stock
        $menu->stok = $availableStock - $newQty;
        $menu->save();

        return back()->with('success', 'Jumlah item diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        // Return stock if not paid
        if ($keranjang->status_pembayaran === 'Belum Bayar') {
            $menu = $keranjang->menu;
            $menu->stok = ($menu->stok ?? 0) + $keranjang->qty;
            $menu->save();
        }

        $keranjang->delete();

        return back()->with('success', 'Item dihapus dari keranjang!');
    }
}
