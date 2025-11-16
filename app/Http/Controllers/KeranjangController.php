<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $keranjang = Keranjang::with(['menu', 'lokasiToko'])
            ->where('user_id', Auth::id())
            ->get();

        return view('keranjang.keranjang', compact('keranjang'));
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
            'lokasi_toko_id' => 'required|exists:lokasi_tokos,id',
            'qty'     => 'required|integer|min:1',
            'alamat_lengkap' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'nullable|string',
            'no_telepon' => 'nullable|string',
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

        // Create or get address
        $alamat = Alamat::create([
            'user_id' => Auth::id(),
            'alamat_lengkap' => $request->alamat_lengkap,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'no_telepon' => $request->no_telepon,
            'is_default' => false,
        ]);

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
            $item->alamat_id = $alamat->id;
            $item->save();
        } else {
            Keranjang::create([
                'user_id'     => Auth::id(),
                'menu_id'     => $menu->id,
                'lokasi_toko_id' => $request->lokasi_toko_id,
                'alamat_id' => $alamat->id,
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
