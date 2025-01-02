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

Route::prefix('/')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/item/{item_id}', [ItemController::class, 'show']);
});

Route::get('/item', function () {
    return view('item');
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
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('/mypage/profile/update', [UserController::class, 'update']);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // カスタムリダイレクト先
})->name('logout');
