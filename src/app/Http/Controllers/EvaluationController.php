<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluationReceivedMail;


class EvaluationController extends Controller
{
    public function store(Request $request){
        $orderId = $request->input('orderId');
        $order = Order::find($orderId);

        $evaluation['user_id'] = $request->input('userId'); //評価される側
        $evaluation['evaluation_user_id'] = Auth::id(); //評価する側
        $evaluation['evaluation'] = $request->input('evaluation');

        Evaluation::create($evaluation);

        if($order['dealing_completed_flag_purchaser'] == 0){
            $order->update([
                'dealing_completed_flag_purchaser' => 1
            ]);
            $targetUser = User::find($evaluation['user_id']);

            if($targetUser && $targetUser->email) {
                Mail::to($targetUser->email)
                    ->send(new EvaluationReceivedMail);
            }
        }else{
            $order->update([
                'dealing_completed_flag_seller' => 1
            ]);
        }

        return redirect('/');
    }
}
