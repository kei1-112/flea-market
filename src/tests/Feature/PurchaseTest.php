<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 「購入する」ボタンを押下すると購入が完了する()
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
            ->post('/purchase', [
                'pay_select' => 'コンビニ支払い',
                'item_id' => $item->id,
                'destination_post_number' => '123-4567',
                'destination_address' => 'test',
                'destination_building' => 'test',
            ]);

        $this->assertDatabaseHas('orders', [
            'purchaser_id' => $user->id,
            'payment_method' => 'コンビニ支払い',
            'destination_post_number' => '123-4567',
            'destination_address' => 'test',
            'destination_building' => 'test',
        ]);

        $this->assertDatabaseHas('order_details', [
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 購入した商品は商品一覧画面にて「sold」と表示される()
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
            ->post('/purchase', [
                'pay_select' => 'コンビニ支払い',
                'item_id' => $item->id,
                'destination_post_number' => '123-4567',
                'destination_address' => 'test',
                'destination_building' => 'test',
            ]);

        // Blade内で「sold」と表示されているか確認
        $response->assertSee('sold');
    }

    /** @test */
    public function 「プロフィール／購入した商品一覧」に追加されている()
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
            ->post('/purchase', [
                'pay_select' => 'コンビニ支払い',
                'item_id' => $item->id,
                'destination_post_number' => '123-4567',
                'destination_address' => 'test',
                'destination_building' => 'test',
            ]);

        $response = $this->get('/mypage?tab=purchase');

        $response->assertSee($item->item_name);
    }
}
