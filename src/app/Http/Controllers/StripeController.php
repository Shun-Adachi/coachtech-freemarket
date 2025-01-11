<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout()
    {
        echo env('STRIPE_SECRET');
        echo config('services.stripe.secret');
        return view('checkout');
    }

    public function success()
    {
        return view('success');
    }

    public function cancel()
    {
        return view('cancel');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => 'Test Product',
                        ],
                        'unit_amount' => 1000, // 金額（例：1000円）
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/checkout-success'),
                'cancel_url' => url('/checkout-cancel'),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating Stripe Checkout session: ' . $e->getMessage());
        }
    }
}
