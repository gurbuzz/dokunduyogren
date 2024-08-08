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
        .instruction {
            margin: 20px 0;
            font-size: 16px;
            text-align: center;
            color: #555;
        }
        .shape-buttons {
            text-align: center;
            margin-bottom: 20px;
        }
        .shape-buttons button {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h2>Etiket Ekle</h2>
                    </div>
                    <div class="card-body">
                        <p class="instruction">
                            Etiket eklemek için, resim üzerinde bir alan seçin ve etiket bilgilerini girin. Seçilen alanları kaydetmek için "Kaydet" butonuna, silmek için "Seçilen Alanı Sil" butonuna tıklayın. İşlemi bitirmek için "Bitir" butonuna tıklayın.
                        </p>
                        <div class="shape-buttons">
                            <button class="btn btn-outline-primary" id="rectButton">Dikdörtgen</button>
                            <button class="btn btn-outline-primary" id="circleButton">Daire</button>
                            <button class="btn btn-outline-primary" id="triangleButton">Üçgen</button>
                        </div>
                        <div class="canvas-container">
                            <canvas id="c" width="800" height="600"></canvas>
                        </div>
                        <button class="btn btn-primary mt-3" id="saveButton">Kaydet</button>
                        <button class="btn btn-danger mt-3" id="deleteButton">Seçilen Alanı Sil</button>
                        <button class="btn btn-warning mt-3" id="resetButton">Sıfırla</button>
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

        var isDown, origX, origY;
        var selectedAreas = [];
        var currentShape = null;
        var shapeType = 'rect';

        document.getElementById('rectButton').addEventListener('click', function() {
            shapeType = 'rect';
        });

        document.getElementById('circleButton').addEventListener('click', function() {
            shapeType = 'circle';
        });

        document.getElementById('triangleButton').addEventListener('click', function() {
            shapeType = 'triangle';
        });

        canvas.on('mouse:down', function(o) {
            if (!canvas.getActiveObject()) {
                isDown = true;
                var pointer = canvas.getPointer(o.e);
                origX = pointer.x;
                origY = pointer.y;
                switch (shapeType) {
                    case 'rect':
                        currentShape = new fabric.Rect({
                            left: origX,
                            top: origY,
                            originX: 'left',
                            originY: 'top',
                            width: pointer.x - origX,
                            height: pointer.y - origY,
                            fill: 'rgba(0, 0, 255, 0.3)',
                            transparentCorners: false
                        });
                        break;
                    case 'circle':
                        currentShape = new fabric.Circle({
                            left: origX,
                            top: origY,
                            originX: 'left',
                            originY: 'top',
                            radius: 1,
                            fill: 'rgba(0, 0, 255, 0.3)',
                            transparentCorners: false
                        });
                        break;
                    case 'triangle':
                        currentShape = new fabric.Triangle({
                            left: origX,
                            top: origY,
                            originX: 'left',
                            originY: 'top',
                            width: pointer.x - origX,
                            height: pointer.y - origY,
                            fill: 'rgba(0, 0, 255, 0.3)',
                            transparentCorners: false
                        });
                        break;
                }
                canvas.add(currentShape);
            }
        });

        canvas.on('mouse:move', function(o) {
            if (!isDown) return;
            var pointer = canvas.getPointer(o.e);
            switch (shapeType) {
                case 'rect':
                    if (origX > pointer.x) currentShape.set({ left: Math.abs(pointer.x) });
                    if (origY > pointer.y) currentShape.set({ top: Math.abs(pointer.y) });
                    currentShape.set({ width: Math.abs(origX - pointer.x) });
                    currentShape.set({ height: Math.abs(origY - pointer.y) });
                    break;
                case 'circle':
                    var radius = Math.max(Math.abs(origX - pointer.x), Math.abs(origY - pointer.y)) / 2;
                    currentShape.set({ radius: radius });
                    currentShape.set({ left: origX - radius, top: origY - radius });
                    break;
                case 'triangle':
                    if (origX > pointer.x) currentShape.set({ left: Math.abs(pointer.x) });
                    if (origY > pointer.y) currentShape.set({ top: Math.abs(pointer.y) });
                    currentShape.set({ width: Math.abs(origX - pointer.x) });
                    currentShape.set({ height: Math.abs(origY - pointer.y) });
                    break;
            }
            canvas.renderAll();
        });

        canvas.on('mouse:up', function() {
            isDown = false;
            selectedAreas.push(currentShape);
            $('#labelModal').modal('show');
            document.getElementById('labelInput').value = '';
            canvas.setActiveObject(currentShape);
        });

        document.getElementById('saveLabel').addEventListener('click', function() {
            var labelValue = document.getElementById('labelInput').value;
            if (labelValue && currentShape) {
                currentShape.set('label', labelValue);
                $('#labelModal').modal('hide');
                canvas.renderAll();
                currentShape = null;
            }
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            alert('Alanlar kaydedildi!');
            selectedAreas.forEach(function(area) {
                area.set({ selectable: true, evented: true });
            });
            canvas.discardActiveObject();
            canvas.renderAll();

            var coordinates = selectedAreas.map(function(area) {
                return {
                    x: area.left,
                    y: area.top,
                    width: area.width * area.scaleX || null,
                    height: area.height * area.scaleY || null,
                    radius: area.radius || null,
                    label: area.get('label'),
                    shape_type: area.type
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

        document.getElementById('resetButton').addEventListener('click', function() {
            location.reload();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
