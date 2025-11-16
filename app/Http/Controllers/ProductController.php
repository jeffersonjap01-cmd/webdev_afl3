<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class ProductController extends Controller
{

    public function home()
    {
        $menus = Menu::all();
        return view('home', compact('menus'));
    }
    
    public function products()
    {
        // Show all products in full listing
        $menus = Menu::all();
        return view('products', compact('menus'));
    }
}
