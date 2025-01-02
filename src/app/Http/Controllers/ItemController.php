<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\CategoryItem;

class ItemController extends Controller
{
    // 商品一覧ページ表示
    public function index(Request $request)
    {
        //マイリスト処理
        if ($request->tab) {
            var_dump($request->tab);
        }
        //表示
        $items = Item::with('condition')->get();
        return view('index', compact('items'));
    }

    // 商品詳細ページ表示
    public function show(Request $request, $item_id)
    {
        // 商品詳細取得
        $item = Item::with(['user', 'condition'])->where('id', $item_id)->first();

        // 円形式変換
        $formattedPrice = '\\ ' . number_format($item->price);
        $item->price = $formattedPrice;

        //お気に入り数取得
        $favorites_count = Favorite::where('item_id', $item_id)->count();

        //コメント数取得
        $comments = Comment::with('user')->where('id', $item_id)->get();
        $comments_count = $comments->count();
        echo $comments;
        echo $comments_count;
        //$comments_count = Comment::where('item_id', $item_id)->count();

        //関連カテゴリー取得
        $item_categories = CategoryItem::with('category')->where('item_id', $item_id)->get();

        //表示
        return view('item', compact('item', 'favorites_count', 'comments', 'comments_count', 'item_categories'));
    }
}
