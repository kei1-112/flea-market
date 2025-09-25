<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Item;

class UserController extends Controller
{
    public function showProfile(Request $request){
        $param = $request->tab;
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $sellItems = Item::where('seller_id', $userId)->get();
        $purchaseItems = Item::whereHas('order_details.orders', function($query) use ($userId){
            $query->where('purchaser_id', $userId);
        })->get();
        return view('mypage', compact('user', 'sellItems', 'purchaseItems', 'param'));
    }

    public function setProfile(){
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        return view('set_profile', compact('user'));
    }

    public function update(AddressRequest $request){
        $userId = Auth::id();
        $user = $request->all();
        unset($user['_token']);
        if($request->hasFile('profile_img')){
            $filename = $request->file('profile_img')->getClientOriginalName() . '_' . time();
            $request->file('profile_img')->storeAs('public', $filename);
            $user['profile_img'] = 'storage/' . $filename;
        }
        User::find($userId)->update($user);
        return redirect()->action([ItemController::class, 'index']);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (! Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'メール認証を完了してください。',
                ])->withInput();
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
        ])->withInput();
    }
}
