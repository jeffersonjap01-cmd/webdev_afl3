<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $keranjang = Keranjang::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        return view('keranjang.index', compact('keranjang'));
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
            'qty'     => 'required|integer|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        // Cek apakah item sudah ada
        $item = Keranjang::where('user_id', Auth::id())
            ->where('menu_id', $menu->id)
            ->first();

        if ($item) {
            
            $item->qty += $request->qty;
            $item->total_harga = $item->qty * $menu->harga;
            $item->save();
        } else {
            
            Keranjang::create([
                'user_id'     => Auth::id(),
                'menu_id'     => $menu->id,
                'qty'         => $request->qty,
                'total_harga' => $request->qty * $menu->harga
            ]);
        }

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

        $keranjang->qty = $request->qty;
        $keranjang->total_harga = $keranjang->qty * $keranjang->menu->harga;
        $keranjang->save();

        return back()->with('success', 'Jumlah item diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        $keranjang->delete();

        return back()->with('success', 'Item dihapus dari keranjang!');
    }
}
