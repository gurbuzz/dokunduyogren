<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->name }} Etiketleri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>{{ $page->name }} Etiketleri</h2>
                        <form action="{{ route('pages.show_tags', ['page' => $page->page_id]) }}" method="GET" class="form-inline">
                            <label for="language" class="mr-2">Dil Seçimi:</label>
                            <select id="language" name="language" class="form-control mr-2">
                                <option value="en" {{ request('language') == 'en' ? 'selected' : '' }}>İngilizce</option>
                                <option value="tr" {{ request('language') == 'tr' ? 'selected' : '' }}>Türkçe</option>
                                <option value="fr" {{ request('language') == 'fr' ? 'selected' : '' }}>Fransızca</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Göster</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <canvas id="c" width="800" height="600"></canvas>
                        <a href="{{ route('books.pages.index', ['book' => $page->book_id]) }}" class="btn btn-secondary mt-3">Geri Dön</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tagModalLabel">Etiket Bilgisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="tagContent"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        var canvas = new fabric.Canvas('c', {
            hoverCursor: 'pointer',
            selection: false
        });

        fabric.Image.fromURL("{{ asset('images/' . $page->image_url) }}", function(img) {
            var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            img.scale(scale).set({
                left: (canvas.width - img.width * scale) / 2,
                top: (canvas.height - img.height * scale) / 2
            });
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        });

        @foreach($tags as $tag)
        (function() {
            var position = {!! json_encode($tag->position) !!};
            var shape;
            switch ("{{ $tag->shape_type }}") {
                case 'circle':
                    shape = new fabric.Circle({
                        left: position.x,
                        top: position.y,
                        radius: position.radius,
                        fill: 'rgba(0, 0, 255, 0.3)',
                        hasControls: false,
                        hasBorders: false,
                        selectable: true,
                        evented: true
                    });
                    break;
                case 'triangle':
                    shape = new fabric.Triangle({
                        left: position.x,
                        top: position.y,
                        width: position.width,
                        height: position.height,
                        fill: 'rgba(0, 0, 255, 0.3)',
                        hasControls: false,
                        hasBorders: false,
                        selectable: true,
                        evented: true
                    });
                    break;
                case 'rect':
                default:
                    shape = new fabric.Rect({
                        left: position.x,
                        top: position.y,
                        width: position.width,
                        height: position.height,
                        fill: 'rgba(0, 0, 255, 0.3)',
                        hasControls: false,
                        hasBorders: false,
                        selectable: true,
                        evented: true
                    });
                    break;
            }

            @php
                $label = request('language') && $tag->label_info['translated_language'] == request('language') ? $tag->label_info['translated_label'] : $tag->label_info['label'];
            @endphp
            shape.data = { label: "{{ $label }}" };
            canvas.add(shape);

            shape.on('mousedown', function() {
                document.getElementById('tagContent').innerText = shape.data.label;
                $('#tagModal').modal('show');
            });
        })();
        @endforeach

        canvas.on('mouse:down', function(options) {
            if (!options.target) {
                canvas.discardActiveObject().renderAll();
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
