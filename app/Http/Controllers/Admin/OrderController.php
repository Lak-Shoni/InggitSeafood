<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        } else {
            $query->orderBy('created_at', 'desc'); // Default sorting by latest orders
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
