<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
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
            ->get('/purchase', [
                'post_number' => '123-4567',
                'address' => 'address_test',
                'building' => 'building_test',
                'item_id' => $item->id,
            ]);

        $response->assertSee('123-4567', 'address_test', 'building_test');
    }

    /** @test */
    public function 購入した商品に送付先住所が紐づいて登録される()
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
            ->get('/purchase', [
                'post_number' => '123-4567',
                'address' => 'address_test',
                'building' => 'building_test',
                'item_id' => $item->id,
            ]);

        $response->assertSee('123-4567');
        $response->assertSee('address_test');
        $response->assertSee('building_test');
    }
}
