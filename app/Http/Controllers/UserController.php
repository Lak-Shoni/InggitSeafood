<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile(Request $request)
    {
        $query = Order::query();
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }
        $orders = $query->paginate(10);
        $user = Auth::user();
        $hutang = Hutang::where('user_id', $user->id)->sum('total'); // Menghitung total hutang

        return view('client.profile.index', compact('user', 'orders', 'hutang'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
