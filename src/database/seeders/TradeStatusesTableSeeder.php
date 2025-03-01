<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TradeStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '取引中',
        ];
        DB::table('trade_statuses')->insert($param);
        $param = [
            'name' => '取引完了',
        ];
        DB::table('trade_statuses')->insert($param);
    }
}
