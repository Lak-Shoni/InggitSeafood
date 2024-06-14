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

// Route::get('/', function () {
//     return view('home');
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



    // Rute yang memerlukan peran admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('menus', MenuController::class);
            Route::resource('inventories', InventoryController::class);
            Route::resource('bahan_masakan', BahanMasakanController::class);
            Route::get('bahan_masakan/{id}/barang_masuk', [BahanMasakanController::class, 'barangMasuk'])->name('bahan_masakan.barang_masuk');
            Route::post('bahan_masakan/{id}/barang_masuk', [BahanMasakanController::class, 'storeBarangMasuk'])->name('bahan_masakan.store_barang_masuk');
            Route::get('bahan_masakan/{id}/barang_keluar', [BahanMasakanController::class, 'barangKeluar'])->name('bahan_masakan.barang_keluar');
            Route::post('bahan_masakan/{id}/barang_keluar', [BahanMasakanController::class, 'storeBarangKeluar'])->name('bahan_masakan.store_barang_keluar');
        });
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/order/failure', [OrderController::class, 'failure'])->name('order.failure');
        
    });
});

