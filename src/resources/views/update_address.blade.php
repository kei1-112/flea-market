@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/update_address.css') }}">
@endsection

@section('content')
<div class="main__title">住所の変更</div>
        <form class="main__forms">
        @csrf
            <div class="main__form">
                <div class="main__form--item">郵便番号</div>
                <div class="main__form--input">
                    <input type="text" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">住所</div>
                <div class="main__form--input">
                    <input type="email" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">建物名</div>
                <div class="main__form--input">
                    <input type="password" class="form__input">
                </div>
            </div>
            <button class="main__button" type="submit">更新する</button>
        </form>
@endsection