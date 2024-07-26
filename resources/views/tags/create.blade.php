<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etiket Ekle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">  
                    <div class="card-header">
                        <h2>Etiket Ekle</h2>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('images/' . $page->image_url) }}" id="image" style="max-width: 100%;">
                        <form action="{{ route('pages.store_tags', ['page' => $page->page_id]) }}" method="POST">
                            @csrf
                            <input type="hidden" id="coordinates" name="coordinates">
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

    <script>
    document.getElementById('image').addEventListener('click', function(event) {
        var x = event.offsetX;
        var y = event.offsetY;
        var coordinatesField = document.getElementById('coordinates');
        coordinatesField.value += x + ',' + y + ';';
        // Görsel üzerinde seçilen alanı işaretlemek için bir nokta ekleyin
        var marker = document.createElement('div');
        marker.style.position = 'absolute';
        marker.style.width = '10px';
        marker.style.height = '10px';
        marker.style.backgroundColor = 'red';
        marker.style.borderRadius = '50%';
        marker.style.top = (event.clientY - 5) + 'px';
        marker.style.left = (event.clientX - 5) + 'px';
        marker.style.pointerEvents = 'none'; // Markerların tıklanmasını engelle
        document.body.appendChild(marker);
    });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
