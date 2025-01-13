<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement("ALTER TABLE payment_methods AUTO_INCREMENT = 1");


        // テーブルをトランケート（データ削除 & AUTO_INCREMENTリセット）
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //DB::table('payment_methods')->truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $param = [
            'name' => 'コンビニ払い',
        ];
        DB::table('payment_methods')->insert($param);
        $param = [
            'name' => 'カード支払い',
        ];
        DB::table('payment_methods')->insert($param);
    }
}
