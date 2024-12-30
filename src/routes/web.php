<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::post('/', function () {
    return view('index');
});


Route::get('/item', function () {
    return view('item');
});

Route::get('/mypage/profile', function () {
    return view('edit-profile');
});

Route::post('/mypage/profile', function () {
    return view('edit-profile');
});


Route::get('/mypage', function () {
    return view('mypage');
});

Route::post('/mypage', function () {
    return view('mypage');
});


Route::get('/sell', function () {
    return view('sell');
});

Route::get('/purchase', function () {
    return view('purchase');
});


Route::get('/purchase', function () {
    return view('purchase');
});

Route::post('/purchase', function () {
    return view('purchase');
});

Route::get('/purchase/address', function () {
    return view('edit-address');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/mypage/profile', [UserController::class, 'edit_profile']);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // カスタムリダイレクト先
})->name('logout');
