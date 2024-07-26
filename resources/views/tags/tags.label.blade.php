<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etiket Bilgisi Gir</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">  
                    <div class="card-header">
                        <h2>Etiket Bilgisi Gir</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pages.store_labels', ['page_id' => $tags->first()->page_id]) }}" method="POST">
                            @csrf
                            @foreach($tags as $tag)
                                <div class="form-group">
                                    <label for="tag-{{ $tag->id }}">Etiket Açıklaması (X: {{ $tag->position_x }}, Y: {{ $tag->position_y }}):</label>
                                    <input type="text" class="form-control" id="tag-{{ $tag->id }}" name="tags[{{ $tag->id }}]" required>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Finish</button>
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
