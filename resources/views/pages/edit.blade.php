<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sayfa Düzenle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Sayfa Düzenle</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pages.update', $page->page_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">Sayfa İsmi</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $page->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="category">Kategori</label>
                                <input type="text" class="form-control" id="category" name="category" value="{{ $page->category }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tags">Etiket İsmi</label>
                                <input type="text" class="form-control" id="tags" name="tags" value="{{ $page->tags }}" required>
                            </div>
                            <div class="form-group">
                                <label for="image_url">Resim Yükle</label>
                                <input type="file" class="form-control-file" id="image_url" name="image_url">
                                <img src="{{ asset('images/' . $page->image_url) }}" alt="Image" style="width: 100%; height: auto; margin-top: 10px;">
                            </div>
                            <div class="form-group">
                                <label for="content">İçerik</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required>{{ $page->content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="page_number">Sayfa Numarası</label>
                                <input type="number" class="form-control" id="page_number" name="page_number" value="{{ $page->page_number }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                            <a href="{{ route('books.pages.index', $page->book_id) }}" class="btn btn-secondary">İptal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
