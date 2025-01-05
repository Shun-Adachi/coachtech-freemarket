<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '管理者',
            'email' => 'root@root',
            'password' => Hash::make('rootroot'),
            'post_code' => '000-0000',
            'address' => '東京都',
            'building' => '',
            'email' => 'root@root',
            'thumbnail_path' => '/default/users/admin.jpg'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'テスト五郎',
            'email' => 'test@test',
            'password' => Hash::make('testtest'),
            'post_code' => '001-0001',
            'address' => '愛知県',
            'building' => 'テストビル',
            'thumbnail_path' => '/default/users/testgoro.jpg'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'hoge',
            'email' => 'hoge@hoge',
            'password' => Hash::make('hogehoge'),
            'post_code' => '111-1111',
            'address' => '大阪府',
            'building' => 'サンプル101',
            'thumbnail_path' => NULL
        ];
        DB::table('users')->insert($param);
    }
}
