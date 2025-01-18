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
        $userId = $user->id ?? null;
        $tab = $request->tab;

        //出品した商品
        if ($tab === 'sell') {
            $items = Item::where('user_id', $userId)->get();
        }
        //購入した商品
        else {
            $purchaseItemIds = Purchase::where('user_id', $userId)->pluck('item_id');
            $items = Item::whereIn('id', $purchaseItemIds)->get();
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
        $tempImage = $request->temp_image;

        // 更新前データ
        $currentUserData  = [
            'name' => $user->name,
            'current_post_code' => $user->current_post_code,
            'current_address' => $user->current_address,
            'current_building' => $user->current_building,
            'thumbnail_path' => $user->thumbnail_path,
        ];

        // 画像選択あり
        if ($request->hasFile('image')) {
            // 古い画像を削除
            $this->deleteThumbnail($user->thumbnail_path);
            // ファイルを保存し、パスを取得
            $thumbnailPath = $request->file('image')->store('images/users/', 'public');
        }
        // 画像選択なし、一時ファイルあり
        elseif ($tempImage) {
            // 古い画像を削除
            $this->deleteThumbnail($user->thumbnail_path);
            // 一時ファイルを移動し、パスを取得
            $thumbnailPath = moveTempImageToPermanentLocation($tempImage, 'images/users/');
        }
        // 画像選択なし、一時ファイルなし
        else {
            $thumbnailPath = $user->thumbnail_path;
        }

        // 更新データ
        $updateData = [
            'name' => $request->input(['name']),
            'current_post_code' => $request->input(['current_post_code']),
            'current_address' => $request->input(['current_address']),
            'current_building' => $request->input(['current_building']),
            'thumbnail_path' => $thumbnailPath,
        ];

        // 変更なしの場合は更新処理およびメッセージなし
        if ($currentUserData == $updateData) {
            return redirect('/mypage/profile');
        }

        //初回ログイン時は現住所と送付先を同時に変更
        if (!$user->current_post_code && !$user->current_address && !$user->current_building) {
            $shippingData = [
                'shipping_post_code' => $request->input(['current_post_code']),
                'shipping_address' => $request->input(['current_address']),
                'shipping_building' => $request->input(['current_building']),
            ];
            $updateData = array_merge($updateData, $shippingData);
        }

        User::where('id', $request->id)->update($updateData);
        return redirect('/')->with('message', 'プロフィールが更新されました');
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('message', 'ログアウトしました');
    }

    //ユーザープロフィール画像削除
    public function deleteThumbnail($thumbnailPath)
    {
        $dummyDataDirectory = 'default/users/';
        if ($thumbnailPath && !str_starts_with($thumbnailPath, $dummyDataDirectory)) {
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
        }
    }
}
