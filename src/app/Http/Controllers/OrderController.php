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

        $order = Order::create([
            'purchaser_id' => $userId,
            'payment_method' => $paymentMethod,
            'destination_post_number' => $destinationPostNumber,
            'destination_address' => $destinationAddress,
            'destination_building' => $destinationBuilding
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'item_id' => $itemId,
        ]);

        $items = Item::where('seller_id', '!=', $userId)->get();
        $param = '';
        return view('index', compact('items', 'param'));
    }

}
