<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('is_read', false)->get();
        $unreadNotificationsCount = $notifications->count();

        $pendingOrdersCount = Order::where('order_status', '!=', 'Selesai')->count();
        $usersCount = User::count();

        // $totalOmset = Keuangan
        // $dataKeuangan->sum('omset');

        $totalOmset = Keuangan::sum('omset');
        $totalProfit = Keuangan::sum('profit');


        return view('dashboard', compact('notifications', 'unreadNotificationsCount', 'pendingOrdersCount', 'usersCount','totalOmset','totalProfit'));
    }
}
