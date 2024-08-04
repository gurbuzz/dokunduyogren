<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kitap Listesi</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            color: #333;
            margin: 0;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container {
            margin-top: 20px;
        }
        .btn-create, .btn-refresh {
            margin-bottom: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .nav-bar-custom {
            background-color: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-bar-custom .nav-item {
            margin-right: 20px;
        }
        .nav-bar-custom .nav-link {
            font-weight: bold;
        }
        .panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-bar-custom">
        <a class="navbar-brand" href="{{ url('/') }}">DokunDuyOgren</a>
        <div class="navbar-nav ml-auto">
            @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/profile') }}">Profil Ayarları</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Çıkış Yap</button>
                        </form>
                    </div>
                </div>
            @else
                <a class="nav-link" href="{{ route('login') }}">Giriş Yap</a>
                @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">Kayıt Ol</a>
                @endif
            @endauth
        </div>
    </nav>

    <div class="container mt-5 panel">
        <h2>Kitap Listesi</h2>
        <a href="{{ route('books.create') }}" class="btn btn-success mb-3">Yeni Kitap Ekle</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kapak Resmi</th>
                    <th>Kİtap Adı</th>
                    <th>Yazar</th>
                    <th>Yayın Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <td><img src="{{ asset('images/' . $book->cover_image) }}" alt="Kapak Resmi" style="width: 150px; height: 100px;"></td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->published_date }}</td>
                    <td>
                        <a href="{{ route('books.pages.index', $book->id) }}" class="btn btn-info">Sayfalar</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Düzenle</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
