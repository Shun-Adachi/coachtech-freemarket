<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use App\Http\Requests\LoginRequest;
//use App\Http\Controllers\Auth\AuthenticatedSessionController;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {/*
        Fortify::authenticateUsing(function ($request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user; // ユーザーオブジェクトを返す
            }

            return null; // 認証失敗時はnullを返す
        });

        // Fortifyのログイン処理にカスタムコントローラーを適用
        $this->app->bind(
            \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class,
            AuthenticatedSessionController::class
        );
*/
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });


        // 会員登録ページにリダイレクト
        $this->app->singleton(\Laravel\Fortify\Contracts\RegisterResponse::class, function ($app) {
            return new class implements \Laravel\Fortify\Contracts\RegisterResponse {
                public function toResponse($request)
                {
                    return redirect('/mypage/profile');
                }
            };
        });

        // LoginRequestをカスタムクラスに置き換える
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            LoginRequest::class
        );

        // ログイン後のリダイレクト先を変更
        $this->app->singleton(\Laravel\Fortify\Contracts\LoginResponse::class, function ($app) {
            return new class implements \Laravel\Fortify\Contracts\LoginResponse {
                public function toResponse($request)
                {
                    return redirect('/'); // ログイン後の固定リダイレクト先
                }
            };
        });
    }
}
