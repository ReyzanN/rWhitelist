<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPublicController;
use App\Http\Controllers\HomePublicController;
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

/* Base Route */
Route::get('/', HomePublicController::class)->name('base');

/* Auth Route */
Route::get('/login',[AuthController::class, 'Login'])->name('auth.login');
Route::get('/loginValidation', [AuthController::class, 'TryLogin'])->name('auth.trylogin');
Route::get('/logout', [AuthController::class, 'Logout'])->name('auth.logout');

Route::middleware(['auth'])->group(function(){
    /* Dashboard */
    Route::get('/dashboard', DashboardPublicController::class)->name('dashPublic.index');
});
