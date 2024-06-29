<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Client\ClientMenuController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BahanMasakanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[HomeController::class,'index'])->name('home');



Route::get('/menu', [ClientMenuController::class, 'index'])->name('client.menu.index');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/mennu', function () {
//     return view('menu');
// })->name('home');

// Rute untuk melihat menu yang bisa diakses tanpa autentikasi
Route::resource('menus', MenuController::class)->only(['index', 'show']);



// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

    Route::get('/checkout', [OrderController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/success', function() {
        return view('order.success');
    })->name('order.success');
    Route::post('/payment/notification', [OrderController::class, 'paymentNotification'])->name('payment.notification');
    Route::get('/profile',[UserController::class,'showProfile'])->name('profile');

    Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::post('/order/detail/{id}', [OrderController::class, 'get_detail'])->name('order.detail');
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/terima/{id}', [OrderController::class, 'terima'])->name('order.terima');

    // Rute yang memerlukan peran admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('menus', MenuController::class);
            Route::resource('inventories', InventoryController::class);
            Route::resource('bahan_masakan', BahanMasakanController::class);
            Route::resource('keuangan', KeuanganController::class);
            Route::get('bahan_masakan/{id}/bahan_masuk', [BahanMasakanController::class, 'bahanMasuk'])->name('bahan_masakan.bahan_masuk');
            Route::post('bahan_masakan/{id}/bahan_masuk', [BahanMasakanController::class, 'storeBahanMasuk'])->name('bahan_masakan.store_bahan_masuk');
            Route::get('bahan_masakan/{id}/bahan_keluar', [BahanMasakanController::class, 'bahanKeluar'])->name('bahan_masakan.bahan_keluar');
            Route::post('bahan_masakan/{id}/bahan_keluar', [BahanMasakanController::class, 'storeBahanKeluar'])->name('bahan_masakan.store_bahan_keluar');
        });
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/order/failure', [OrderController::class, 'failure'])->name('order.failure');
        
        Route::get('/order/kirim/{id}', [OrderController::class, 'kirim'])->name('order.kirim');
        Route::get('/order/selesai/{id}', [OrderController::class, 'selesai'])->name('order.selesai');
        Route::get('/order/lunas/{id}', [OrderController::class, 'lunas'])->name('order.lunas');
        
        Route::get('keuangan/{id}/edit', [KeuanganController::class, 'edit'])->name('keuangan.edit');

    });
});

