<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Düzenle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Kitap Düzenle</h2>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Geri</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('books.update', ['book' => $book->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Kitap Adı:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Yazar:</label>
                                <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
                            </div>
                            <div class="form-group">
                                <label for="published_date">Yayın Tarihi:</label>
                                <input type="date" class="form-control" id="published_date" name="published_date" value="{{ $book->published_date }}" required>
                            </div>
                            <div class="form-group">
                                <label for="isbn">ISBN:</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $book->isbn }}" required>
                            </div>
                            <div class="form-group">
                                <label for="cover_image">Kapak Resmi:</label>
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>
                            <div class="form-group">
                                <label for="category">Kategori:</label>
                                <input type="text" class="form-control" id="category" name="category" value="{{ $book->category }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
