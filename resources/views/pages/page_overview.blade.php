<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} Sayfa Listesi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
        <h2>{{ $book->title }} Sayfa Listesi</h2>
        <a href="{{ route('books.pages.create', ['book' => $book->id]) }}" class="btn btn-primary mb-3">Yeni Sayfa Ekle</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sayfa Numarası</th>
                    <th>Sayfa İsmi</th>
                    <th>Etiketler</th>
                    <th>İçerik</th>
                    <th>Resim</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->page_number }}</td>
                    <td>{{ $page->name }}</td>
                    <td>{{ $page->tags }}</td>
                    <td>{{ $page->content }}</td>
                    <td><img src="{{ asset('images/' . $page->image_url) }}" alt="Image" style="width: 150px; height: 100px;"></td>
                    <td>
                        <a href="{{ route('pages.show_tags', ['page' => $page->page_id]) }}" class="btn btn-info btn-sm">Etiketleri Göster</a>
                        <a href="{{ route('pages.edit', ['page' => $page->page_id]) }}" class="btn btn-warning btn-sm">Düzenle</a>
                        <a href="{{ route('pages.translate_tags', ['page' => $page->page_id]) }}" class="btn btn-success btn-sm">Çeviri</a>
                        <form action="{{ route('pages.destroy', ['page' => $page->page_id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
