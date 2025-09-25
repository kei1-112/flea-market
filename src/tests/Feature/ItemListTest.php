<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

        /** @test */

    public function 全商品を取得できる()
    {
        User::factory(10)->create();
        $this->seed(\ItemTableSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        foreach (\App\Models\Item::all() as $item) {
            $response->assertSee($item->name);
        }
    }

            /** @test */

    public function 購入済み商品は「Sold」と表示される()
    {
        User::factory(10)->create();
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();
        $itemId = $items->random()->id;
        Item::where('id', $itemId)->update(['sold_flag' => 1]);

        // 商品一覧ページにアクセス
        $response = $this->get('/');

        $response->assertStatus(200);

        // Blade内で「sold」と表示されているか確認
        $response->assertSee('sold');
    }
            /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        User::factory(9)->create();
        $this->actingAs($user);
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();
        $users = User::all();
        $myItem = $items->random();
        // 自分の商品
        $myItem->update(['seller_id' => $user->id]);

        // 他人の商品
        $otherItem = $items->where('id', '!=', $myItem->id)->random();
        $otherUser = $users->where('id', '!=', $user->id)->random();
        $otherUserId = $otherUser->id;

        $otherItem->update(['seller_id' => $otherUserId]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // 自分の商品名は表示されない
        $response->assertDontSee($myItem->item_name);

        // 他人の商品名は表示される
        $response->assertSee($otherItem->item_name);
    }
}
