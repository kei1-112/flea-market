@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/update_address.css') }}">
@endsection

@section('content')
<div class="main__title">住所の変更</div>
        <form class="main__forms" action="/purchase" method="get">
        @csrf
        <input type="hidden" value="{{ $itemId }}" name="item_id">
            <div class="main__form">
                <div class="main__form--item">郵便番号</div>
                <div class="main__form--input">
                    <input type="text" class="form__input" name="post_number" value="{{ old('post_number') }}">
                </div>
            </div>
            <div class="error">
            @if($errors->has('post_number'))
            {{$errors->first('post_number')}}
            @endif
            </div>
            <div class="main__form">
                <div class="main__form--item">住所</div>
                <div class="main__form--input">
                    <input type="text" class="form__input" name="address" value="{{ old('address') }}">
                </div>
            </div>
            <div class="error">
            @if($errors->has('address'))
            {{$errors->first('address')}}
            @endif
            </div>
            <div class="main__form">
                <div class="main__form--item">建物名</div>
                <div class="main__form--input">
                    <input type="text" class="form__input" name="building" value="{{ old('building') }}">
                </div>
            </div>
            <button class="main__button" type="submit">更新する</button>
        </form>
@endsection