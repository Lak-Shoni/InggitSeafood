<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class AddNotifToView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $notif = Cart::where('user_id', $user->id)->where('status_order', 0)->count();
            view()->share('notif', $notif);
        } else {
            view()->share('notif', 0);
        }

        return $next($request);
    }
}
