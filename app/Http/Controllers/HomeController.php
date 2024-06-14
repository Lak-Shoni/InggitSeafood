<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class HomeController extends Controller
{
    public function index(){
        $menus = Menu::all(); // Mengambil semua data menu dari database
        return view('home', compact('menus')); // Mengirim data menu ke view home
    }
}
