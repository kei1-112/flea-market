<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\MyList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねアイコンを押すとmylistsに登録される()
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
            ->post('/mylists', [
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);

        $response->assertRedirect('/item:' . $item->id);

        $this->assertDatabaseHas('my_lists', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 追加済みのアイコンは色が変化する()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $item = $items->where('seller_id', '!=', $user->id)->random();
        // 先に登録
        MyList::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/item:' . $item->id);

        $response->assertStatus(200);

        // いいね済みのアイコンが表示されていることを確認
        $response->assertSee('class="fav__icon--my-list"', false);
    }

    /** @test */
    public function 再度いいねアイコンを押すと解除できる()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $item = $items->where('seller_id', '!=', $user->id)->random();

        // 先に登録
        MyList::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->delete('/mylists', [
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('my_lists', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
