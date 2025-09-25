<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Category;
use App\Models\MyList;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetailTest extends TestCase
{
    use RefreshDatabase;

        /** @test */

    public function 必要な情報が表示される()
    {
        // ユーザー作成
        User::factory(10)->create();

        $users = User::all();
        $user = $users->random();

        //商品作成
        $this->seed(\ItemTableSeeder::class);
        $items = Item::all();
        $item = $items->random();

        //ブランド名を設定
        $item->update(['brand_name' => 'test']);

        //いいね数を1にする
        MyList::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        //コメントをつける
        $comment = Comment::create([
            'item_id' => $item->id,
            'sender_id' => $user->id,
            'content' => 'test',
        ]);

        //カテゴリの作成、設定
        $this->seed(\CategoryTableSeeder::class);

        $categories = Category::all();

        $category = $categories->random();
        ItemCategory::create([
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);

        //いいね数とコメント数のカウント
        $likesCount = $item->mylists()->count();
        $commentsCount = $item->comments()->count();

        $response = $this->get('/item:' . $item->id);

        // 各情報が表示されているか確認
        $response->assertStatus(200);
        $response->assertSee($item->item_name);
        $response->assertSee($item->brand_name);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->item_description);
        $response->assertSee($item->item_condition);
        $response->assertSee($category->name);
        $response->assertSee((string) $likesCount);
        $response->assertSee((string) $commentsCount);

        // コメント部分
        $response->assertSee($user->name);
        $response->assertSee($comment->content);

        // 画像が表示されているか（imgタグごと確認）
        $response->assertSee('<img src="' . asset($item->item_img) . '"', false);
    }

    use RefreshDatabase;

        /** @test */

    public function 複数選択したカテゴリが表示されているか()
    {
        // ユーザー作成
        User::factory(10)->create();
        
        //商品作成
        $this->seed(\ItemTableSeeder::class);
        $items = Item::all();
        $item = $items->random();

        //カテゴリの作成、設定
        $this->seed(\CategoryTableSeeder::class);

        $categories = Category::all();

        $category1 = $categories->random();
        $category2 = $categories->where('id', '!=', $category1->id)->random();
        ItemCategory::create([
            'item_id' => $item->id,
            'category_id' => $category1->id,
        ]);

        ItemCategory::create([
            'item_id' => $item->id,
            'category_id' => $category2->id,
        ]);

        $response = $this->get('/item:' . $item->id);

        // カテゴリが複数表示されているか確認
        $response->assertStatus(200);
        $response->assertSee($category1->name);
        $response->assertSee($category2->name);
    }
}
