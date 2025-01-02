<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    // プロフィール編集ページ表示
    public function edit(Request $request)
    {
        //表示
        $user = Auth::user();
        //$user->post_code = $this->addHyphenToPostalCode($user->post_code);
        return view('edit-profile', compact('user'));
    }

    // プロフィール更新
    public function update(UserRequest $request)
    {
        //画像更新処理
        $user = auth()->user();
        //画像選択あり
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($user->thumbnail_path && Storage::disk('public')->exists($user->thumbnail_path)) {

                Storage::disk('public')->delete($user->thumbnail_path);
            }
            // ファイルを保存し、パスを取得
            $thumbnail_path = $request->file('image')->store('images', 'public');
        }
        //画像選択なし
        else {
            $thumbnail_path = $user->thumbnail_path;
        }
        //郵便番号ハイフン削除
        $post_code = $this->removeHyphenToPostalCode($request->post_code);
        //更新処理
        $update_data = [
            'name' => $request->input(['name']),
            'post_code' => $request->input(['post_code']),
            'address' => $request->input(['address']),
            'building' => $request->input(['building']),
            'thumbnail_path' => $thumbnail_path,
        ];
        User::find($request->id)->update($update_data);

        return redirect('/')->with('message', 'プロフィールが更新されました');
    }

    // 郵便番号ハイフン削除
    protected function removeHyphenToPostalCode($postalCode)
    {
        $postalCodeWithoutHyphen = str_replace('-', '', $postalCode);
        return (int) $postalCodeWithoutHyphen;
    }

    // 郵便番号ハイフン追加
    protected function addHyphenToPostalCode($postalCode)
    {
        // 郵便番号が7桁であることを確認
        if (preg_match('/^\d{7}$/', $postalCode)) {
            // 3桁目と4桁目の間にハイフンを追加
            return substr($postalCode, 0, 3) . '-' . substr($postalCode, 3);
        }
        // 入力が不正な場合はそのまま返す
        return $postalCode;
    }
}
