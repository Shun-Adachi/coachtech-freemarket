<?php

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

Route::get('/edit-profile', function () {
    return view('edit-profile');
});

Route::post('/edit-profile', function () {
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
