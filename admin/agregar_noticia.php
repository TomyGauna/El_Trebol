<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se envió el formulario con un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen']) && isset($_POST['content_nuevo'])) {
    $titulo = $_POST['titulo'];
    $content_nuevo = $_POST['content_nuevo'];
    $contenido = $_POST['contenido'];
    $is_field = $_POST['is_field'];

    $imagen = $_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo subido
    $imagen_ruta = "../img/" . $imagen; // Ruta final donde se guardará la imagen
    move_uploaded_file($imagen_temporal, $imagen_ruta);

    $segment = $_POST['segment'];
    $region = $_POST['region'];
    $priority_segment = $_POST['priority_segment'];
    $priority_region = $_POST['priority_region'];
    $dia_creacion = $_POST['dia_creacion'];

    // Verificar y actualizar noticias existentes con el valor de "is_field" actual
    $consulta_existencia = "SELECT id FROM noticias WHERE is_field = ? AND is_field != 0";
    $stmt_existencia = $conexion->prepare($consulta_existencia);
    $stmt_existencia->bind_param("i", $is_field);
    $stmt_existencia->execute();
    $result_existencia = $stmt_existencia->get_result();

    if ($result_existencia->num_rows > 0) {
        // Actualizar la noticia existente con "is_field" al valor por defecto (0)
        $consulta_actualizar = "UPDATE noticias SET is_field = 0 WHERE is_field = ?";
        $stmt_actualizar = $conexion->prepare($consulta_actualizar);
        $stmt_actualizar->bind_param("i", $is_field);
        $stmt_actualizar->execute();
    }

    // Verificar y actualizar la noticia existente con 'priority_segment' "primary"
    if ($priority_segment === 'primary') {
        $consulta_primary_existente = "SELECT id FROM noticias WHERE priority_segment = 'primary' AND segment = ?";
        $stmt_primary_existente = $conexion->prepare($consulta_primary_existente);
        $stmt_primary_existente->bind_param("s", $segment);
        $stmt_primary_existente->execute();
        $result_primary_existente = $stmt_primary_existente->get_result();

        if ($result_primary_existente->num_rows > 0) {
            // Actualizar la noticia existente con "priority_segment" primary a secondary
            $consulta_actualizar_primary = "UPDATE noticias SET priority_segment = 'secondary' WHERE priority_segment = 'primary' AND segment = ?";
            $stmt_actualizar_primary = $conexion->prepare($consulta_actualizar_primary);
            $stmt_actualizar_primary->bind_param("s", $segment);
            $stmt_actualizar_primary->execute();
        }
    }

    // Preparar la consulta para agregar la noticia
    $consulta = "INSERT INTO noticias (titulo, content_nuevo, contenido, is_field, imagen, segment, region, priority_segment, priority_region, dia_creacion, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetros
    $stmt->bind_param("ssssssssss", $titulo, $content_nuevo, $contenido, $is_field, $imagen, $segment, $region, $priority_segment, $priority_region, $dia_creacion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Noticia agregada correctamente.";
        header("Location: panel_admin.php");
        exit();
    } else {
        echo "Error al agregar la noticia: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Noticia</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container my-4">
        <h2>Agregar Noticia</h2>
        <form method="POST" action="agregar_noticia.php" enctype="multipart/form-data">
            <div class="form-group my-3">
                <label class="mb-1" for="titulo">Titulo:</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="contenido">Subtitulo:</label>
                <textarea class="form-control" name="contenido"></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen miñatura:</label>
                <input type="file" class="form-control-file" name="imagen" accept="image/*">
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="content_nuevo">Contenido de la nota:</label>
                <!-- Agregar campo oculto para el contenido del Summernote -->
                <input type="hidden" name="content_nuevo" id="content_nuevo">
                <div id="summernote"></div>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="is_field">Is Field:</label>
                <select class="form-control" name="is_field">
                    <option value="NULL">None</option>
                    <option value="1">Field 1</option>
                    <option value="2">Field 2</option>
                    <option value="3">Field 3</option>
                    <option value="4">Field 4</option>
                    <option value="5">Field 5</option>
                    <option value="6">Field 6</option>
                    <option value="7">Field 7</option>
                    <option value="8">Field 8</option>
                    <option value="9">Field 9</option>
                    <option value="10">Field 10</option>
                    <option value="11">Field 11</option>
                    <option value="12">Field 12</option>
                    <option value="13">Field 13</option>
                    <option value="14">Field 14</option>
                    <option value="15">Field 15</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="region">Region:</label>
                <select class="form-control" name="region">
                    <option value="san_martin">San Martin</option>
                    <option value="tres_de_febrero">Tres de Febrero</option>
                    <option value="malvinas_argentinas">Malvinas Argentinas</option>
                    <option value="san_isidro">San Isidro</option>
                    <option value="vicente_lopez">Vicente Lopez</option>
                    <option value="none">Por defecto</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="priority_region">Prioridad en la region:</label>
                <select class="form-control" name="priority_region">
                    <option value="primary">Principal</option>
                    <option value="secondary">Secundario</option>
                    <option value="none">Por defecto</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="segment">Segmento:</label>
                <select class="form-control" name="segment">
                    <option value="politica">Politica</option>
                    <option value="sociedad">Sociedad</option>
                    <option value="cultura">Cultura</option>
                    <option value="deportes">Deportes</option>
                    <option value="unsam">UNSAM</option>
                    <option value="none">Por defecto</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="priority_segment">Prioridad en el segmento:</label>
                <select class="form-control" name="priority_segment">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="none">Por defecto</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label class="mb-1" for="dia_creacion">Fecha:</label>
                <input type="text" class="form-control" name="dia_creacion"></input> 
            </div>

            <button type="reset" class="btn btn-primary">Reset Note</button>
            <button type="submit" class="btn btn-primary">Save Note</button>
        </form>
        
        <br>
        <a href="panel_admin.php"><button class="btn btn-secondary">Volver al inicio</button></a>
    </div>

    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Escribi la nota aca',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Roboto'],
            fontNamesWithCSS: ['Roboto'],
            // Captura el contenido del Summernote antes de enviar el formulario
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#content_nuevo').val(contents);
                },
                onImageUpload: function(image, editor, welEditable) {
                uploadImage(image[0]);
                }
            }
        });
    });
    </script>

    <script>
    function uploadImage(image) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
        url: '../controller/upload.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            console.log(url);
            var image = $('<img>').attr('src', '../' + url);
            $('#summernote').summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
    }
    </script>
</body>
</html>
