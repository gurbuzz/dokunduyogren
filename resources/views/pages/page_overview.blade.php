<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} Sayfa Listesi</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            color: #333;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-bar-custom">
        <a class="navbar-brand" href="#">DokunDuyOgren</a>
        <div class="navbar-nav">
            <span class="nav-link">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">Çıkış Yap</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="content mt-4">
            <h2>{{ $book->title }} - Sayfa Listesi</h2>
            <a href="{{ route('books.pages.create', $book->id) }}" class="btn btn-success btn-create">Yeni Sayfa Oluştur</a>
            <button class="btn btn-primary btn-refresh" onclick="location.reload();">Yenile</button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sayfa Numarası</th>
                        <th>Sayfa İsmi</th>
                        <th>Kategori</th>
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
                    <td>{{ $page->category }}</td>
                    <td>{{ $page->tags }}</td>
                    <td>{{ $page->content }}</td>
                    <td><img src="{{ asset('images/' . $page->image_url) }}" alt="Image" style="width: 100px;"></td>
                    <td>
                    <a href="{{ route('pages.edit', $page->page_id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('pages.destroy', $page->page_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        <i class="fas fa-language" style="color: grey; cursor: not-allowed;"></i>
                    </td>
                </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
