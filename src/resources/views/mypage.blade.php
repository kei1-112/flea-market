@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="main__profile">
    <div class="profile__icon"></div>
    <div class="profile__name">ユーザー名</div>
    <div class="profile__update">
        <a href="" class="profile__update--link">プロフィールを編集</a>
    </div>
</div>
<div class="main__tab">
    <div class="main__tab--sell">出品した商品</div>
    <div class="main__tab--buy">購入した商品</div>
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