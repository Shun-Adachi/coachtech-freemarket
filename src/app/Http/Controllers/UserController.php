<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // プロフィール編集ページ表示
    public function edit_profile(Request $request)
    {
        return view('edit-profile');
    }
}
