@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__left">
        <div class="left__inner">
            <div class="item__description">
                <div class="item__img">商品画像</div>
                <div class="item__name-price">
                    <div class="item__name">商品名</div>
                    <div class="item__price">¥47000</div>
                </div>
            </div>
            <div class="horizon-line"></div>
            <div class="pay__way">
                支払い方法
            </div>
            <div class="pay__select-box">
                <select name="pay__select" id="">
                    <option value="" disabled selected>選択してください</option>
                    <option value=0>コンビニ払い</option>
                    <option value=1>クレジットカード</option>
                </select>
            </div>
            <div class="horizon-line"></div>
            <div class="address">
                <div class="address__title">配送先</div>
                <div class="address__change">
                    <a href="" class="address__change--link">変更する</a>
                </div>
            </div>
            <div class="address__post-num">
                    〒XXX - YYYY
            </div>
            <div class="address__detail">
                ここには住所と建物が入ります
            </div>
            <div class="horizon-line"></div>
        </div>
    </div>
    <div class="main__right">
        <table class="table__payment">
            <tr class="table__row">
                <th class="table__header">商品代金</th>
                <td class="table__detail">¥47000</td>
            </tr>
            <tr class="table__row">
                <th class="table__header">支払い方法</th>
                <td class="table__detail">コンビニ払い</td>
            </tr>
        </table>
        <div class="button__purchase">
            <button class="button__submit" type="submit">
                購入する
            </button>
        </div>
    </div>
</div>

@endsection