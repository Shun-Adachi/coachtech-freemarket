<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {

        static $combinations = [];

        do {
            // 商品をランダムに取得
            $item = item::inRandomOrder()->first();

            // 出品者以外のユーザーをランダムに取得
            $user = User::where('id', '!=', $item->user_id)->inRandomOrder()->first();
        } while (in_array([$user->id, $item->id], $combinations));

        $combinations[] = [$user->id, $item->id];

        return [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ];
    }
}
