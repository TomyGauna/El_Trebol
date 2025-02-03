<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se envió el formulario con un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen'])) {
    $titulo = $_POST['titulo'];
    $is_field = $_POST['is_field'];
    $link = $_POST['link'];
    
    // Guardar solo el nombre del archivo de la imagen
    $imagen = $_FILES['imagen']['name'];

    $imagen_temporal = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo subido
    $imagen_ruta = "../img/" . $imagen; // Ruta final donde se guardará la imagen

    // Mover la imagen a la ubicación deseada en el servidor
    move_uploaded_file($imagen_temporal, $imagen_ruta);

    // Preparar la consulta para agregar la noticia
    $consulta = "INSERT INTO publi (titulo,  is_field, imagen, link, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetros
    $stmt->bind_param("ssss", $titulo, $is_field, $imagen, $link);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Publi agregada correctamente.";
        header("Location: panel_admin.php");
        exit();
    } else {
        echo "Error al agregar la publi: " . $conexion->error;
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
    <title>Agregar Publi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Publi</h2>
        <form method="POST" action="agregar_publi.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Titulo:</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" name="imagen" accept="image/*">
            </div>

            <div class="form-group">
                <label for="is_field">Is Field:</label>
                <select class="form-control" name="is_field">
                    <option value="NULL">None</option>
                    <option value="1">Field 1</option>
                    <option value="2">Field 2</option>
                    <option value="3">Field 3</option>
                    <option value="4">Field 4</option>
                    <option value="5">Field 5</option>
                    <option value="6">Field 6</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <div class="form-group">
                <label for="link">Link:</label>
                <input type="text" class="form-control" name="link" required>
            </div>

            <button type="reset" class="btn btn-primary">Reset Note</button>
            <button type="submit" class="btn btn-primary">Save Note</button>
        </form>
        
        <a href="panel_admin.php"><button>Volver al inicio</button></a>
    </div>
</body>
</html>