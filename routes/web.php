<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	return view('welcome');
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'create']);
Route::post('/admin/login', [AdminController::class, 'store']);

Route::middleware('admin')->group(function () {
	Route::prefix('/admin')->group(function () {
		Route::get('/', [AdminController::class, 'dashboard']);
		Route::get('/profile', [AdminController::class, 'edit'])->name('admin.profile');
		Route::post('/logout', [AdminController::class, 'destroy'])->name('admin.logout');
	});
});



Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
