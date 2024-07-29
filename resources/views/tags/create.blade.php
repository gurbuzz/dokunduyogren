<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etiket Ekle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .selection-box {
            border: 2px dashed red;
            position: absolute;
            pointer-events: none;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Yarı saydam katman */
            pointer-events: none;
        }
        .image-container {
            position: relative;
        }
    </style>
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
                        <div class="image-container">
                            <img src="{{ asset('images/' . $page->image_url) }}" id="image" style="max-width: 100%;">
                            <div class="overlay" id="image-overlay"></div> <!-- Yarı saydam katman -->
                            <div id="selection-box" class="selection-box" style="display: none;"></div>
                        </div>
                        <form id="store-tags-form" action="{{ route('pages.store_tags', ['page' => $page->page_id]) }}" method="POST">
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

    <!-- Modal -->
    <div class="modal fade" id="labelModal" tabindex="-1" role="dialog" aria-labelledby="labelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelModalLabel">Etiket Bilgisi Gir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(isset($tags))
                    <form action="{{ route('pages.store_labels', ['page' => $page->page_id]) }}" method="POST">
                        @csrf
                        @foreach($tags as $tag)
                            <div class="form-group">
                                <label for="tag-{{ $tag->id }}">Etiket Açıklaması (X: {{ $tag->position_x }}, Y: {{ $tag->position_y }}):</label>
                                <input type="text" class="form-control" id="tag-{{ $tag->id }}" name="tags[{{ $tag->id }}]" required>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Finish</button>
                    </form>
                    @else
                        <p>Etiket bulunamadı. Lütfen sayfaya etiket ekleyin.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let startX, startY, endX, endY;
        const image = document.getElementById('image');
        const selectionBox = document.getElementById('selection-box');
        const overlay = document.getElementById('image-overlay');
        const coordinatesField = document.getElementById('coordinates');

        image.addEventListener('mousedown', function(event) {
            const rect = image.getBoundingClientRect();
            startX = event.clientX - rect.left;
            startY = event.clientY - rect.top;
            selectionBox.style.left = startX + 'px';
            selectionBox.style.top = startY + 'px';
            selectionBox.style.width = '0px';
            selectionBox.style.height = '0px';
            selectionBox.style.display = 'block';
            overlay.style.display = 'block'; // Yarı saydam katmanı göster
        });

        image.addEventListener('mousemove', function(event) {
            if (selectionBox.style.display === 'block') {
                const rect = image.getBoundingClientRect();
                endX = event.clientX - rect.left;
                endY = event.clientY - rect.top;
                selectionBox.style.width = Math.abs(endX - startX) + 'px';
                selectionBox.style.height = Math.abs(endY - startY) + 'px';
                selectionBox.style.left = Math.min(startX, endX) + 'px';
                selectionBox.style.top = Math.min(startY, endY) + 'px';
            }
        });

        image.addEventListener('mouseup', function(event) {
            if (selectionBox.style.display === 'block') {
                const rect = image.getBoundingClientRect();
                endX = event.clientX - rect.left;
                endY = event.clientY - rect.top;
                selectionBox.style.display = 'none';
                overlay.style.display = 'none'; // Yarı saydam katmanı gizle

                const x = Math.min(startX, endX);
                const y = Math.min(startY, endY);
                const width = Math.abs(endX - startX);
                const height = Math.abs(endY - startY);

                // Alan seçimi ile ilgili veriyi kaydet
                coordinatesField.value += x + ',' + y + ',' + width + ',' + height + ';';

                // Görsel üzerinde seçilen alanı işaretlemek için bir div ekleyin
                const marker = document.createElement('div');
                marker.style.position = 'absolute';
                marker.style.border = '2px dashed red';
                marker.style.left = x + 'px';
                marker.style.top = y + 'px';
                marker.style.width = width + 'px';
                marker.style.height = height + 'px';
                marker.style.pointerEvents = 'none'; // Markerların tıklanmasını engelle
                image.parentElement.appendChild(marker); // Seçim kutusunu resim konteynerine ekle
            }
        });

        // Next butonuna basıldığında modal'ı aç
        document.querySelector('form[action*="store_tags"]').addEventListener('submit', function(event) {
            event.preventDefault();
            $('#labelModal').modal('show');
        });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
