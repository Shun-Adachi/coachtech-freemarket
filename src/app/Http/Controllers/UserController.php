<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class UserController extends Controller
{
    // プロフィール画面表示
    public function index(Request $request)
    {
        //ユーザー情報・タブ情報取得
        $user = Auth::user();
        $user_id = $user->id ?? null;
        $tab = $request->tab;

        //出品した商品
        if ($tab === 'sell') {
            $items = Item::where('user_id', $user_id)->get();
        }
        //購入した商品
        else {
            $purchase_item_ids = Purchase::where('user_id', $user_id)->pluck('item_id');
            $items = Item::whereIn('id', $purchase_item_ids)->get();
        }

        return view('mypage', compact('user', 'items', 'tab'));
    }

    // プロフィール編集ページ表示
    public function edit(Request $request)
    {
        //表示
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    // プロフィール更新
    public function update(UserRequest $request)
    {
        $user = auth()->user();
        $temp_image = $request->temp_image;

        //画像選択あり
        if ($request->hasFile('image')) {
            // 古い画像を削除
            $this->deleteThumbnail($user->thumbnail_path);
            // ファイルを保存し、パスを取得
            $thumbnail_path = $request->file('image')->store('images/users/', 'public');
        }
        //画像選択なし、一時ファイルあり
        elseif ($temp_image) {
            // 古い画像を削除
            $this->deleteThumbnail($user->thumbnail_path);
            // 一時ファイルを移動し、パスを取得
            $thumbnail_path = moveTempImageToPermanentLocation($temp_image, 'images/users/');
        }
        //画像選択なし、一時ファイルなし
        else {
            $thumbnail_path = $user->thumbnail_path;
        }
        //更新処理
        $update_data = [
            'name' => $request->input(['name']),
            'post_code' => $request->input(['post_code']),
            'address' => $request->input(['address']),
            'building' => $request->input(['building']),
            'thumbnail_path' => $thumbnail_path,
        ];
        User::find($request->id)->update($update_data);

        return redirect('/mypage')->with('message', 'プロフィールが更新されました');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('message', 'ログアウトしました');
    }

    //ユーザープロフィール画像削除
    public function deleteThumbnail($thumbnailPath)
    {
        if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }
    }
}
