<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログアウトができる
     *
     * @return void
     */
    public function test_user_can_logout()
    {
        $user = User::where('id', '1')->first();
        $this->actingAs($user);
        $response = $this->get('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
