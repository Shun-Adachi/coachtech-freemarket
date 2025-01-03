<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\CategoryItem;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\SellRequest;

class ItemController extends Controller
{
    // 商品一覧ページ表示
    public function index(Request $request)
    {
        //ユーザー情報・タブ情報取得
        $user = Auth::user();
        $user_id = $user->id ?? null;
        $tab = $request->tab;

        //マイリスト
        if ($tab === 'mylist') {
            $favorite_item_ids = Favorite::where('user_id', $user_id)->pluck('item_id');
            $items = Item::whereIn('id', $favorite_item_ids)->get();
        }
        //商品一覧
        else {
            $items = Item::where('user_id', '!=', $user_id)->get();
        }

        return view('index', compact('items', 'tab'));
    }

    // 商品詳細ページ表示
    public function show(Request $request, $item_id)
    {
        //ユーザー情報取得
        $user = Auth::user();
        $user_id = $user->id ?? null;

        // 商品詳細取得
        $item = Item::with(['user', 'condition'])->where('id', $item_id)->first();

        // 円形式変換
        $price = '\\ ' . number_format($item->price);
        $item->price = $price;

        //お気に入り情報
        if ($user_id) {
            $my_favorite_count = Favorite::where('item_id', $item_id)->where('user_id', $user_id)->count();
        } else {
            $my_favorite_count = 0;
        }

        $favorites_count = Favorite::where('item_id', $item_id)->count();

        //コメント数取得
        $comments = Comment::with('user')->where('item_id', $item_id)->get();
        $comments_count = $comments->count();

        //関連カテゴリー取得
        $item_categories = CategoryItem::with('category')->where('item_id', $item_id)->get();

        return view('item', compact('item', 'my_favorite_count', 'favorites_count', 'comments', 'comments_count', 'item_categories'));
    }

    // お気に入り登録・解除処理
    public function favorite(Request $request, $item_id)
    {
        //お気に入り情報取得
        $user = Auth::user();
        $favorite = Favorite::where('item_id', $item_id)->where('user_id', $user->id)->first();

        //解除
        if ($favorite) {
            Favorite::find($favorite->id)->delete();
        }
        //登録
        else {
            $favorite = [
                'user_id' => $user->id,
                'item_id' => $item_id,
            ];
            Favorite::create($favorite);
        }

        return redirect()->back();
    }

    // コメント追加処理
    public function comment(CommentRequest $request)
    {
        $user = Auth::user();
        $comment = [
            'comment' => $request->comment,
            'user_id' => $user->id,
            'item_id' => $request->item_id,
        ];
        Comment::create($comment);

        return redirect()->back()->with('message', 'コメントを送信しました');
    }

    // 出品画面表示
    public function sell(Request $request)
    {
        $user = Auth::user();
        $categories = Category::get();
        $conditions = Condition::get();

        return view('sell', compact('user', 'categories', 'conditions'));
    }

    // 出品処理
    public function store(SellRequest $request)
    {
        $user = Auth::user();
        $path = $request->temp_image;

        // 一時保存された画像の利用
        $image_path = $request->file('image')
            ? $request->file('image')->store('images/items', 'public')
            : $this->moveTempImageToPermanentLocation($path); // 一時画像を移動

        // 商品データの保存
        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id,
            'condition_id' => $request->condition,
            'price' => $request->price,
            'image_path' => $image_path,
        ]);

        // 一時ファイルの削除
        if ($path && !$request->file('image')) {
            Storage::delete($path);
            session()->forget('temp_image');
        }

        return redirect('/mypage?tab=sell')->with('message', '商品を出品しました。');
    }

    //一時ファイルを正式な保存場所へ移動
    protected function moveTempImageToPermanentLocation($tempImagePath)
    {
        // 一時ファイルのパスが存在しない場合は null を返す
        if (!$tempImagePath || !Storage::disk('public')->exists($tempImagePath)) {
            return null;
        }

        // 移動先のパスを定義
        $newPath = 'images/items/' . basename($tempImagePath);

        // ファイルを新しい場所にコピー
        Storage::disk('public')->move($tempImagePath, $newPath);

        // 移動後に一時ファイルを削除（不要ならコメントアウト）
        Storage::disk('public')->delete($tempImagePath);

        return $newPath;
    }
}
