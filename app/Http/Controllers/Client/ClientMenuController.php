<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;


class ClientMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('client.menu.index', compact('menus'));
    }
}
