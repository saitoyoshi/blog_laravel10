<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-dark-mode/1.0.2/bootstrap-dark-mode.min.css">
</head>
<body>
    <header class="container py-4">
        <h3 class="mb-4">ブログシステム</h3>
        @auth
        <p>こんにちは{{ request()->user()->name }}さん</p>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="btn btn-info">ログアウト</button>
        </form>
        @endauth
        @guest
            <a href="{{ route('login') }}"><button>ログイン</button></a>
            <a href="{{ route('register') }}"><button>新規登録</button></a>
        @endguest
        <hr>
    </header>
    <main class="container">
        {{ $slot }}
    </main>
    <footer class="container py-4">
        @laravel
    </footer>
</body>
</html>
