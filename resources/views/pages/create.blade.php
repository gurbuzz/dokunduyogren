<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sayfa Oluştur</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Sayfa Oluştur</h2>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Geri</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('books.pages.store', ['book' => $book->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <div class="form-group">
                                <label for="name">Sayfa Adı:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="image_url">Resim Yükle:</label>
                                <input type="file" class="form-control-file" id="image_url" name="image_url" required onchange="previewImage(event)">
                                <img id="image_preview" src="" alt="Resim Önizlemesi" class="img-fluid mt-3" style="max-width: 200px; display: none;">
                            </div>
                            <div class="form-group">
                                <label for="content">İçerik:</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="page_number">Sayfa Numarası:</label>
                                <input type="number" class="form-control" id="page_number" name="page_number" required>
                            </div>
                            <button type="submit" class="btn btn-primary">İleri</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
