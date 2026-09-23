<?php
//use App\Http\Controllers\ProfileController; berfungsi untuk mengimpor kelas ProfileController dari namespace App\Http\Controllers. Ini memungkinkan kita untuk menggunakan ProfileController di dalam file ini tanpa harus menulis namespace lengkapnya setiap kali kita ingin menggunakannya.
use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\FoodController; berfungsi untuk mengimpor kelas FoodController dari namespace App\Http\Controllers. Ini memungkinkan kita untuk menggunakan FoodController di dalam file ini tanpa harus menulis namespace lengkapnya setiap kali kita ingin menggunakannya.
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\DashboardController; berfungsi untuk mengimpor kelas DashboardController dari namespace App\Http\Controllers. Ini memungkinkan kita untuk menggunakan DashboardController di dalam file ini tanpa harus menulis namespace lengkapnya setiap kali kita ingin menggunakannya.
use App\Http\Controllers\FoodController;
//use App\Http\Controllers\OrderController; berfungsi untuk mengimpor kelas OrderController dari namespace App\Http\Controllers. Ini memungkinkan kita untuk menggunakan OrderController di dalam file ini tanpa harus menulis namespace lengkapnya setiap kali kita ingin menggunakannya.
use App\Http\Controllers\OrderController;

// Halaman utama (Katalog Menu Pelanggan)
Route::get('/', [OrderController::class, 'index'])->name('customers.index');
// Route untuk menampilkan halaman checkout
Route::post('/checkout', [OrderController::class, 'store'])->name('customers.checkout');

// Arahkan dashboard utama Breeze langsung ke Admin Dashboard
// middleware 'auth' dan 'verified' memastikan hanya user yang sudah login dan terverifikasi emailnya yang bisa mengakses dashboard
Route::get('/dashboard', [OrderController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Group route yang hanya bisa diakses oleh user yang sudah login (auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //ini adalah route untuk mengupdate dan menghapus profile user
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //ini adalah route untuk menghapus profile user
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Alias route untuk admin dashboard
    Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');
    // Route untuk mengubah status pesanan (Admin)
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    // Route resource untuk master data makanan (Admin) Controller FoodController
    Route::resource('/admin/foods', FoodController::class);
});

// Route untuk mengakses file auth.php yang berisi route autentikasi (login, register, dll)
require __DIR__.'/auth.php';