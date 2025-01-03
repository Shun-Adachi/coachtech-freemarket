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
    Route::get('/item/favorite/{item_id}', [ItemController::class, 'favorite']);
    Route::post('/item/comment', [ItemController::class, 'comment']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell/create', [ItemController::class, 'store']);
    Route::get('/mypage', [UserController::class, 'index']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('/mypage/profile/update', [UserController::class, 'update']);
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('message', 'ログアウトしました'); // カスタムリダイレクト先
})->name('logout');
