<?php
// Incluir el archivo de conexión a la base de datos
require('includes/conexion.php');

// Verificar si se envió el formulario con un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contenido'])) {
    // Obtener el contenido del Summernote del campo oculto 'contenido'
    $contenido = $_POST['contenido'];

    // Preparar la consulta para agregar la muestra
    $consulta = "INSERT INTO prueba (muestra) VALUES (?)";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetros
    $stmt->bind_param("s", $contenido);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Muestra agregada correctamente.";
        header("Location: panel_admin.php");
        exit();
    } else {
        echo "Error al agregar la muestra: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>without bootstrap</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>
<body>
    <h2>Agregar Noticia</h2>
    <form method="POST" action="nose.php" enctype="multipart/form-data">
        <!-- Agregar un campo oculto para almacenar el contenido del Summernote -->
        <input type="hidden" name="contenido" id="contenido">
        <!-- Div donde se mostrará el editor Summernote -->
        <div id="summernote"></div>
        <!-- Agregar un área de texto adicional para mostrar el contenido capturado -->
        <textarea id="contenido_mostrado" rows="10" cols="50" readonly></textarea>
        <button type="reset" class="btn btn-primary">Reset Note</button>
        <button type="submit" class="btn btn-primary">Save Note</button>
    </form>

    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Hello stand alone ui',
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
                    $('#contenido').val(contents);
                    $('#contenido_mostrado').val(contents); // Actualiza el contenido del área de texto adicional
                }
            }
        });
    });
    </script>
</body>
</html>
