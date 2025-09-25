@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/set_profile.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__title">プロフィール設定</div>
    <form class="main__forms" action="/mypage/profile" method="post" enctype="multipart/form-data">
    @csrf
        <div class="icon">
            <div class="icon__img">
                <img src="{{asset($user['profile_img'])}}" alt="" class="curr__img" id="currImage">
                <img id="preview" src="" alt="" class="preview__img">
            </div>
            <label for="img__upload" class="icon__choice">
                画像を選択する
            </label>
            <input type="file" id="img__upload" name="profile_img" class="input__img" onchange="previewImage(event)">
        </div>
        <div class="main__form">
            <div class="main__form--item">ユーザー名</div>
            <div class="main__form--input">
                <input type="text" class="form__input" value="{{ old('name', $user['name']) }}" name="name">
            </div>
        </div>
        <div class="error">
        @if($errors->has('name'))
        {{$errors->first('name')}}
        @endif
        </div>
        <div class="main__form">
            <div class="main__form--item">郵便番号</div>
            <div class="main__form--input">
                <input type="text" class="form__input" value="{{ old('post_number', $user['post_number']) }}" name="post_number">
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
                <input type="text" class="form__input" value="{{ old('address', $user['address']) }}" name="address">
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
                <input type="text" class="form__input" value="{{ old('building', $user['building']) }}" name="building">
            </div>
        </div>
        <button class="main__button" type="submit">更新する</button>
    </form>
</div>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            const preview = document.getElementById('preview');
            const currImage = document.getElementById('currImage');
            preview.src = reader.result;
            preview.style.display = 'block';
            currImage.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection