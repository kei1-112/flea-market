@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="main">
    <form action="sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="main__title">商品の出品</div>
        <div class="sub__title">商品の画像</div>
        <div class="img__add-space">
            <label for="img__upload">
                <div class="img__choice" id="imgText">画像を選択する</div>
                <img id="preview" src="" alt="" class="preview__img">
            </label>
            <input type="file" id="img__upload" name="item_img" class="input__img" onchange="previewImage(event)">
        </div>
        <div class="error">
            @if($errors->has('item_img'))
            {{$errors->first('item_img')}}
            @elseif($errors->any())
            商品画像をアップロードしてください
            @endif
        </div>
        <div class="sub__title--large">商品の詳細</div>
        <div class="horizon-line"></div>
        <div class="sub__title">カテゴリー</div>
        <div class="categories">
            @foreach($categories as $category)
            <input type="checkbox"
                   id="{{ $category['category'] }}"
                   name="item_categories[]"
                   value="{{ $category['id'] }}"
                   class="checkbox"
                    {{ in_array($category['id'], old('item_categories', [])) ? 'checked' : '' }}/>
            <label for="{{ $category['category'] }}" class="category">
                <div>{{ $category['category'] }}</div>
            </label>
            @endforeach
        </div>
        <div class="error">
            @if($errors->has('item_categories'))
            {{$errors->first('item_categories')}}
            @endif
        </div>
        <div class="sub__title">商品の状態</div>
        <div class="form">
            <select class="form__select" name="item_condition">
                <option value="" disabled selected>選択してください</option>
                <option value="良好" {{ old('item_condition')=='良好' ? 'selected' : '' }}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('item_condition')=='目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('item_condition')=='やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('item_condition')=='状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>
        </div>
        <div class="error">
            @if($errors->has('item_condition'))
            {{$errors->first('item_condition')}}
            @endif
        </div>
        <div class="sub__title--large">商品名と説明</div>
        <div class="horizon-line"></div>
        <div class="sub__title">商品名</div>
        <div class="form">
            <input type="text" class="form__input" name="item_name" value="{{ old('item_name') }}">
        </div>
        <div class="error">
            @if($errors->has('item_name'))
            {{$errors->first('item_name')}}
            @endif
        </div>
        <div class="sub__title">ブランド名</div>
        <div class="form">
            <input type="text" class="form__input" name="brand_name" value="{{ old('brand_name') }}">
        </div>
        <div class="sub__title">商品の説明</div>
        <div class="form">
            <textarea name="item_description" class="form__textarea">{{ old('item_description') }}</textarea>
        </div>
        <div class="error">
            @if($errors->has('item_description'))
            {{$errors->first('item_description')}}
            @endif
        </div>
        <div class="sub__title">販売価格</div>
        <div class="form">
            <input type="text" class="form__input" placeholder="¥" name="price" value="{{ old('price') }}">
        </div>
        <div class="error">
            @if($errors->has('price'))
            {{$errors->first('price')}}
            @endif
        </div>
        <div class="button__purchase">
            <button class="button__submit" type="submit">
                出品する
            </button>
        </div>
    </form>
</div>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = () => {
            const preview = document.getElementById('preview');
            const text = document.getElementById('imgText');
            preview.src = reader.result;
            preview.style.display = 'block';
            text.style.display = 'none';
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection