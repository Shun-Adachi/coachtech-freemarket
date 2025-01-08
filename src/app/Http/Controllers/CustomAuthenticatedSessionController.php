<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;

class CustomAuthenticatedSessionController extends Controller
{
    /**
     * GET /login - ログインフォームを表示
     */
    public function create()
    {
        return view('auth.login'); // ログインフォームビューを返す
    }

    /**
     * POST /login - ログイン処理
     */

    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->login)->orWhere('name', $request->login)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login' => ['ユーザー名またはメールアドレスが見つかりません。'],
            ]);
        }
        $credentials = [
            'email' => $user->email,
            'password' => $request->password,
        ];

        if (!$user || !Auth::validate($credentials)) {
            throw ValidationException::withMessages([
                'password' => ['パスワードが間違っています'],
            ]);
        }

        // 一時トークンを生成
        $token = Str::random(40);
        $user->login_token = $token;
        $user->save();

        // 認証メールを送信
        Mail::send('emails.login', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email)->subject('【coachtechフリマ】認証ログイン');
        });

        return redirect()->route('login')->withInput()->with('message', 'ログインメールを送信しました');
    }
}
