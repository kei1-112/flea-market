@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main__tab">
    <div class="main__tab--recommend">おすすめ</div>
    <div class="main__tab--my-list">マイリスト</div>
</div>
<div class="main__horizon-line">
</div>
<div class="main__items">
    <div class="main__item">
        <div class="main__item--img">商品画像</div>
        <div class="main__item--name">名前</div>
    </div>
    <div class="main__item">
        <div class="main__item--img">商品画像</div>
        <div class="main__item--name">名前</div>
    </div>
    <div class="main__item">
        <div class="main__item--img">商品画像</div>
        <div class="main__item--name">名前</div>
    </div>
    <div class="main__item">
        <div class="main__item--img">商品画像</div>
        <div class="main__item--name">名前</div>
    </div>
</div>
@endsection