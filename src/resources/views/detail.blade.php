@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__left">
        <div class="left__item-img">
        <img src="{{asset($item['item_img'])}}" alt="" class="img">
        </div>
    </div>
    <div class="main__right">
        <div class="right__item-description">
            <div class="right__item-description--name">{{$item->item_name}}</div>
            <div class="right__item-description--bland">{{$item->brand_name}}</div>
            <div class="right__item-description--price">¥{{number_format($item->price)}}(税込)</div>
            <div class="right__item-action">
                <div class="right__item-action--fav">
                    @if($favFlag == 0)
                    <form action="/mylists" method="post">
                        @csrf
                        <button type="submit" class="fav__icon">⭐︎</button>
                        <input type="hidden" value="{{ $item->id }}" name="item_id">
                        <input type="hidden" value="{{ $userId }}" name="user_id">
                    </form>
                    @else
                    <form action="/mylists" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="fav__icon--my-list">⭐︎</button>
                        <input type="hidden" value="{{ $item->id }}" name="item_id">
                        <input type="hidden" value="{{ $userId }}" name="user_id">
                    </form>
                    @endif
                    <div class="fav__num">{{$favNum}}</div>
                </div>
                <div class="right__item-action--comment">
                    <div class="comment__icon"></div>
                    <div class="comment__num">{{$comNum}}</div>
                </div>
            </div>
            @if($item->sold_flag == 0)
            <div class="right__button--purchase">
                @if($item['seller_id'] == $userId)
                <form action="" method="get">
                @else
                <form action="/purchase" method="get">
                @endif
                @csrf
                    <button class="button__submit" type="submit">
                    <input type="hidden" value="{{ $userId }}" name="user_id">
                    <input type="hidden" value="{{ $item->id }}" name="item_id">
                        購入手続きへ
                    </button>
                </form>
            </div>
            @else
            <div class="right__button--purchase">
                <button class="button__submit" type="">
                    SOLD
                </button>
            </div>
            @endif
            <div class="right__item-description--description">商品説明</div>
            <div class="right__item-description--sentence">
                {{$item->item_description}}
            </div>
            <div class="right__item-information">商品の情報</div>
            <div class="item__category">
                <div class="item__category__title">
                    カテゴリー
                </div>
                @foreach($categories as $category)
                <div class="item__category__category">
                    {{$category->category}}
                </div>
                @endforeach
            </div>
            <div class="item__condition">
                <div class="item__condition__title">
                    商品の状態
                </div>
                <div class="item__condition__condition">
                    {{$item->item_condition}}
                </div>
            </div>
            <div class="item__comment">コメント({{$comNum}})</div>
            @foreach($comments as $comment)
            <div class="comment__sender">
                @if($comment->sender->profile_img == null)
                <div class="comment__sender--icon"></div>
                @else
                <div class="comment__sender--icon"><img src="{{asset($comment->sender->profile_img)}}" alt="" class="icon-img"></div>
                @endif
                <div class="comment__sender--name">{{ $comment->sender->name }}</div>
            </div>
            <div class="item__comment-sentence">
                {{ $comment->content }}
                </div>
            @endforeach
            <div class="item__comment--send">
                商品へのコメント
            </div>
            <form action="/comments" method="post">
            @csrf
                <input type="hidden" value="{{ $item->id }}" name="item_id">
                <input type="hidden" value="{{ $userId }}" name="sender_id">
                <textarea name="content" id="" class="comment__input">{{old('content')}}</textarea>
                <div class="error">
                @if($errors->has('content'))
                {{$errors->first('content')}}
                @endif
                </div>
                <div class="right__button--send-comment">
                <button class="button__submit" type="submit">
                    コメントを送信する
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection