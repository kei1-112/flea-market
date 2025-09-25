<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** test     */
    public function test_ログイン状態でログアウトボタンを押すとログアウトされる()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // ユーザーを作成してログイン状態にする
        $user = User::factory()->create();
        $this->actingAs($user);

        // ログアウト実行
        $response = $this->post('/logout');

        // リダイレクト
        $response->assertRedirect('/');

        // 認証が解除されていることを確認
        $this->assertGuest();
    }
}
