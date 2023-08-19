<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header>
        ブログシステム
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button>ログアウト</button>
        </form>
        <hr>
    </header>
    <main>
        {{ $slot }}
    </main>
    <footer>
        @laravel
    </footer>
</body>
</html>
