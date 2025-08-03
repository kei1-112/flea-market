@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/set_profile.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__title">プロフィール設定</div>
    <div class="icon">
        <div class="icon__img"></div>
        <div class="icon__choice">画像を選択する</div>
    </div>
    <form class="main__forms">
        @csrf
            <div class="main__form">
                <div class="main__form--item">ユーザー名</div>
                <div class="main__form--input">
                    <input type="text" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">郵便番号</div>
                <div class="main__form--input">
                    <input type="text" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">住所</div>
                <div class="main__form--input">
                    <input type="text" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">建物名</div>
                <div class="main__form--input">
                    <input type="text" class="form__input">
                </div>
            </div>
            <button class="main__button" type="submit">更新する</button>
        </form>
</div>
@endsection