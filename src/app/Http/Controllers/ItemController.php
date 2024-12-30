<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ItemController extends Controller
{
    // インデックスページ表示
    public function index(Request $request)
    {
        return view('index');
    }
}
