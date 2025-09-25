<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyList;

class MyListController extends Controller
{
    //
    public function store(Request $request){
        $id = $request->except('_token');
        MyList::create($id);
        return redirect('/item:' . $id['item_id']);
    }

    public function destroy(Request $request){
        $id = $request->except('_token');
        MyList::where('user_id', $request->user_id)
                ->where('item_id', $request->item_id)
                ->delete();
        return redirect('/item:' . $id['item_id']);
    }
}
