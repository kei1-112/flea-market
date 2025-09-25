<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\MyList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase

{
    use RefreshDatabase;

    /** @test */
public function 商品名で部分一致検索できる()
{
        User::factory(10)->create();

        $this->seed(\ItemTableSeeder::class);

        $items = Item::all();

        // 適当な商品名を取得
        $targetItem = $items->random();
        $keyword = mb_substr($targetItem->item_name, 0, 2); // 部分一致用に先頭3文字

        // 検索リクエスト
        $response = $this->get('/search?item_name=' . $keyword);

        $response->assertStatus(200);
        // 検索キーワードを含む商品が表示される
        $response->assertSee($targetItem->item_name);

        // 検索キーワードに一致しない商品は表示されない
        $otherItem = $items->where('id', '!=', $targetItem->id)->first();
        $response->assertDontSee($otherItem->item_name);
}

/** @test */
public function 検索状態がマイリストでも保持される()
{
    $user = User::factory()->create();
    User::factory(9)->create();
    $this->actingAs($user);

    $userId = $user->id;

    $this->seed(\ItemTableSeeder::class);

    $items = Item::all();

    $availableItems = $items->where('seller_id', '!=', $userId);

    $targetItem = $availableItems->random();
    $keyword = mb_substr($targetItem->item_name, 0, 2);

    // 検索して MyList に登録
    MyList::create([
        'user_id' => $user->id,
        'item_id' => $targetItem->id,
    ]);

    // 検索状態でマイリストページにアクセス
    $response = $this->get('/search?tab=mylist&item_name=' . $keyword);

    $response->assertStatus(200);
    $response->assertSee($targetItem->item_name);

    // キーワードに一致しない商品は表示されない
    $otherItem = $items->where('id', '!=', $targetItem->id)->first();
    $response->assertDontSee($otherItem->item_name);
}
}
