<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MerekController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\KatalogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik Katalog Bahan Bangunan
|--------------------------------------------------------------------------
| Dapat diakses oleh calon pembeli secara publik tanpa autentikasi.
*/
Route::get('/', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/api/produk/{produk}', [KatalogController::class, 'show'])->name('produk.show');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi Admin
|--------------------------------------------------------------------------
| - Form login & post dibatasi untuk guest (pengguna belum login).
| - Route::name('login') digunakan oleh middleware auth standar Laravel saat redirect.
| - Logout dilindungi oleh middleware auth dengan verifikasi CSRF.
*/
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| Rute Panel Administrasi (Terproteksi Middleware 'auth')
|--------------------------------------------------------------------------
| Semua rute dikelompokkan dengan prefix '/admin', namespace rute 'admin.*',
| dan wajib memiliki sesi login yang valid.
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Ringkasan & Statistik Toko
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');

    // 2. CRUD Manajemen Kategori Bahan Bangunan
    Route::resource('kategori', KategoriController::class)->except(['show']);

    // 3. CRUD Manajemen Merek Pabrikan
    Route::resource('merek', MerekController::class)->except(['show']);

    // 4. CRUD Manajemen Produk & Material Bangunan (Form Upload Gambar)
    Route::patch('produk/{produk}/toggle-pin', [ProdukController::class, 'togglePin'])->name('produk.toggle-pin');
    Route::resource('produk', ProdukController::class)->except(['show']);
});
