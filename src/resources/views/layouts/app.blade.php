<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <img src="{{asset('storage/logo.svg')}}" alt="" class="header__logo--img">
            </div>
            <div class="header__search-form">
                <form action="">
                @csrf
                    <input type="text" class="search-form__input" placeholder="なにをお探しですか？">
                </form>
            </div>
            <div class="header__buttons">
                <div class="header__logout">
                    <form action="/logout" method="post" class="header__form">
                    @csrf
                        <button class="header__button--submit" type="submit">ログアウト</button>
                    </form>
                </div>
                <div class="header__mypage">
                    <a href="" class="header__button--mypage">マイページ</a>
                </div>
                <div class="header__exhibit">
                    <a href="" class="header__button--exhibit">出品</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    @yield('content')
    </main>
</body>
</html>