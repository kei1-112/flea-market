<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class OrderController extends Controller
{
    public function updateAddress(Request $request){
        $userId = Auth::id();
        $itemId = $request->input('item_id');
        return view('update_address', compact('userId', 'itemId'));
    }

    public function storePurchase(PurchaseRequest $request){
        $userId = Auth::id();
        $itemId = $request->input('item_id');
        $destinationPostNumber = $request->input('destination_post_number');
        $destinationAddress = $request->input('destination_address');
        $destinationBuilding = $request->input('destination_building');
        $paymentMethod = $request->input('pay_select');

        Item::where('id', $itemId)->update(['sold_flag' => 1]);

        $item = Item::where('id', $itemId)->first();

        $order = Order::create([
            'purchaser_id' => $userId,
            'payment_method' => $paymentMethod,
            'destination_post_number' => $destinationPostNumber,
            'destination_address' => $destinationAddress,
            'destination_building' => $destinationBuilding,
            'dealing_completed_flag_purchaser' => 0,
            'dealing_completed_flag_seller' => 0,
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'item_id' => $itemId,
        ]);

        // --- Stripe Checkout セッション作成 ---
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $item->price,
                    'product_data' => [
                        'name' => $item->item_name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('cancel'),
        ]);

        // --- Stripeの決済画面にリダイレクト ---
        return redirect($session->url);
    }

    public function success()
    {
        return '決済成功！';
    }

    public function cancel()
    {
        return 'キャンセルされました。';
    }
}
