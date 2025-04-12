<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
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

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [MainController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'checkRole'], function () {


    Route::get('/', [MainController::class, 'home'])->name('home');
    Route::post('/search-user', [MainController::class, 'searchUser'])->name('search.user');
    Route::get('/user', [MainController::class, 'user'])->name('user');
});
