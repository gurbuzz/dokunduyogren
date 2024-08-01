<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 56px); /* Navbar yüksekliğini çıkaralım */
        }
        .links {
            margin-bottom: 20px;
        }
        .links > a {
            color: #636b6f;
            padding: 10px 25px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            background-color: #fff;
            border: 2px solid #636b6f;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .links > a:hover {
            background-color: #636b6f;
            color: #fff;
        }
        h1 {
            font-size: 36px;
            margin-top: 20px;
            color: #222;
        }
        h2 {
            font-size: 24px;
            color: #555;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-bar-custom">
        <a class="navbar-brand" href="{{ url('/') }}">DokunDuyOgren</a>
        <div class="navbar-nav ml-auto">
            @auth
                <span class="nav-link">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="form-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">Çıkış Yap</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Giriş Yap</a>
                @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">Kayıt Ol</a>
                @endif
            @endauth
        </div>
    </nav>

    <div class="container">
        @auth
            <div class="links">
                <a href="{{ url('/books') }}">Kitap Listesi</a>
            </div>
        @else
            <h2>Giriş Yapınız</h2>
        @endauth
        <h1>DokunDuyOgren</h1>
    </div>

    <!-- Bootstrap JS (Optional, for better responsiveness) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
