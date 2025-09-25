<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserInformationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）()
    {
        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->update(['profile_img' => 'test_image.png']);

        User::factory(9)->create();
        // 商品作成
        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        $sellItem = $items->random();

        //出品した商品の設定
        $sellItem->update(['seller_id' => $user->id]);

        //購入した商品の設定、購入の処理
        $purchaseItem = $items->filter(function ($item) use ($user, $sellItem) {
            return $item->seller_id != $user->id
                && $item->id != $sellItem->id;
        })->random(1)->first();

        $purchaseItem->update(['sold_flag' => 1]);

        $order = Order::create([
            'purchaser_id' => $user->id,
            'payment_method' => 'コンビニ支払い',
            'destination_post_number' => '123-4567',
            'destination_address' => 'test',
            'destination_building' => 'test',
        ]);


        OrderDetail::create([
            'order_id' => $order->id,
            'item_id' => $purchaseItem->id,
        ]);

        $response = $this->get('/mypage');

        //出品した商品が表示されているか
        $response->assertSee($sellItem->item_name);

        //ユーザー名が表示されているか
        $response->assertSee($user->name);

        $response = $this->get('/mypage?tab=purchase');

        //購入した商品が表示されているか
        $response->assertSee($purchaseItem->item_name);
    }
}
