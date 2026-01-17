<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <a href="/">
                    <img src="{{asset('images/logo.svg')}}" alt="" class="header__img">
                </a>
            </div>
            <div class="header__search-form">
                <form action="/search" method="get">
                @csrf
                    <input type="text" class="search-form__input" name="item_name" placeholder="なにをお探しですか？" value="{{ request('item_name') }}">
                </form>
            </div>
            <div class="header__buttons">
                <div class="header__logout">
                    <form action="/logout" method="post" class="header__form">
                    @csrf
                        @auth
                        <button class="header__button--logout" type="submit">ログアウト</button>
                        @endauth
                        @guest
                        <a class="header__button--login" href='/login'>ログイン</a>
                        @endguest
                    </form>
                </div>
                <div class="header__mypage">
                    <a href="/mypage" class="header__button--mypage">マイページ</a>
                </div>
                <div class="header__exhibit">
                    <a href="/sell" class="header__button--exhibit">出品</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    @yield('content')
    </main>
</body>
</html>