@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="main__profile">
    @if($user->profile_img == null)
    <div class="profile__icon"></div>
    @else
    <div class="profile__icon"><img src="{{asset($user->profile_img)}}" alt="" class="icon-img"></div>
    @endif
    <div class="profile__name">{{ $user->name}}</div>
    <div class="profile__update">
        <a href="/mypage/profile" class="profile__update--link">プロフィールを編集</a>
    </div>
</div>
<div class="main__tabs">
    @if($param == 'purchase')
    <div class="main__tab"><a href="/mypage?tab=sell" class="tab__link--unselected">出品した商品</a></div>
    <div class="main__tab"><a href="/mypage?tab=purchase" class="tab__link--selected">購入した商品</a></div>
    @else
    <div class="main__tab"><a href="/mypage?tab=sell" class="tab__link--selected">出品した商品</a></div>
    <div class="main__tab"><a href="/mypage?tab=purchase" class="tab__link--unselected">購入した商品</a></div>
    @endif
</div>
<div class="main__horizon-line">
</div>
@if($param == 'purchase')
<div class="main__items">
    @if($purchaseItems != null)
    @foreach($purchaseItems as $item)
    <div class="main__item">
        <div class="main__item--img">
            <a href="/item:{{ $item->id}}">
                <img src="{{asset($item['item_img'])}}" alt="" class="img">
                @if($item['sold_flag'] == 1)
                    <div class="sold-overlay">Sold</div>
                @endif
            </a>
        </div>

        <div class="main__item--name">{{$item['item_name']}}</div>
    </div>
    @endforeach
    @endif
</div>
@else
<div class="main__items">
    @if($sellItems != null)
    @foreach($sellItems as $item)
    <div class="main__item">
        <div class="main__item--img">
            <img src="{{asset($item['item_img'])}}" alt="" class="img">
            @if($item['sold_flag'] == 1)
                <div class="sold-overlay">Sold</div>
            @endif
        </div>
        <div class="main__item--name">{{$item['item_name']}}</div>
    </div>
    @endforeach
    @endif
</div>
@endif
@endsection