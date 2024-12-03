<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Client\ClientpaketController;
use App\Http\Controllers\Admin\paketController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\BahanMasakanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\NotificationController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk halaman client paket
Route::get('/paket', [ClientPaketController::class, 'index'])->name('client.paket.index');

Route::post('/contact', [ContactController::class, 'send']);

// Rute untuk otentikasi pengguna
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');


    Route::get('/checkout', [OrderController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'createOrder'])->name('checkout.create');
    Route::get('/checkout/payment', [OrderController::class, 'processPayment'])->name('payment.process');

    Route::get('/order/success', function () {
        return view('order.success');
    })->name('order.success');
    Route::post('/payment/notification', [OrderController::class, 'paymentNotification'])->name('payment.notification');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');


    Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::post('/order/detail/{id}', [OrderController::class, 'get_detail'])->name('order.detail');
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/terima/{id}', [OrderController::class, 'terima'])->name('order.terima');

    Route::get('orders/{order}/pdf', [OrderController::class, 'generatePDF'])->name('orders.pdf');

    // Rute yang memerlukan peran admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
        Route::get('/get-notifications', [NotificationController::class, 'getNotifications']);

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('pakets', paketController::class);
            Route::get('/admin/pakets/{id}/edit', [PaketController::class, 'edit'])->name('admin.pakets.edit');

            Route::resource('inventories', InventoryController::class);
            Route::get('/admin/inventories/{id}/edit', [InventoryController::class, 'edit'])->name('admin.inventories.edit');
            
            Route::resource('bahan_masakan', BahanMasakanController::class);
            // Route::resource('keuangan', KeuanganController::class);
            Route::resource('keuangan', KeuanganController::class)->except(['show']);

            // Route::get('bahan_masakan/{id}/bahan_masuk', [BahanMasakanController::class, 'bahanMasuk'])->name('bahan_masakan.bahan_masuk');
            // Route::get('bahan_masakan/{id}/bahan_keluar', [BahanMasakanController::class, 'bahanKeluar'])->name('bahan_masakan.bahan_keluar');
            Route::post('bahan_masakan/{id}/bahan_masuk', [BahanMasakanController::class, 'storeBahanMasuk'])->name('bahan_masakan.store_bahan_masuk');
            Route::post('bahan_masakan/{id}/bahan_keluar', [BahanMasakanController::class, 'storeBahanKeluar'])->name('bahan_masakan.store_bahan_keluar');
        });
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/order/failure', [OrderController::class, 'failure'])->name('order.failure');

        Route::get('/order/kirim/{id}', [OrderController::class, 'kirim'])->name('order.kirim');
        Route::get('/order/selesai/{id}', [OrderController::class, 'selesai'])->name('order.selesai');
        Route::get('/order/lunas/{id}', [OrderController::class, 'lunas'])->name('order.lunas');

        Route::get('keuangan/{id}/edit', [KeuanganController::class, 'edit'])->name('keuangan.edit');
        Route::get('/admin/keuangan/getOmset/{date}', [KeuanganController::class, 'getOmset']);
        Route::get('/admin/keuangan/getPurchasing/{date}', [KeuanganController::class, 'getPurchasing']);
        Route::get('admin/keuangan/download-pdf', [KeuanganController::class, 'generateMonthlyReportPDF'])->name('admin.keuangan.download_pdf');

        
    });
});
