<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン済みのユーザーはコメントを送信できる()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $item = $items->where('seller_id', '!=', $user->id)->random();

        $response = $this->actingAs($user)
            ->post('/comments', [
                'item_id' => $item->id,
                'sender_id' => $user->id,
                'content' => 'test'
            ]);

        $response->assertRedirect('/item:' . $item->id);

        $this->assertDatabaseHas('comments', [
            'sender_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function ログイン前のユーザーはコメントを送信できない()
    {
        // ユーザー作成
        User::factory(10)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $item = $items->random();
        // 未ログイン状態でコメント送信
        $response = $this->post('/comments', [
            'item_id'  => $item->id,
            'user_id'  => 9999, // 適当なID
            'content'  => 'test',
        ]);

        // ログイン画面にリダイレクトされることを確認
        $response->assertRedirect('/login');

        // DBに保存されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'test',
        ]);
    }

    /** @test */
    public function コメントが入力されていない場合、バリデーションメッセージが表示される()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $item = $items->where('seller_id', '!=', $user->id)->random();

        $response = $this->actingAs($user)
            ->post('/comments', [
                'item_id' => $item->id,
                'sender_id' => $user->id,
                'content' => ''
            ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function コメントが255字以上の場合、バリデーションメッセージが表示される()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $item = $items->where('seller_id', '!=', $user->id)->random();

        $response = $this->actingAs($user)
            ->post('/comments', [
                'item_id' => $item->id,
                'sender_id' => $user->id,
                'content' =>   '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890
                                12345678901234567890123456789012345678901234567890
                                12345678901234567890123456789012345678901234567890
                                12345678901234567890123456789012345678901234567890
                                123456' //256文字のコメント
            ]);

            $response->assertSessionHasErrors(['content']);
    }
}
