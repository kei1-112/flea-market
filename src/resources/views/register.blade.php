@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="main__title">会員登録</div>
        @if($errors->any())
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
        @endif
        <form class="main__forms" action="register" method="post">
        @csrf
            <div class="main__form">
                <div class="main__form--item">ユーザー名</div>
                <div class="main__form--input">
                    <input type="text" name="name" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">メールアドレス</div>
                <div class="main__form--input">
                    <input type="email" name="email" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">パスワード</div>
                <div class="main__form--input">
                    <input type="password" name="password" class="form__input">
                </div>
            </div>
            <div class="main__form">
                <div class="main__form--item">確認用パスワード</div>
                <div class="main__form--input">
                    <input type="password" name="password_confirmation" class="form__input">
                </div>
            </div>
            <button class="main__button" type="submit">登録する</button>
        </form>
        <div class="main__link">
            <a href="/login" class="main__link--login">ログインはこちら</a>
        </div>
@endsection