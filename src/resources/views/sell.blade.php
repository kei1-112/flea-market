@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__title">商品の出品</div>
    <div class="sub__title">商品の画像</div>
    <div class="img__add-space">
        <div class="img__choice">画像を選択する</div>
    </div>
    <div class="item__detail">商品の詳細</div>
    <div class="horizon-line"></div>
    <div class="sub__title">カテゴリー</div>
    <div class="categories">
        <div class="categories__row">
            <div class="category">ファッション</div>
            <div class="category">家電</div>
            <div class="category">インテリア</div>
            <div class="category">レディース</div>
            <div class="category">メンズ</div>
            <div class="category">コスメ</div>
        </div>
        <div class="categories__row">
            <div class="category">本</div>
            <div class="category">ゲーム</div>
            <div class="category">スポーツ</div>
            <div class="category">キッチン</div>
            <div class="category">ハンドメイド</div>
            <div class="category">アクセサリー</div>
        </div>
        <div class="categories__row">
            <div class="category">おもちゃ</div>
            <div class="category__baby-kids">ベビー・キッズ</div>
        </div>
    </div>
    <div class="sub__title">商品の状態</div>
    <div class="form">
        <select class="form__select" name="item-condition">
            <option value="" disabled selected>選択してください</option>
            <option value=0>良好</option>
            <option value=1>普通</option>
            <option value=2>悪い</option>
        </select>
    </div>
    <div class="sub__title">商品の状態</div>
    <div class="form">
        <input type="text" class="form__input">
    </div>
    <div class="sub__title">ブランド名</div>
    <div class="form">
        <input type="text" class="form__input">
    </div>
    <div class="sub__title">商品の説明</div>
    <div class="form">
        <textarea name="" id="" class="form__textarea"></textarea>
    </div>
    <div class="sub__title">販売価格</div>
    <div class="form">
        <input type="text" class="form__input" placeholder="¥">
    </div>
    <div class="button__purchase">
        <button class="button__submit" type="submit">
            出品する
        </button>
    </div>
</div>
@endsection