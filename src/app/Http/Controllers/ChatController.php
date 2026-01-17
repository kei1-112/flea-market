<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChatRequest;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Chat;

class ChatController extends Controller
{
    public function chat(Request $request ,$itemId){
        $editChatId =$request->input(['edit_chat_id']);

        $item = Item::where('id', $itemId)->first();
        $itemId = $item->id;
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $param = null;

        $evaluationFlag = $request->input(['evaluation_flag']);

        $clientId = null;
        $orderDetailId = OrderDetail::where('item_id', $itemId)
                                    ->value('order_id');

        $orderId = Order::where('id', $orderDetailId)
                            ->value('id');
        $order = Order::find($orderId);

                                    //商品の購入者か出品者か判定する
        if($item->seller_id == $userId){
            //出品者のとき
            $clientId = Order::where('id', $orderDetailId)
                                ->value('purchaser_id');
            $param = 0;
        }else{
            //購入者の時
            $clientId = $item->seller_id;
            $param = 1;
        }

        $client = User::where('id', $clientId)->first();

        $purchasingItemId = Item::join('order_details', 'items.id', '=', 'order_details.item_id')
                                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                                ->where('orders.purchaser_id', $userId)
                                ->where('orders.dealing_completed_flag_purchaser', 0)
                                ->pluck('items.id')
                                ->unique();
        $purchasingItems = Item::whereIn('id', $purchasingItemId)->get();

        $purchasingItemsChatSummary = Chat::join('orders', 'chats.order_id', '=', 'orders.id')
                                            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                            ->whereIn('order_details.item_id', $purchasingItems->pluck('id'))
                                            ->selectRaw('
                                                order_details.item_id,

                                                SUM(
                                                    CASE
                                                        WHEN chats.unread_flag = 0
                                                        AND chats.sender_flag = 0
                                                        THEN 1
                                                        ELSE 0
                                                    END
                                                ) as unread_count,

                                                MAX(chats.created_at) as last_received_time
                                            ')
                                            ->groupBy('order_details.item_id')
                                            ->get()
                                            ->keyBy('item_id');


        foreach ($purchasingItems as $purchasingItem) {
            $itemId = $purchasingItem->id;
            $purchasingItem->newMessageCount  = $purchasingItemsChatSummary[$itemId]->unread_count ?? 0;
            $purchasingItem->lastReceivedTime = $purchasingItemsChatSummary[$itemId]->last_received_time ?? null;
        }

        $sellingItemId = Item::join('order_details', 'items.id', '=', 'order_details.item_id')
                                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                                ->where('items.seller_id', $userId)
                                ->where('orders.dealing_completed_flag_seller', 0)
                                ->pluck('items.id')
                                ->unique();
        $sellingItems = Item::whereIn('id', $sellingItemId)->get();

        $sellingItemsChatSummary = Chat::join('orders', 'chats.order_id', '=', 'orders.id')
                                            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                            ->whereIn('order_details.item_id', $sellingItems->pluck('id'))
                                            ->selectRaw('
                                                order_details.item_id,

                                                SUM(
                                                    CASE
                                                        WHEN chats.unread_flag = 0
                                                        AND chats.sender_flag = 1
                                                        THEN 1
                                                        ELSE 0
                                                    END
                                                ) as unread_count,

                                                MAX(chats.created_at) as last_received_time
                                            ')
                                            ->groupBy('order_details.item_id')
                                            ->get()
                                            ->keyBy('item_id');


        $dealingItems = $sellingItems->merge($purchasingItems);

        $dealingItems = collect($dealingItems)
                        ->sortByDesc(function ($item) {
                            return $item->lastReceivedTime ?? '1970-01-01 00:00:00';
                        })
                        ->values();

        //チャット情報の取得
        $chats = Chat::where('order_id', $orderId)->get();

        //編集するチャットかを判定
        foreach($chats as $chat){
            if($chat->id != $editChatId){
                $chat['edit_flag'] = 0;
            }
            else{
                $chat['edit_flag'] = 1;
            }
        }

        //新規通知を既読にする
        if($param == 0){
            Chat::whereIn('id', $chats->pluck('id'))
                ->where('sender_flag', 1)
                ->where('unread_flag', 0)
                ->update(['unread_flag' => 1]);
        }else{
            Chat::whereIn('id', $chats->pluck('id'))
                ->where('sender_flag', 0)
                ->where('unread_flag', 0)
                ->update(['unread_flag' => 1]);
        }

        //購入者側の評価が終わっている時、出品者側の評価用のユーザーIDを渡す
        if($order['dealing_completed_flag_purchaser'] == 1){
            $userId = $order['purchaser_id'];
        }

        return view('chat', compact('item', 'user','client', 'dealingItems', 'orderId', 'userId', 'order', 'chats','evaluationFlag', 'param'));
    }

    public function store(ChatRequest $request){
        $itemId = $request->input('item_id');
        $chat = $request->only(['order_id', 'message']);

        $chat['img'] = null;

        $tmpFileName = $request->file('item_img');
        if($tmpFileName != null){
            $fileName = $tmpFileName->getClientOriginalName() . '_' . time();
            $request->file('item_img')->storeAs('public', $fileName);
            $chat['img'] = 'storage/' . $fileName;
        }

        $chat['sender_flag'] = $request->input('param');
        $chat['unread_flag'] = 0;

        Chat::create($chat);

        return redirect('/chat:' . $itemId);
    }

    public function update(Request $request){
        $editChatId = $request->input('edit_chat_id');
        $itemId = $request->input('item_id');
        $chat['message'] = $request->input('message');
        Chat::find($editChatId)->update($chat);
        return redirect('/chat:' . $itemId);
    }

    public function destroy(Request $request){
        $chatId = $request->input('chat_id');
        $itemId = $request->input('item_id');
        Chat::destroy($chatId);
        return redirect('/chat:' . $itemId);
    }
}
