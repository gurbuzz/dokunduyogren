<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Kod Ekle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">  
                    <div class="card-header">
                        <h2>QR Kod Ekle</h2>
                    </div>
                    <div class="card-body">
                        <h3>{{ $page->name }}</h3>
                        <p>{{ $page->content }}</p>
                        <img src="{{ asset('images/' . $page->image_url) }}" alt="Image" style="width: 50%; height: auto; margin-top: 5px;">
                        
                        <!-- QR Kod Kaydetme Formu -->
                        <form action="{{ route('pages.store.qrcode', ['page' => $page->page_id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="qr_image">QR Kod Resmi Yükle:</label>
                                <input type="file" class="form-control-file" id="qr_image" name="qr_image" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Açıklama:</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">QR Kodu Kaydet</button>
                        </form>

                        <!-- Etiket Ekleme Formu -->
                        <form action="{{ route('pages.add_tags', ['page' => $page->page_id]) }}" method="GET" style="margin-top: 10px;">
                            <button type="submit" class="btn btn-primary">Next</button>
                        </form>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
