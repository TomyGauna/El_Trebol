<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Definir variables para evitar advertencias de "Undefined variable"
$id_noticia = $titulo = $contenido = $categoria = "";
$mensaje = "";

// Verificar si se recibió un ID de noticia para editar
if (isset($_GET['id_noticia'])) {
    // Obtener el ID de noticia desde la URL
    $id_noticia = $_GET['id_noticia'];

    // Consultar la información de la noticia
    $consulta_noticia_individual = "SELECT * FROM noticias WHERE id = $id_noticia";
    $resultado_noticia = $conexion->query($consulta_noticia_individual);

    // Verificar si se encontró la noticia
    if ($resultado_noticia->num_rows > 0) {
        $fila_noticia = $resultado_noticia->fetch_assoc();

        // Asignar valores a las variables
        $titulo = $fila_noticia['titulo'];
        $content_nuevo = $fila_noticia['content_nuevo'];
        $contenido = $fila_noticia['contenido'];
        $is_field = $fila_noticia['is_field'];

        $imagen = $fila_noticia['imagen'];

        $segment = $fila_noticia['segment'];
        $region = $fila_noticia['region'];
        $priority_segment = $fila_noticia['priority_segment'];
        $priority_region = $fila_noticia['priority_region'];
        $dia_creacion = $fila_noticia['dia_creacion'];
    } else {
        echo "No se encontró la noticia.";
    }
}

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content_nuevo'])) {
    // Obtener datos del formulario
    $id_noticia = $_POST['id_noticia'];
    $titulo = $_POST['titulo'];
    $content_nuevo = $_POST['content_nuevo'];
    $contenido = $_POST['contenido'];
    $is_field = $_POST['is_field'];

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

    // Verificar si el nuevo valor de priority_segment es "primary"
    if ($priority_segment == "primary") {
        // Actualizar todas las noticias con el mismo segmento y priority_segment a "secondary"
        $consulta_actualizar_segmento = "UPDATE noticias SET priority_segment = 'secondary' WHERE segment = ? AND priority_segment = 'primary'";
        $stmt_actualizar_segmento = $conexion->prepare($consulta_actualizar_segmento);
        $stmt_actualizar_segmento->bind_param("s", $segment);
        $stmt_actualizar_segmento->execute();
    }

    // Verificar si se ha cargado un nuevo contenido
    if (!empty($_POST['content_nuevo'])) {
        $content_nuevo = $_POST['content_nuevo'];
    } else {
        // Si no se ha cargado un nuevo contenido, recuperar el contenido existente de la base de datos
        $consulta_contenido_existente = "SELECT content_nuevo FROM noticias WHERE id = ?";
        $stmt_contenido_existente = $conexion->prepare($consulta_contenido_existente);
        $stmt_contenido_existente->bind_param("i", $id_noticia);
        $stmt_contenido_existente->execute();
        $result_contenido_existente = $stmt_contenido_existente->get_result();

        if ($result_contenido_existente->num_rows > 0) {
            $fila_contenido_existente = $result_contenido_existente->fetch_assoc();
            $content_nuevo = $fila_contenido_existente['content_nuevo'];
        } else {
            $content_nuevo = ''; // Si no se encuentra el contenido existente, establecer como cadena vacía
        }
    }

    // Verificar si se ha cargado una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = "../img/" . $imagen;
        move_uploaded_file($imagen_temporal, $imagen_ruta);
    } else {
        // Si no se ha cargado una nueva imagen, conservar la imagen existente
        $imagen = isset($_POST['imagen_existente']) ? $_POST['imagen_existente'] : '';
    }

    // Preparar la consulta para actualizar la noticia
    $consulta_actualizar = "UPDATE noticias SET titulo=?, contenido=?, content_nuevo=?, is_field=?, imagen=?, segment=?, region=?, priority_segment=?, priority_region=?, dia_creacion=? WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta_actualizar);

    // Enlazar parámetros
    $stmt->bind_param("sssssssssss", $titulo, $contenido, $content_nuevo, $is_field, $imagen, $segment, $region, $priority_segment, $priority_region, $dia_creacion, $id_noticia);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = "La noticia se actualizó correctamente.";
        // Redirigir al panel de administración
        header("Location: lista_noticias.php");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        $mensaje = "Error al actualizar la noticia: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
}

// Cerrar la conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="container my-4">
        <h2>Editar Noticia</h2>
        <!-- Mostrar mensaje -->
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <!-- Formulario para editar noticias -->
        <form method="POST" action="editar_noticia.php" enctype="multipart/form-data">
            <input type="hidden" name="id_noticia" value="<?php echo $id_noticia; ?>">
            
            <div class="form-group my-3">
                <label for="titulo" class="mb-1">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
            </div>

            <div class="form-group my-3">
                <label for="contenido" class="mb-1">Subtitulo:</label>
                <textarea class="form-control" id="contenido" name="contenido"><?php echo $contenido; ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen miñatura:</label>
                <input type="file" class="form-control-file" name="imagen" accept="image/*">
                <!-- Mostrar la imagen existente si hay una -->
                <?php if (!empty($imagen)) { ?>
                    <img style="max-width: 30rem; max-height: 30rem;" src="../img/<?php echo $imagen; ?>" alt="">
                <?php } ?>
                <!-- Incluir un campo oculto para conservar la imagen existente -->
                <input type="hidden" name="imagen_existente" value="<?php echo $imagen; ?>">
            </div>

            <div class="form-group my-3">
                <label for="content_nuevo" class="mb-1">Contenido nota:</label>
                <input type="hidden" name="content_nuevo" id="content_nuevo">
                <div id="summernote"><?php echo $content_nuevo; ?></div>
            </div>

            <div class="form-group my-3">
                <label for="is_field" class="mb-1">Is Field:</label>
                <select class="form-control" name="is_field">
                    <option value="NULL">None</option>
                    <option value="1" <?php if ($is_field == '1') echo 'selected'; ?>>Field 1</option>
                    <option value="2" <?php if ($is_field == '2') echo 'selected'; ?>>Field 2</option>
                    <option value="3" <?php if ($is_field == '3') echo 'selected'; ?>>Field 3</option>
                    <option value="4" <?php if ($is_field == '4') echo 'selected'; ?>>Field 4</option>
                    <option value="5" <?php if ($is_field == '5') echo 'selected'; ?>>Field 5</option>
                    <option value="6" <?php if ($is_field == '6') echo 'selected'; ?>>Field 6</option>
                    <option value="7" <?php if ($is_field == '7') echo 'selected'; ?>>Field 7</option>
                    <option value="8" <?php if ($is_field == '8') echo 'selected'; ?>>Field 8</option>
                    <option value="9" <?php if ($is_field == '9') echo 'selected'; ?>>Field 9</option>
                    <option value="10" <?php if ($is_field == '10') echo 'selected'; ?>>Field 10</option>
                    <option value="11" <?php if ($is_field == '11') echo 'selected'; ?>>Field 11</option>
                    <option value="12" <?php if ($is_field == '12') echo 'selected'; ?>>Field 12</option>
                    <option value="13" <?php if ($is_field == '13') echo 'selected'; ?>>Field 13</option>
                    <option value="14" <?php if ($is_field == '14') echo 'selected'; ?>>Field 14</option>
                    <option value="15" <?php if ($is_field == '15') echo 'selected'; ?>>Field 15</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <div class="form-group my-3">
                <label for="region" class="mb-1">Region:</label>
                <select class="form-control" name="region">
                    <option value="san_martin" <?php if ($region == 'san_martin') echo 'selected'; ?>>San Martin</option>
                    <option value="tres_de_febrero" <?php if ($region == 'tres_de_febrero') echo 'selected'; ?>>Tres de Febrero</option>
                    <option value="malvinas_argentinas" <?php if ($region == 'malvinas_argentinas') echo 'selected'; ?>>Malvinas Argentinas</option>
                    <option value="san_isidro" <?php if ($region == 'san_isidro') echo 'selected'; ?>>San Isidro</option>
                    <option value="vicente_lopez" <?php if ($region == 'vicente_lopez') echo 'selected'; ?>>Vicente Lopez</option>
                    <option value="none" <?php if ($region == 'none') echo 'selected'; ?>>None</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label for="priority_region" class="mb-1">Priority Region:</label>
                <select class="form-control" name="priority_region">
                    <option value="primary" <?php if ($priority_region == 'primary') echo 'selected'; ?>>Primary</option>
                    <option value="secondary" <?php if ($priority_region == 'secondary') echo 'selected'; ?>>Secondary</option>
                    <option value="none" <?php if ($priority_region == 'none') echo 'selected'; ?>>None</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label for="segment" class="mb-1">Segment:</label>
                <select class="form-control" name="segment">
                    <option value="politica" <?php if ($segment == 'politica') echo 'selected'; ?>>Politica</option>
                    <option value="sociedad" <?php if ($segment == 'sociedad') echo 'selected'; ?>>Sociedad</option>
                    <option value="cultura" <?php if ($segment == 'cultura') echo 'selected'; ?>>Cultura</option>
                    <option value="deportes" <?php if ($segment == 'deportes') echo 'selected'; ?>>Deportes</option>
                    <option value="unsam" <?php if ($segment == 'unsam') echo 'selected'; ?>>UNSAM</option>
                    <option value="none" <?php if ($segment == 'none') echo 'selected'; ?>>None</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label for="priority_segment" class="mb-1">Priority Segment:</label>
                <select class="form-control" name="priority_segment">
                    <option value="primary" <?php if ($priority_segment == 'primary') echo 'selected'; ?>>Primary</option>
                    <option value="secondary" <?php if ($priority_segment == 'secondary') echo 'selected'; ?>>Secondary</option>
                    <option value="none" <?php if ($priority_segment == 'none') echo 'selected'; ?>>None</option>
                </select>
            </div>

            <div class="form-group my-3">
                <label for="dia_creacion" class="mb-1">Fecha:</label>
                <input type="text" class="form-control" name="dia_creacion" value="<?php echo $dia_creacion; ?>"></input> 
            </div>

            <button type="reset" class="btn btn-primary">Reset Nota</button>
            <button type="submit" class="btn btn-primary">Guardar Nota</button>
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
            var image = $('<img>').attr('src', 'http://localhost:90/TAM_PortalClienteSLI/' + url);
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
