<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiket Ekle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        .canvas-container {
            margin-top: 20px;
            text-align: center;
        }
        canvas {
            border: 1px solid #ccc;
        }
        .modal-dialog {
            max-width: 600px;
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Etiket Ekle</h2>
                    </div>
                    <div class="card-body">
                        <div class="canvas-container">
                            <canvas id="c" width="800" height="600"></canvas>
                        </div>
                        <button class="btn btn-primary mt-3" id="saveButton">Kaydet</button>
                        <button class="btn btn-danger mt-3" id="deleteButton">Seçilen Alanı Sil</button>
                        <button class="btn btn-success mt-3" id="finishButton">Bitir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <input type="text" class="form-control" id="labelInput" placeholder="Etiket girin">
                    <button class="btn btn-primary mt-2" id="saveLabel">Kaydet</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var canvas = new fabric.Canvas('c', {
            hoverCursor: 'pointer',
            selection: true,
            selectionBorderColor: 'blue'
        });

        fabric.Image.fromURL("{{ asset('images/' . $page->image_url) }}", function(img) {
            var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            img.scale(scale).set({
                left: (canvas.width - img.width * scale) / 2,
                top: (canvas.height - img.height * scale) / 2,
                opacity: 0.85
            });
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        });

        var rect, isDown, origX, origY;
        var selectedAreas = [];

        canvas.on('mouse:down', function(o) {
            if (!canvas.getActiveObject()) {
                isDown = true;
                var pointer = canvas.getPointer(o.e);
                origX = pointer.x;
                origY = pointer.y;
                rect = new fabric.Rect({
                    left: origX,
                    top: origY,
                    originX: 'left',
                    originY: 'top',
                    width: pointer.x - origX,
                    height: pointer.y - origY,
                    fill: 'rgba(255,0,0,0.3)',
                    transparentCorners: false
                });
                canvas.add(rect);
            }
        });

        canvas.on('mouse:move', function(o) {
            if (!isDown) return;
            var pointer = canvas.getPointer(o.e);
            if (origX > pointer.x) rect.set({ left: Math.abs(pointer.x) });
            if (origY > pointer.y) rect.set({ top: Math.abs(pointer.y) });
            rect.set({ width: Math.abs(origX - pointer.x) });
            rect.set({ height: Math.abs(origY - pointer.y) });
            canvas.renderAll();
        });

        canvas.on('mouse:up', function() {
            isDown = false;
            selectedAreas.push(rect);
            rect.on('selected', function() {
                $('#labelModal').modal('show');
                document.getElementById('labelInput').value = rect.get('label') || '';
                document.getElementById('saveLabel').onclick = function() {
                    var labelValue = document.getElementById('labelInput').value;
                    if (labelValue) {
                        rect.set('label', labelValue);
                        $('#labelModal').modal('hide');
                        canvas.renderAll();
                    }
                };
            });
            canvas.setActiveObject(rect);
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            alert('Alanlar kaydedildi!');
            selectedAreas.forEach(function(area) {
                area.set({ selectable: true, evented: true });
            });
            canvas.discardActiveObject();
            canvas.renderAll();

            // Alanları backend'e gönder
            var coordinates = selectedAreas.map(function(area) {
                return {
                    x: area.left,
                    y: area.top,
                    width: area.width * area.scaleX,
                    height: area.height * area.scaleY,
                    label: area.get('label') // Label değerinin gönderildiğinden emin olun
                };
            });

            $.ajax({
                url: '{{ route("pages.store_tags", ["page" => $page->page_id]) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    coordinates: JSON.stringify(coordinates)
                },
                success: function(response) {
                    console.log('Etiketler kaydedildi:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Kaydetme hatası:', error);
                }
            });
        });

        document.getElementById('deleteButton').addEventListener('click', function() {
            var activeObject = canvas.getActiveObject();
            if (activeObject) {
                canvas.remove(activeObject);
                selectedAreas = selectedAreas.filter(area => area !== activeObject);
            }
        });

        document.getElementById('finishButton').addEventListener('click', function() {
            window.location.href = "{{ route('books.pages.index', ['book' => $page->book_id]) }}";
        });

        canvas.on('object:added', function() {
            canvas.setActiveObject(rect);
            rect.setCoords();
            canvas.renderAll();
        });

        canvas.on('object:moving', function(e) {
            var obj = e.target;
            obj.setCoords();
            var objBoundingBox = obj.getBoundingRect();
            if (objBoundingBox.left < 0 || objBoundingBox.top < 0 || objBoundingBox.left + objBoundingBox.width > canvas.width || objBoundingBox.top + objBoundingBox.height > canvas.height) {
                obj.left = Math.max(objBoundingBox.left, 0);
                obj.top = Math.max(objBoundingBox.top, 0);
                obj.left = Math.min(objBoundingBox.left, canvas.width - objBoundingBox.width);
                obj.top = Math.min(objBoundingBox.top, canvas.height - objBoundingBox.height);
            }
        });

        // Her bir alan tıklanabilir ve silinebilir olmalıdır
        selectedAreas.forEach(function(area) {
            area.on('selected', function() {
                $('#labelModal').modal('show');
                document.getElementById('labelInput').value = area.get('label') || '';
                document.getElementById('saveLabel').onclick = function() {
                    var labelValue = document.getElementById('labelInput').value;
                    if (labelValue) {
                        area.set('label', labelValue);
                        $('#labelModal').modal('hide');
                        canvas.renderAll();
                    }
                };
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
