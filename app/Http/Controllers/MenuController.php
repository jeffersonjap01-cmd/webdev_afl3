<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function home()
    {
        // Fetch menus from the database
        $menus = Menu::all();

        // Pass the $menus variable to the view
        return view('home', compact('menus'));
    }
}