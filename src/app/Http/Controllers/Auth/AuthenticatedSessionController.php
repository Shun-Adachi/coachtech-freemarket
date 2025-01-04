<?php

namespace App\Http\Controllers\Auth;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as BaseController;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends BaseController
{
    protected function authenticated(Request $request, $user)
    {
        // セッションに保存されたリダイレクト先をリセット
        $request->session()->forget('url.intended');

        return redirect('/'); // ログイン後のリダイレクト先
    }
}
