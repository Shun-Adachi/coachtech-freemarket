<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\CategoryItem;
use App\Models\Category;
use App\Models\Condition;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\SellRequest;
use App\Http\Requests\EditAddressRequest;
use App\Http\Requests\PurchaseRequest;

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
            $purchases = Purchase::where('user_id', $user_id)->get();
        }

        $sold_item_ids = Purchase::pluck('item_id')->toArray();

        return view('index', compact('items', 'tab', 'sold_item_ids'));
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
        $item->price = '\\ ' . number_format($item->price);

        //お気に入り情報取得
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

        // 一時保存された画像の利用
        $image_path = $request->file('image')
            ? $request->file('image')->store('images/items', 'public')
            : moveTempImageToPermanentLocation($request->temp_image, 'images/items/');

        // 商品データの保存
        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id,
            'condition_id' => $request->condition,
            'price' => $request->price,
            'image_path' => $image_path,
        ]);

        // カテゴリと商品の関連を保存
        foreach ($request->categories as $category_id) {
            CategoryItem::create([
                'item_id' => $item->id,
                'category_id' => $category_id,
            ]);
        }

        return redirect('/mypage?tab=sell')->with('message', '商品を出品しました。');
    }

    // 購入画面表示
    public function purchase(Request $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::where('id', $item_id)->first();
        $payment_methods = PaymentMethod::get();

        // 円形式変換
        $item->price = '\\ ' . number_format($item->price);

        return view('purchase', compact('user', 'item', 'payment_methods'));
    }

    // 配送先住所変更画面表示
    public function edit(Request $request)
    {
        $post_code = substr($request->post_code, -8);
        $shipping_address = [
            'item_id' => $request->item_id,
            'post_code' => $post_code,
            'address' => $request->address,
            'building' => $request->building,
        ];
        return view('edit-address', compact('shipping_address'));
    }

    // 配送先住所を変更し、購入画面を表示
    public function update(EditAddressRequest $request)
    {
        $user = Auth::user();
        $item = Item::where('id', $request->item_id)->first();
        $payment_methods = PaymentMethod::get();

        // 円形式変換
        $item->price = '\\ ' . number_format($item->price);

        // 配送先住所変更
        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building = $request->building;

        // 変更メッセージ
        session()->flash('update-address-message', '住所が変更されています');

        return view('purchase', compact('user', 'item', 'payment_methods'));
    }

    // 購入処理
    public function buy(PurchaseRequest $request)
    {
        $user = Auth::user();
        $post_code = substr($request->post_code, -8);

        // 商品データの保存
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $request->item_id,
            'payment_method_id' => $request->payment_method,
            'post_code' => $post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/mypage')->with('message', '商品を購入しました。');
    }
}
