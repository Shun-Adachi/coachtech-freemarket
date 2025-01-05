<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\EditAddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{

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
        $shipping_address = [
            'item_id' => $request->item_id,
            'payment_method' => $request->payment_method,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ];
        return view('edit-address', compact('shipping_address'));
    }

    // 配送先住所を変更処理
    public function update(EditAddressRequest $request)
    {
        $shipping_address = [
            'item_id' => $request->item_id,
            'payment_method' => $request->payment_method,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        //
        session()->put('shipping_address', $shipping_address);
        session()->put('update_address_message', '配送先が変更されています');
        return redirect()->route('purchase', ['item_id' => $request->item_id]);
    }

    // 購入処理
    public function buy(PurchaseRequest $request)
    {
        $user = Auth::user();

        // 商品データの保存
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $request->item_id,
            'payment_method_id' => $request->payment_method,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        session()->forget('shipping_address');
        session()->forget('update_address_message');

        return redirect('/mypage')->with('message', '商品を購入しました');
    }
}
