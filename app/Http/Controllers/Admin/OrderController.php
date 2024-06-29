<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        }
    
        // Searching
        if ($request->has('search')) {
            $query->where('order_code', 'like', '%' . $request->search . '%');
        }
    
        $orders = $query->paginate(10); // Sesuaikan dengan jumlah data per halaman
    
        return view('admin.orders.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 10);  
    
    }
}
