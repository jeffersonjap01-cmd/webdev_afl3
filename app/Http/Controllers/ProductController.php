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
    
    public function products(Request $request)
    {
        // Get search query
        $query = $request->input('search');
        
        // Start with all menus and apply search filter if provided
        $menusQuery = Menu::query();
        
        if ($query) {
            $menusQuery->where(function($q) use ($query) {
                $q->where('nama', 'like', '%' . $query . '%')
                  ->orWhere('deskripsi', 'like', '%' . $query . '%');
            });
        }
        
        $menus = $menusQuery->get();
        
        // Pass the search query back to the view for the search input
        return view('products', compact('menus', 'query'));
    }
}
