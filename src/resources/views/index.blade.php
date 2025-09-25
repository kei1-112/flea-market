@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main__tabs">
    @if($param == 'mylist')
    <div class="main__tab"><a href="{{ route('search', ['item_name' => request('item_name')]) }}" class="tab__link--unselected">おすすめ</a></div>
    <div class="main__tab"><a href="{{ route('search', ['tab' => 'mylist', 'item_name' => request('item_name')]) }}" class="tab__link--selected">マイリスト</a></div>
    @else
    <div class="main__tab"><a href="{{ route('search', ['item_name' => request('item_name')]) }}" class="tab__link--selected">おすすめ</a></div>
    <div class="main__tab"><a href="{{ route('search', ['tab' => 'mylist', 'item_name' => request('item_name')]) }}" class="tab__link--unselected">マイリスト</a></div>
    @endif
</div>
<div class="main__horizon-line">
</div>
<div class="main__items">
    @if($items != null)
    @foreach($items as $item)
    <div class="main__item">
        <div class="main__item--img">
            <a href="/item:{{ $item->id}}">
                <img src="{{asset($item['item_img'])}}" alt="" class="img">
                @if($item['sold_flag'] == 1)
                    <div class="sold-overlay">Sold</div>
                @endif
            </a>
        </div>
        <a href="/item:{{ $item->id}}" class="main__item--name--link">
            <div class="main__item--name">{{$item['item_name']}}</div>
        </a>
    </div>
    @endforeach
    @endif
</div>
@endsection