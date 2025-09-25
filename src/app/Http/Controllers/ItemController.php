<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\MyList;
use App\Models\Comment;
use App\Models\User;
use App\Models\ItemCategory;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;

class ItemController extends Controller
{
    //トップページの呼び出し
    public function index(Request $request){
        $param = $request->tab;
        //ログインしていて商品一覧を表示するパターン
        if(Auth::check() && !$request->has('tab')){
            $userId = Auth::id();

            //ログインユーザーが出品している商品以外を取得
            $items = Item::where('seller_id', '!=', $userId)->get();
            return view('index', compact('items', 'param'));
        }

        //マイリストを表示するパターン
        if(Auth::check() && $request->has('tab')){
            $userId = Auth::id();
            $itemIds = MyList::where('user_id', $userId)->pluck('item_id');
            $items = Item::whereIn('id', $itemIds)->get();
            return view('index', compact('items', 'param'));
        }

        //ログインしておらず商品一覧を表示するパターン
        if(!Auth::check() && !$request->has('tab')){
            $items = Item::all();
            return view('index', compact('items', 'param'));
        }

        //ログインしていない状態でマイリストを選択したパターン
        if(!Auth::check() && $request->has('tab')){
            $items = null;
            return view('index', compact('items', 'param'));
        }
    }

    public function search(Request $request){
        $userId = Auth::id();
        $param = $request->input('tab', '');
        if($param != 'mylist'){
            $items = Item::where('item_name', 'LIKE', "%{$request->item_name}%")
                            ->where('seller_id', '!=', $userId)
                            ->get();
        }else{
            $itemIds = MyList::where('user_id', $userId)->pluck('item_id');
            $items = Item::where('item_name', 'LIKE', "%{$request->item_name}%")
                            ->where('seller_id', '!=', $userId)
                            ->whereIn('id', $itemIds)
                            ->get();
        }
        return view('index', compact('items', 'param'));
    }

    public function detail($itemId){
        $userId = Auth::id();
        $item = Item::where('id', $itemId)->first();
        $favNum = MyList::where('item_id', $itemId)->count();
        $comNum = Comment::where('item_id', $itemId)->count();
        $comments = Comment::with('sender')
                    ->where('item_id', $itemId)
                    ->orderBy('id')
                    ->get();
        $categoryIds = ItemCategory::where('item_id', $itemId)->pluck('category_id');
        $categories = Category::whereIn('id', $categoryIds)->get();
        $favFlag = MyList::where('user_id', $userId)
                            ->where('item_id', $itemId)
                            ->count();  //0:マイリストに登録なし 1:マイリストに登録済
        return view('detail', compact('item', 'favNum', 'comNum', 'comments', 'categories', 'userId', 'favFlag'));
    }

    public function purchase(AddressRequest $request){
        $userId = Auth::id();
        $itemId = $request->only('item_id');
        $updateAddress = [
            "destination_post_number"=>$request->input('post_number'),
            "destination_address"=>$request->input('address'),
            "destination_building"=>$request->input('building'),
        ];
        $user = User::where('id', $userId)->first();
        $item = Item::where('id', $itemId)->first();

        return view('purchase', compact('user', 'item', 'updateAddress'));
    }

    public function sell(){
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function storeSell(ExhibitionRequest $request){
        $item = $request->only([
            'item_name',
            'brand_name',
            'price',
            'item_description',
            'item_condition'
        ]);
        $filename = $request->file('item_img')->getClientOriginalName() . '_' . time();
        $request->file('item_img')->storeAs('public', $filename);
        $item['seller_id'] = Auth::id();
        $item['sold_flag'] = 0;
        $item['item_img'] = 'storage/' . $filename;

        $newItem = Item::create($item);

        $itemId = $newItem->id;

        $item_categories = $request->input(['item_categories']);

        foreach($item_categories as $categoryId){
            DB::table('item_categories')->insert([
                'item_id' => $itemId,
                'category_id' => $categoryId
            ]);
        }
        return redirect()->action(
            [UserController::class, 'showProfile']
        );
    }
}
