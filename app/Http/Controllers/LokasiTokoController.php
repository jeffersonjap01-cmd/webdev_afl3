<?php

namespace App\Http\Controllers;

use App\Models\LokasiToko;
use Illuminate\Http\Request;

class LokasiTokoController extends Controller
{
    // Menampilkan semua lokasi toko
    public function index()
    {
        $lokasi = LokasiToko::all();
        return view('lokasi.index', compact('lokasi'));
    }

    // Form tambah lokasi
    public function create()
    {
        return view('lokasi.create');
    }

    // Simpan lokasi baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20'
        ]);

        LokasiToko::create($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    // Form edit lokasi
    public function edit(LokasiToko $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    // Update data lokasi
    public function update(Request $request, LokasiToko $lokasi)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20'
        ]);

        $lokasi->update($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil diupdate!');
    }

    // Hapus lokasi
    public function destroy(LokasiToko $lokasi)
    {
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus!');
    }
}
