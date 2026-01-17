@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="side__navigation">
    <div class="side__navigation--content">
        その他の取引
    </div>
    @if($dealingItems != null)
        @foreach($dealingItems as $dealing_item)
        <div class="side__navigation--other-deals">
            <a href="/chat:{{$dealing_item['id']}}" class="other-details__link">{{$dealing_item['item_name']}}</a>
        </div>
        @endforeach
    @endif
</div>
<div class="main__content">
    <div class="main__top-bar">
        @if($client->profile_img == null)
        <div class="main__profile-icon"></div>
        @else
        <div class="main__profile-icon"><img src="{{asset($client->profile_img)}}" alt="" class="icon-img"></div>
        @endif
        <div class="main__profile-name">{{$client['name']}}さんとの取引画面</div>

        @if(($item['seller_id'] != $user['id']))
        <div class="main__top--button">
            <form action="/chat:{{$item['id']}}" method="get">
                <input type="hidden" value=1 name="evaluation_flag">
                <input type="hidden" value="{{$client['id']}}" name="user_id">
                <input type="hidden" value="{{ $orderId }}" name="order_id">
                <button class="main__button--submit">取引を完了する</button>
            </form>
        </div>
        @endif

    </div>
    <div class="main__horizon-line"></div>
    <div class="main__item">
        <div class="item__img">
            <img src="{{asset($item['item_img'])}}" alt="" class="img">
        </div>
        <div class="item__info">
            <div class="item__name">{{$item['item_name']}}</div>
            <div class="item__price">¥{{$item['price']}}</div>
        </div>
    </div>
    <div class="main__horizon-line"></div>
    <div class="main__chat">
        @if($chats != null)
            @foreach($chats as $chat)
                @if($param == $chat->sender_flag)
                <div class="main__chat--me">
                    <div class="main__chat--user-info">
                        @if($user->profile_img == null)
                        <div class="main__chat-icon"></div>
                        @else
                        <div class="main__chat-icon">
                            <img src="{{asset($user->profile_img)}}" alt="" class="icon-img">
                        </div>
                        @endif
                        <div class="main__chat--name">{{$user['name']}}</div>
                    </div>
                    @if($chat['edit_flag'] == 0)
                    <div class="main__chat--message">
                        {{$chat['message']}}
                    </div>
                    @if($chat['img'] != null)
                    <div class="main__chat--img">
                        <img src="{{asset($chat['img'])}}" alt="" class="img">
                    </div>
                    @endif
                    <div class="chat__edit">
                        <form action="/chat:{{$item['id']}}" method="get">
                            <input type="hidden" value="{{$chat['id']}}" name="edit_chat_id">
                            <button type="submit" class="chat__edit--button">編集</button>
                        </form>
                        <form action="/chat/delete" method="post">
                            @csrf
                            <input type="hidden" value="{{$chat['id']}}" name="chat_id">
                            <input type="hidden" value="{{$item['id']}}" name="item_id">
                            <button type="submit" class="chat__edit--button">削除</button>
                        </form>
                    </div>
                    @else
                    <div class="main__chat--message main__chat--message-edit">
                        <form action="/chat/edit" method="post">
                        @csrf
                            <input type="hidden" value="{{$chat['id']}}" name="edit_chat_id">
                            <input type="hidden" value="{{$item['id']}}" name="item_id">
                            <textarea class="message__edit-field" name="message">{{ $chat['message'] }}</textarea>
                    </div>
                    <div class="chat__edit">
                        <button type="submit" class="chat__edit--button">更新</button>
                        </form>
                    </div>
                @endif
                </div>
                @else
                <div class="main__chat--client">
                    <div class="main__chat--user-info">
                        @if($client->profile_img == null)
                        <div class="main__chat-icon"></div>
                        @else
                        <div class="main__chat-icon"><img src="{{asset($client->profile_img)}}" alt="" class="icon-img"></div>
                        @endif
                        <div class="main__chat--name">{{$client['name']}}</div>
                    </div>
                    <div class="main__chat--message">
                        {{$chat['message']}}
                    </div>
                    @if($chat['img'] != null)
                    <div class="main__chat--img">
                        <img src="{{asset($chat['img'])}}" alt="" class="img">
                    </div>
                    @endif
                </div>
                @endif
            @endforeach
        @endif
    </div>
    <form action="/chat" method="post" enctype="multipart/form-data">
        @csrf
        <div class="main__bottom-bar">
            <div class="error">
                @if($errors->has('message'))
                {{$errors->first('message')}}
                @endif
            </div>
            <div class="error">
                @if($errors->has('item_img'))
                {{$errors->first('item_img')}}
                @endif
            </div>
            <div class="main__bottom-bar--inner">
                <input type="hidden" value="{{ $orderId }}" name="order_id">
                <input type="hidden" value="{{ $param }}" name="param">
                <input type="hidden" value="{{ $item['id'] }}" name="item_id">
                <input type="text" placeholder="取引メッセージを記入してください" class="main__message-box" name="message" id="messageBox" value="{{ old('message') }}">
                <label for="img__upload" class="main__img--label">
                    <span id="fileName" class="img__choice">画像を追加</span>
                </label>

                <input
                    type="file"
                    id="img__upload"
                    name="item_img"
                    class="input__img"
                    onchange="previewFile(event)"
                >
                <button type="submit" class="main__message-send-button">
                    <img src="{{asset('images/e99395e98ea663a8400f40e836a71b8c4e773b01.jpg')}}" alt="" class="send-button__img">
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('messageBox');
        const form = input.closest('form');

        const itemId = "{{ $item['id'] }}";
        const storageKey = `chat_message_${itemId}`;

        if (localStorage.getItem(storageKey)) {
            input.value = localStorage.getItem(storageKey);
        }

        input.addEventListener('input', () => {
            localStorage.setItem(storageKey, input.value);
        });

        form.addEventListener('submit', () => {
        localStorage.removeItem(storageKey);
        });

    });

    function previewFile(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const fileName = document.getElementById('fileName');

        if (!file) return;

        fileName.textContent = file.name;
    }
</script>

@if($evaluationFlag == 1)
    @livewire('chat',[
        'userId' => request('user_id'),
        'orderId' => request('order_id'),
    ])
@elseif($order['dealing_completed_flag_purchaser'] == 1)
    @livewire('chat', [
        'userId' => $userId,
        'orderId' => $orderId,
    ])
@endif

@endsection