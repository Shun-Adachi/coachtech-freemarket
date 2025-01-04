<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
/*
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
*/

Route::middleware('auth')->group(function () {
    Route::get('/item/favorite/{item_id}', [ItemController::class, 'favorite']);
    Route::post('/item/comment', [ItemController::class, 'comment']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell/create', [ItemController::class, 'store']);
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);
    Route::post('/purchase/buy', [ItemController::class, 'buy']);
    Route::post('/purchase/address', [ItemController::class, 'edit']);
    Route::post('/purchase/address/update', [ItemController::class, 'update']);
    Route::get('/mypage', [UserController::class, 'index']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::patch('/mypage/profile/update', [UserController::class, 'update']);
});

Route::prefix('/')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/item/{item_id}', [ItemController::class, 'show']);
});


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('message', 'ログアウトしました'); // カスタムリダイレクト先
})->name('logout');
