<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;


// USER CONTROLLER
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductPageController;


// ADMIN CONTROLLER
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\PenjualAdminController;
use App\Http\Controllers\Admin\LogAktivitasController;



/*
|--------------------------------------------------------------------------
| penjual controller
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\PenjualAuthController;
use App\Http\Controllers\Penjual\CustomerPenjualController;
use App\Http\Controllers\Penjual\ProductPenjualController;
use App\Http\Controllers\Penjual\DashboardPenjualController;
use App\Http\Controllers\Penjual\ContactPenjualController;






Route::get('/', function () {
    return Inertia::render('Home'); // ini Home.vue
})->middleware(['auth', 'verified']);
// HOME & GUEST ROUTES
// ==========================

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
})->name('home');

// ==========================
// USER ROUTES
// ==========================

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// ==========================
// API PUBLIC ROUTES
// ==========================

Route::get('/products', [ProductController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/produk/get-by-category', [ProductController::class, 'getByCategory']);
Route::get('/cart', function () {
    return Inertia::render('Cart');
})->name('cart');

Route::get('/cart', [CartController::class, 'index']);
Route::get('/produk', [ProductPageController::class, 'index'])->name('produk.index');
 Route::post('/kontak', [ContactMessageController::class, 'store'])->name('kontak.store');
 Route::post('/kontak', [ContactPenjualController::class, 'store'])->name('kontak.store');


// ==========================
// ADMIN AUTH ROUTES
// ==========================

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

// ==========================
// ADMIN DASHBOARD + MODULES
// ==========================

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/kontak', [ContactMessageController::class, 'index'])->name('admin.kontak.index');

    // Manajemen Produk
    Route::prefix('produk')->name('admin.produk.')->group(function () {
        Route::get('/', [ProductAdminController::class, 'index'])->name('index');
        Route::get('/create', [ProductAdminController::class, 'create'])->name('create');
        Route::post('/', [ProductAdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductAdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductAdminController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Customer (CRUD Lengkap)
    Route::prefix('customer')->name('admin.customer.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CustomerAdminController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\CustomerAdminController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CustomerAdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\CustomerAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\CustomerAdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\CustomerAdminController::class, 'destroy'])->name('destroy');
    });

    // Data Penjual
    Route::get('/penjual', [\App\Http\Controllers\Admin\PenjualAdminController::class, 'index'])->name('admin.penjual.index');
Route::get('/log-aktivitas', [\App\Http\Controllers\Admin\LogAktivitasController::class, 'index']);
    // Pesan Masuk (Dari Contact Form)
});



Route::prefix('penjual')->name('penjual.')->group(function () {
    // Login & Register Page (GET)
    Route::get('/login', fn() => Inertia::render('Penjual/Login'))->name('login');
    Route::get('/register', fn() => Inertia::render('Penjual/Register'))->name('register');

    // Proses Login & Register (POST)
    Route::post('/login', [PenjualAuthController::class, 'login']);
    Route::post('/register', [PenjualAuthController::class, 'register']);
    Route::post('/logout', [PenjualAuthController::class, 'logout'])->name('logout');
    Route::get('/kontak', [ContactPenjualController::class, 'index'])->name('admin.kontak.index');

    // Routes yang perlu autentikasi
    Route::middleware(['penjual.auth'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardPenjualController::class, 'index'])->name('dashboard');

        // Customer Management
        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/', [CustomerPenjualController::class, 'index'])->name('index');
            Route::get('/create', [CustomerPenjualController::class, 'create'])->name('create');
            Route::post('/', [CustomerPenjualController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CustomerPenjualController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CustomerPenjualController::class, 'update'])->name('update');
            Route::delete('/{id}', [CustomerPenjualController::class, 'destroy'])->name('destroy');
        });

        // Produk Management
        Route::prefix('produk')->name('produk.')->group(function () {
            Route::get('/', [ProductPenjualController::class, 'index'])->name('index');
            Route::get('/create', [ProductPenjualController::class, 'create'])->name('create');
            Route::post('/', [ProductPenjualController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductPenjualController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductPenjualController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductPenjualController::class, 'destroy'])->name('destroy');
        });

    });
});

// ==========================
// AUTH USER (Breeze)
require __DIR__.'/auth.php';
