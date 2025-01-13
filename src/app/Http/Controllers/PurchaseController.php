<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Http\Requests\EditAddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    protected $stripeClient;

    public function __construct(StripeClient $stripeClient)
    {
        $this->stripeClient = $stripeClient;
    }

    // 購入画面表示
    public function purchase(Request $request, $item_id)
    {
        $item = Item::where('id', $item_id)->first();
        $user = User::findOrFail(Auth::id());
        $payment_methods = PaymentMethod::get();
        $purchase =  Purchase::where('item_id', $item_id)->exists();

        // 円形式変換
        $item->price = '\\ ' . number_format($item->price);

        return view('purchase', compact('user', 'item', 'payment_methods', 'purchase'));
    }

    // 配送先住所変更画面表示
    public function edit(Request $request)
    {
        $user = auth()->user();
        $item_id = $request->item_id;

        // 支払方法の更新(POST時のみ)
        if ($request->payment_method) {
            User::where('id', $user->id)->update(['payment_method_id' => $request->payment_method]);
            $user->payment_method_id = $request->payment_method;
        }

        return view('edit-address', compact('user', 'item_id'));
    }

    // 配送先住所を変更処理
    public function update(EditAddressRequest $request)
    {
        $user = auth()->user();
        $currentUserData  = [
            'shipping_post_code' => $user->shipping_post_code,
            'shipping_address' => $user->shipping_address,
            'shipping_building' => $user->shipping_building,
        ];

        $updateData  = [
            'shipping_post_code' => $request->shipping_post_code,
            'shipping_address' => $request->shipping_address,
            'shipping_building' => $request->shipping_building,
        ];

        //変更なしの場合は更新処理およびメッセージなし
        if ($currentUserData == $updateData) {
            return redirect()->route('purchase', ['item_id' => $request->item_id]);
        }

        User::where('id', $user->id)->update($updateData);
        return redirect()->route('purchase', ['item_id' => $request->item_id])->with('message', '配送先住所を変更しました');
    }

    // 購入処理
    public function buy()
    {
        $user = auth()->user();
        $requestData = session('request_data', []);
        $user = Auth::user();
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $requestData['item_id'],
            'payment_method_id' => $requestData['payment_method'],
            'shipping_post_code' => $requestData['shipping_post_code'],
            'shipping_address' => $requestData['shipping_address'],
            'shipping_building' => $requestData['shipping_building'],
        ]);

        return redirect('/mypage')->with('message', '商品を購入しました');
    }

    // Stripeセッション
    public function createCheckoutSession(PurchaseRequest $request)
    {
        $user = auth()->user();
        $item = Item::where('id', $request->item_id)->first();

        //Stripe::setApiKey(config('services.stripe.secret'));
        try {

            Log::info('Session URL1:');
            $session = $this->stripeClient->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' =>  $user->email,
                'success_url' => url('/purchase/buy'),
                'cancel_url' => url('/purchase/' . $request->item_id),
            ]);

            session()->put('request_data', $request->all());

            Log::info('Session URL2:', ['url' => $session->url]);
            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'チェックアウトセッションの生成に失敗しました ' . $e->getMessage());
        }
    }
}
