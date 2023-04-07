<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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
Route::redirect('/home', '/dashboard', 301);
Route::redirect('/', '/dashboard', 301);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::get('/dashboard/{counter}', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::delete('/dashboard/{counter}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');
    Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');
});







