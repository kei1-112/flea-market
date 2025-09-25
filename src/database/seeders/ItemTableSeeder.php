<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database see
     * ds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Armani+Mens+Clock.jpg',
            'item_name' => '腕時計',
            'brand_name' => 'test',
            'price' => 15000,
            'item_description' => 'スタイリッシュなデザインのメンズ腕時計',
            'item_condition' => '良好'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/HDD+Hard+Disk.jpg',
            'item_name' => 'HDD',
            'brand_name' => 'test',
            'price' => 5000,
            'item_description' => '高速で信頼性の高いハードディスク',
            'item_condition' => '目立った傷や汚れあり'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/iLoveIMG+d.jpg',
            'item_name' => '玉ねぎ3束',
            'brand_name' => 'test',
            'price' => 300,
            'item_description' => '新鮮な玉ねぎの3束セット',
            'item_condition' => 'やや傷や汚れあり'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Leather+Shoes+Product+Photo.jpg',
            'item_name' => '革靴',
            'brand_name' => 'test',
            'price' => 4000,
            'item_description' => 'クラシックなデザインの革靴',
            'item_condition' => '状態が悪い'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Living+Room+Laptop.jpg',
            'item_name' => 'ノートPC',
            'brand_name' => 'test',
            'price' => 45000,
            'item_description' => '高性能なノートパソコン',
            'item_condition' => '良好'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Music+Mic+4632231.jpg',
            'item_name' => 'マイク',
            'brand_name' => 'test',
            'price' => 8000,
            'item_description' => '高音質のレコーディング用マイク',
            'item_condition' => '目立った傷や汚れなし'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Purse+fashion+pocket.jpg',
            'item_name' => 'ショルダーバッグ',
            'brand_name' => 'test',
            'price' => 5000,
            'item_description' => 'おしゃれなショルダーバッグ',
            'item_condition' => '目立った傷や汚れあり'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Tumbler+souvenir.jpg',
            'item_name' => 'タンブラー',
            'brand_name' => 'test',
            'price' =>500 ,
            'item_description' => '使いやすいタンブラー',
            'item_condition' => '状態が悪い'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/Waitress+with+Coffee+Grinder.jpg',
            'item_name' => 'コーヒーミル',
            'brand_name' => 'test',
            'price' => 4000,
            'item_description' => '手動のコーヒーミル',
            'item_condition' => '良好'
        ];
        DB::table('items')->insert($param);
        $param = [
            'sold_flag' => 0,
            'seller_id' =>$users->random()->id,
            'item_img' => 'storage/MakeUpSet.jpg',
            'item_name' => 'メイクセット',
            'brand_name' => 'test',
            'price' => 2500,
            'item_description' => '便利なメイクアップセット',
            'item_condition' => '目立った傷や汚れなし'
        ];
        DB::table('items')->insert($param);
    }
}
