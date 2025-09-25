@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__left">
        <div class="left__inner">
            <div class="item__description">
                <div class="item__img"><img src="{{asset($item['item_img'])}}" alt="" class="img"></div>
                <div class="item__name-price">
                    <div class="item__name">{{$item['item_name']}}</div>
                    <div class="item__price">¥{{number_format($item['price'])}}</div>
                </div>
            </div>
            <div class="horizon-line"></div>
            <div class="pay__way">
                支払い方法
            </div>
            <div class="pay__select-box">
                <select name="pay_select" id="payment_method">
                    <option value="" disabled selected>選択してください</option>
                    <option value="コンビニ支払い">コンビニ支払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>
            </div>
            <div class="error">
            @if($errors->has('pay_select'))
            {{$errors->first('pay_select')}}
            @endif
            </div>
            <div class="horizon-line"></div>
            <div class="address">
                <div class="address__title">配送先</div>
                <div class="address__change">
                <form action="/purchase/address" method="get">
                @csrf
                    <input type="hidden" value="{{ $item->id }}" name="item_id">
                    <button type="submit" class="address__change--link">変更する</button>
                </form>
                </div>
            </div>
            @if($updateAddress['destination_post_number'] == null)
            <div class="address__post-num">
                    〒{{$user['post_number']}}
            </div>
            <div class="address__detail">
                {{$user['address']}}
            </div>
            <div class="address__detail">
                {{$user['building']}}
            </div>
            @else
            <div class="address__post-num">
                    〒{{$updateAddress['destination_post_number']}}
            </div>
            <div class="address__detail">
                {{$updateAddress['destination_address']}}
            </div>
            <div class="address__detail">
                {{$updateAddress['destination_building']}}
            </div>
            @endif
            <div class="error">
            @if($errors->has('destination_post_number'))
            {{$errors->first('destination_post_number')}}
            @endif
            </div>
            <div class="error">
            @if($errors->has('destination_address'))
            {{$errors->first('destination_address')}}
            @endif
            </div>
            <div class="horizon-line"></div>
        </div>
    </div>
    <div class="main__right">
        <table class="table__payment">
            <tr class="table__row">
                <th class="table__header">商品代金</th>
                <td class="table__detail">¥{{number_format($item['price'])}}(税込)</td>
            </tr>
            <tr class="table__row">
                <th class="table__header">支払い方法</th>
                <td class="table__detail"><span id="payment_result"></span></td>
            </tr>
        </table>
        @if($item['seller_id'] == $user['id'])
        <form action="">
        @else
        <form action="/purchase" method="post" id="purchaseForm">
        @endif
            @csrf
            <input type="hidden" value="{{ $item->id }}" name="item_id">
            <input type="hidden" name="pay_select" id="pay_select_hidden">
            @if($updateAddress['destination_post_number'] == null)
            <input type="hidden" value="{{ $user['post_number'] }}" name="destination_post_number">
            <input type="hidden" value="{{ $user['address'] }}" name="destination_address">
            <input type="hidden" value="{{ $user['building'] }}" name="destination_building">
            @else
            <input type="hidden" value="{{ $updateAddress['destination_post_number'] }}" name="destination_post_number">
            <input type="hidden" value="{{ $updateAddress['destination_address'] }}" name="destination_address">
            <input type="hidden" value="{{ $updateAddress['destination_building'] }}" name="destination_building">
            @endif
        <div class="button__purchase">
            <button class="button__submit" type="submit">
                購入する
            </button>
        </div>
        </form>
    </div>
</div>
<script>
    const select = document.getElementById('payment_method');
    const result = document.getElementById('payment_result');
    const purchaseForm = document.getElementById('purchaseForm');
    const hidden = document.getElementById('pay_select_hidden');

    // 初期表示
    result.textContent = select.value;

    select.addEventListener('change', function () {
    result.textContent = this.value;
    });

    purchaseForm.addEventListener('submit', function() {
        hidden.value = select.value;
    });
</script>

@endsection