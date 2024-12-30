<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'price' => '15000',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition_id' => '1',
            'image_path' => '/images/Armani+Mens+Clock.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'HDD',
            'price' => '5000',
            'description' => '高速で信頼性の高いハードディスク',
            'condition_id' => '2',
            'image_path' => '/images/HDD+Hard+Disk.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '玉ねぎ3束',
            'price' => '300',
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition_id' => '3',
            'image_path' => '/images/iLoveIMG+d.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '革靴',
            'price' => '4000',
            'description' => 'クラシックなデザインの革靴',
            'condition_id' => '4',
            'image_path' => '/images/Leather+Shoes+Product+Photo.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ノートPC',
            'price' => '45000',
            'description' => '高性能なノートパソコン',
            'condition_id' => '1',
            'image_path' => '/images/Living+Room+Laptop.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'マイク',
            'price' => '8000',
            'description' => '高音質のレコーディング用マイク',
            'condition_id' => '2',
            'image_path' => '/images/Music+Mic+4632231.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'description' => 'おしゃれなショルダーバッグ',
            'condition_id' => '3',
            'image_path' => '/images/Purse+fashion+pocket.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'タンブラー',
            'price' => '500',
            'description' => '使いやすいタンブラー',
            'condition_id' => '4',
            'image_path' => '/images/Tumbler+souvenir.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'コーヒーミル',
            'price' => '4000',
            'description' => '手動のコーヒーミル',
            'condition_id' => '1',
            'image_path' => '/images/Waitress+with+Coffee+Grinder.jpg',
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'メイクセット',
            'price' => '2500',
            'description' => '便利なメイクアップセット',
            'condition_id' => '2',
            'image_path' => '/images/外出メイクアップセット.jpg',
        ];
        DB::table('items')->insert($param);
    }
}
