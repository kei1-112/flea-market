@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__left">
        <div class="left__item-img">商品画像</div>
    </div>
    <div class="main__right">
        <div class="right__item-description">
            <div class="right__item-description--name">商品名</div>
            <div class="right__item-description--bland">ブランド名</div>
            <div class="right__item-description--price">¥47000(税込)</div>
            <div class="right__item-action">
                <div class="right__item-action--fav">
                    <div class="fav__icon">⭐︎</div>
                    <div class="fav__num">3</div>
                </div>
                <div class="right__item-action--comment">
                    <div class="comment__icon"></div>
                    <div class="comment__num">1</div>
                </div>
            </div>
            <div class="right__button">
                <button class="button__submit" type="submit">
                    購入手続きへ
                </button>
            </div>
            <div class="right__item-description--description">商品説明</div>
            <div class="right__item-description--sentence">
                カラー:グレー
                <br>
                <br>
                新品
                <br>
                商品の状態は良好です。傷もありません。
                <br>
                <br>
                購入後、即発送いたします。
            </div>
            <div class="right__item-information">商品の情報</div>
            <div class="item__category">
                <div class="item__category__title">
                    カテゴリー
                </div>
                <div class="item__category__category">
                    洋服
                </div>
                <div class="item__category__category">
                    メンズ
                </div>
            </div>
            <div class="item__condition">
                <div class="item__condition__title">
                    商品の状態
                </div>
                <div class="item__condition__condition">
                    良好
                </div>
            </div>
            <div class="item__comment">コメント(1)</div>
            <div class="comment__sender">
                <div class="comment__sender--icon"></div>
                <div class="comment__sender--name">admin</div>
            </div>
            <div class="item__comment-sentence">
                こちらにコメントが入ります。
            </div>
            <div class="item__comment--send">
                商品へのコメント
            </div>
            <textarea name="" id="" class="comment__input"></textarea>
            <div class="right__button--buy">
                <button class="button__submit" type="submit">
                    コメントを送信する
                </button>
            </div>
        </div>
    </div>
</div>
@endsection