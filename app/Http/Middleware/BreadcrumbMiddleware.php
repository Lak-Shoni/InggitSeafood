<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class BreadcrumbMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $breadcrumbs = $this->generateBreadcrumbs($request);
        view()->share('breadcrumbs', $breadcrumbs);

        return $next($request);
    }
    private function generateBreadcrumbs(Request $request)
    {
        $routeName = $request->route() ? $request->route()->getName() : null;
        $breadcrumbs = [];

        switch ($routeName) {
            case 'home':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                ];
                break;
            case 'client.paket.index':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Paket', 'url' => url('/paket')],
                ];
                break;
            case 'profile':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Profile', 'url' => url('/profile')],
                ];
                break;
            case 'profile.edit':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Profile', 'url' => url('/profile')],
                    ['title' => 'Edit Profile', 'url' => url('/profile/edit')],
                ];
                break;
            case 'cart.show':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Cart', 'url' => url('/cart')],
                ];
                break;
            case 'checkout.form':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Cart', 'url' => url('/cart')],
                    ['title' => 'Checkout', 'url' => url('/checkout')],
                ];
                break;
            case 'order.success':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Order Success', 'url' => url('/order/success')],
                ];
                break;
            case 'order.failure':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Order Failure', 'url' => url('/order/failure')],
                ];
                break;
            case 'admin.dashboard':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Dashboard', 'url' => url('/admin/dashboard')],
                ];
                break;
            case 'admin.orders.index':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Daftar Pesanan', 'url' => url('/admin/orders')],
                ];
                break;
            case 'admin.pakets.index':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Kelola Paket', 'url' => url('/admin/pakets')],
                ];
                break;
            case 'admin.pakets.create':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Kelola Paket', 'url' => url('/admin/pakets')],
                    ['title' => 'Tambah Paket', 'url' => url('/admin/pakets/create')],
                ];
                break;
            case 'admin.pakets.edit':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Kelola Paket', 'url' => url('/admin/pakets')],
                    ['title' => 'Edit Paket', 'url' => url('/admin/pakets/{id}/edit')],
                ];
                break;
            case 'admin.inventories.index':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Inventaris', 'url' => url('/admin/inventories')],
                ];
                break;
            case 'admin.inventories.create':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Inventaris', 'url' => url('/admin/inventories')],
                    ['title' => 'Tambah Inventaris', 'url' => url('/admin/inventories/create')],
                ];
                break;
            case 'admin.inventories.edit':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Inventaris', 'url' => url('/admin/inventories')],
                    ['title' => 'Edit Inventaris', 'url' => url('/admin/inventories/{id}/edit')],
                ];
                break;
            case 'admin.bahan_masakan.index':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Bahan Masakan', 'url' => url('/admin/bahan_masakan')],
                ];
                break;
            case 'admin.bahan_masakan.show':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Bahan Masakan', 'url' => url('/admin/bahan_masakan')],
                    ['title' => 'Detail Bahan Masakan', 'url' => url('/admin/bahan_masakan/show')],
                ];
                break;
            case 'admin.bahan_masakan.create':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Bahan Masakan', 'url' => url('/admin/bahan_masakan')],
                    ['title' => 'Tambah Bahan Masakan', 'url' => url('/admin/bahan_masakan/create')],
                ];
                break;
            case 'admin.bahan_masakan.edit':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Bahan Masakan', 'url' => url('/admin/bahan_masakan')],
                    ['title' => 'Edit Bahan Masakan', 'url' => url('/admin/bahan_masakan/{id}/edit')],
                ];
                break;
            case 'admin.bahan_masakan.bahan_masuk':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Bahan Masakan', 'url' => url('/admin/bahan_masakan')],
                    ['title' => 'Bahan Masuk', 'url' => url('/admin/bahan_masakan/{id}/bahan_masuk')],
                ];
                break;
            case 'admin.bahan_masakan.bahan_keluar':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Bahan Masakan', 'url' => url('/admin/bahan_masakan')],
                    ['title' => 'Bahan Keluar', 'url' => url('/admin/bahan_masakan/{id}/bahan_keluar')],
                ];
                break;
            case 'admin.keuangan.index':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Keuangan', 'url' => url('/admin/keuangan')],
                ];
                break;
            case 'admin.keuangan.create':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Keuangan', 'url' => url('/admin/keuangan')],
                    ['title' => 'Tambah Keuangan', 'url' => url('/admin/keuangan/create')],
                ];
                break;
            case 'admin.keuangan.edit':
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                    ['title' => 'Keuangan', 'url' => url('/admin/keuangan')],
                    ['title' => 'Edit Keuangan', 'url' => url('/admin/keuangan/{id}/edit')],
                ];
                break;
            default:
                $breadcrumbs = [
                    ['title' => 'Home', 'url' => url('/')],
                ];
                break;
        }

        return $breadcrumbs;
    }
}
