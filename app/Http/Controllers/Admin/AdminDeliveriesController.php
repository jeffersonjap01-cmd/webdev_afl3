<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class AdminDeliveriesController extends Controller
{
    public function index()
    {
        $deliveries = Keranjang::with(['user', 'menu', 'lokasiToko', 'alamat'])
            ->latest()
            ->get();

        return view('admin.deliveries', compact('deliveries'));
    }
}

