<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\MyList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

        /** @test */

    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        $this->seed(\ItemTableSeeder::class);

        $userId = $user->id;

        $items = Item::all();

        $favItemId = $items->random()->id;

        MyList::create([
            'user_id' => $userId,
            'item_id' => $favItemId,
        ]);
        $response = $this->get('/?tab=mylist');

        // MyListに登録した商品は表示されることを確認
        $response->assertSee($items->find($favItemId)->item_name);

        // 登録していない商品は表示されないことを確認
        $notFavItem = $items->where('id', '!=', $favItemId)->first();
        $response->assertDontSee($notFavItem->item_name);
        // $this->assertTrue(true);
    }

            /** @test */

    public function 購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();
        $this->seed(\ItemTableSeeder::class);

        $userId = $user->id;

        $items = Item::all();
        $favItemId = $items->random()->id;
        Item::where('id', $favItemId)->update(['sold_flag' => 1]);

        MyList::create([
            'user_id' => $userId,
            'item_id' => $favItemId,
        ]);

        // 商品一覧ページにアクセス
        $response = $this->get('/?tab=mylist');

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

        $userId = $user->id;

        $items = Item::all();
        $users = User::all();
        $myItem = $items->random();
        // 自分の商品
        $myItem->update(['seller_id' => $user->id]);
        $myItemId = $myItem->id;

        $response = $this->get('/?tab=mylist');

        MyList::create([
            'user_id' => $userId,
            'item_id' => $myItemId,
        ]);

        $response->assertStatus(200);
        // 自分の商品名は表示されない
        $response->assertDontSee($myItem->item_name);
    }
                /** @test */

    public function 未認証の場合は何も表示されない()
    {
        $response = $this->get('/?tab=mylist');

        // 商品要素が一つも表示されないことを確認
        $response->assertDontSee('<div class="main__item">', false);
    }
}
