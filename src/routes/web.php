<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\CustomAuthenticatedSessionController;
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
//Fortify カスタマイズログイン
Route::get('/login', [CustomAuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);

//未認証ユーザー
Route::prefix('/')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/', [ItemController::class, 'index']);
    //検索情報の消去
    Route::middleware(['clear.session'])->group(function () {
        Route::get('/item/{item_id}', [ItemController::class, 'show']);
    });
});

//認証ユーザー
Route::middleware('auth')->group(function () {
    //検索情報の消去
    Route::middleware(['clear.session'])->group(function () {
        Route::post('/purchase/buy', [PurchaseController::class, 'buy']);
        Route::get('/item/favorite/{item_id}', [ItemController::class, 'favorite']);
        Route::post('/item/comment', [ItemController::class, 'comment']);
        Route::get('/sell', [SellController::class, 'sell']);
        Route::post('/sell/create', [SellController::class, 'store']);
        Route::get('/mypage', [UserController::class, 'index']);
        Route::get('/mypage/profile', [UserController::class, 'edit']);
        Route::patch('/mypage/profile/update', [UserController::class, 'update']);
        Route::patch('/purchase/address/update', [PurchaseController::class, 'update']);
        Route::get('/purchase/address', [PurchaseController::class, 'edit']);
        Route::post('/purchase/address', [PurchaseController::class, 'edit']);
        Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    });
});


Route::get('/verify-login', function (Request $request) {
    $token = $request->query('token');

    $user = User::where('login_token', $token)->first();

    if (!$user) {
        return redirect('/login')->withErrors(['error' => 'ログインに失敗しました']);
    }

    // トークンを無効化し、ログイン
    $user->login_token = null;
    $user->save();

    Auth::login($user);

    return redirect('/')->with('message', 'ログインしました');
});
