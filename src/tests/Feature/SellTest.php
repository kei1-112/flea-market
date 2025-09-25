<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、商品の説明、販売価格）()
    {
        Storage::fake('public');

        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);
        User::factory(9)->create();

        $this->seed(\CategoryTableSeeder::class);

        $file = UploadedFile::fake()->create('item_test.png', 100, 'image/png');

        $categoryId = Category::inRandomOrder()->first()->id;

        $response = $this->actingAs($user)
            ->post('/sell', [
                'item_img' => $file,
                'item_categories' => [$categoryId],
                'item_condition' => '良好',
                'item_name' => 'test',
                'item_description' => 'test',
                'price' => 1000,
            ]);

        $this->assertDatabaseHas('items', [
            'seller_id' => $user->id,
            'item_condition' => '良好',
            'item_name' => 'test',
            'item_description' => 'test',
            'price' => 1000,
        ]);

        // 最新の item を取得
        $item = Item::latest()->first();
        $itemId = $item->id;

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'item_img' => $item->fresh()->item_img,
        ]);

        $this->assertDatabaseHas('item_categories', [
            'item_id' => $itemId,
            'category_id' => $categoryId,
        ]);
    }

}
