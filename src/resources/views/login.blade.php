@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="main__title">ログイン</div>
        <form class="main__forms">
        @csrf
            <div class="main__form">
                <div class="main__form--item">メールアドレス</div>
                <div class="main__form--input">
                    <input type="email" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">パスワード</div>
                <div class="main__form--input">
                    <input type="password" class="form__input">
                </div>
            </div>
            <button class="main__button" type="submit">ログインする</button>
        </form>
        <div class="main__link">
            <a href="/register" class="main__link--login">会員登録はこちら</a>
        </div>
@endsection