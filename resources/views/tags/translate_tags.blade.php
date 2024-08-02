<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiket Çeviri</title>
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
                        <h2>Etiket Çeviri</h2>
                        <a href="{{ route('books.pages.index', ['book' => $page->book_id]) }}" class="btn btn-secondary">Geri Dön</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tags.translate.store', ['page' => $page->page_id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="language">Dil Seçimi</label>
                                <select id="language" name="language" class="form-control" style="width: 200px;">
                                    <option value="en" selected>İngilizce</option>
                                    <option value="tr">Türkçe</option>
                                    <option value="fr">Fransızca</option>
                                </select>
                            </div>
                            <h4>Etiketler</h4>
                            @foreach ($tags as $tag)
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <textarea id="tag-{{ $tag->tag_id }}" class="form-control" disabled>{{ $tag->label }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <textarea id="translated-tag-{{ $tag->tag_id }}" name="tags[{{ $tag->tag_id }}]" class="form-control">{{ $tag->translated_label ?? '' }}</textarea>
                                </div>
                            </div>
                            @endforeach
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
