<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CounterController;
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
Route::redirect('/dashboard/counter', '/dashboard', 301);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/counter/create', [CounterController::class, 'create'])->name('dashboard.counter.create');
    Route::get('/dashboard/counter/{counter}', [CounterController::class, 'show'])->name('dashboard.counter.show');
    Route::delete('/dashboard/counter/{counter}', [CounterController::class, 'destroy'])->name('dashboard.counter.destroy');
    Route::post('/dashboard/counter', [CounterController::class, 'store'])->name('dashboard.counter.store');
});







