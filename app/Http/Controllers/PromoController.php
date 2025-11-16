<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    // Admin: List all promos
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    // Admin: Create promo
    public function create()
    {
        return view('admin.promos.create');
    }

    // Admin: Store promo
    public function store(Request $request)
    {
        $request->validate([
            'nama_promo' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kode_promo' => 'required|string|unique:promos,kode_promo',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_nominal' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
            'min_pembelian' => 'nullable|integer|min:0',
            'max_diskon' => 'nullable|integer|min:0',
        ]);

        Promo::create($request->all());

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dibuat!');
    }

    // Admin: Edit promo
    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    // Admin: Update promo
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'nama_promo' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kode_promo' => 'required|string|unique:promos,kode_promo,' . $promo->id,
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_nominal' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
            'min_pembelian' => 'nullable|integer|min:0',
            'max_diskon' => 'nullable|integer|min:0',
        ]);

        $promo->update($request->all());

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui!');
    }

    // Admin: Delete promo
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dihapus!');
    }

    // User: Apply promo code
    public function apply(Request $request)
    {
        $request->validate([
            'kode_promo' => 'required|string',
        ]);

        $promo = Promo::where('kode_promo', $request->kode_promo)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->first();

        if (!$promo) {
            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'Kode promo tidak valid atau sudah tidak aktif.'], 400);
            }
            return back()->with('error', 'Kode promo tidak valid atau sudah tidak aktif.');
        }

        if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
            return response()->json(['promo' => $promo]);
        }

        return back()->with('promo_applied', $promo);
    }
}
