<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} Sayfa Listesi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-bar-custom">
        <a class="navbar-brand" href="{{ url('/') }}">DokunDuyOgren</a>
        <div class="navbar-nav ml-auto">
            <span class="nav-link">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="form-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">Çıkış Yap</button>
            </form>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12"> 
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>{{ $book->title }} Sayfa Listesi</h2>
                        <a href="{{ route('books.pages.create', ['book' => $book->id]) }}" class="btn btn-primary">Yeni Sayfa Ekle</a>
                    </div>
                    <div class="card-body">
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
                                    <td><img src="{{ asset('images/' . $page->image_url) }}" alt="Image" style="width: 150px; height: 100px;"></td>
                                    <td>
                                        <a href="{{ route('pages.show_tags', ['page' => $page->page_id]) }}" class="btn btn-info btn-sm">Etiketleri Göster</a>
                                        <a href="{{ route('pages.edit', ['page' => $page->page_id]) }}" class="btn btn-warning btn-sm">Düzenle</a>
                                        <button class="btn btn-success btn-sm">Çeviri</button>
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
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
