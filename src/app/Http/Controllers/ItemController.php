<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){
        return view('index');
    }

    public function detail(){
        return view('detail');
    }

    public function purchase(){
        return view('purchase');
    }

    public function updateAddress(){
        return view('update_address');
    }

    public function sell(){
        return view('sell');
    }
}
