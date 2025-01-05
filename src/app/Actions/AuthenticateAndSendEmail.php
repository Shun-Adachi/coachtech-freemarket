<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticateAndSendEmail
{
    public function __invoke(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

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
            $message->to($user->email)->subject('Login Verification');
        });

        // Fortifyの認証フローに影響を与えないように戻り値を調整
        return redirect()->route('login')->with('message', 'ログインメールを送信しました');
    }
}
