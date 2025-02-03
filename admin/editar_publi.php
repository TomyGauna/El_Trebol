<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Definir variables para evitar advertencias de "Undefined variable"
$id_publi = $titulo = $contenido = $categoria = "";
$mensaje = "";

// Verificar si se recibió un ID de publi para editar
if (isset($_GET['id_publi'])) {
    // Obtener el ID de publi desde la URL
    $id_publi = $_GET['id_publi'];

    // Consultar la información de la publi
    $consulta_publi_individual = "SELECT * FROM publi WHERE id = $id_publi";
    $resultado_publi = $conexion->query($consulta_publi_individual);

    // Verificar si se encontró la publi
    if ($resultado_publi->num_rows > 0) {
        $fila_publi = $resultado_publi->fetch_assoc();

        // Asignar valores a las variables
        $titulo = $fila_publi['titulo'];
        $is_field = $fila_publi['is_field'];
        $link = $fila_publi['link'];
        $imagen = $fila_publi['imagen'];


    } else {
        echo "No se encontró la publi.";
    }
}

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen'])) {
    // Obtener datos del formulario
    $id_publi = $_POST['id_publi'];
    $titulo = $_POST['titulo'];
    $is_field = $_POST['is_field'];
    $link = $_POST['link'];

    // Verificar y actualizar publis existentes con el valor de "is_field" actual
    $consulta_existencia = "SELECT id FROM publis WHERE is_field = ? AND is_field != 0";
    $stmt_existencia = $conexion->prepare($consulta_existencia);
    $stmt_existencia->bind_param("i", $is_field);
    $stmt_existencia->execute();
    $result_existencia = $stmt_existencia->get_result();

    if ($result_existencia->num_rows > 0) {
        // Actualizar la publi existente con "is_field" al valor por defecto (0)
        $consulta_actualizar = "UPDATE publis SET is_field = 0 WHERE is_field = ?";
        $stmt_actualizar = $conexion->prepare($consulta_actualizar);
        $stmt_actualizar->bind_param("i", $is_field);
        $stmt_actualizar->execute();
    }

    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = "../img/" . $imagen;
        move_uploaded_file($imagen_temporal, $imagen_ruta);
    }

    // Preparar la consulta para actualizar la publi
    $consulta_actualizar = "UPDATE publis SET titulo=?, is_field=?, link=? WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta_actualizar);

    // Enlazar parámetros
    $stmt->bind_param("ssss", $titulo, $is_field, $link, $id_publi);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = "La publi se actualizó correctamente.";
        // Redirigir al panel de administración
        header("Location: lista_publis.php");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        $mensaje = "Error al actualizar la publi: " . $conexion->error;
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
    <title>Editar publi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Editar publi</h2>
        <!-- Mostrar mensaje -->
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <!-- Formulario para editar publis -->
        <form method="POST" action="editar_publi.php" enctype="multipart/form-data">
            <input type="hidden" name="id_publi" value="<?php echo $id_publi; ?>">
            
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>">
            </div>

            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" name="imagen" accept="image/*">
                <img src="../img/<?php echo $imagen; ?>" alt="">
            </div>

            <div class="form-group">
                <label for="is_field">Is Field:</label>
                <select class="form-control" name="is_field">
                    <option value="NULL">None</option>
                    <option value="1" <?php if ($is_field == '1') echo 'selected'; ?>>Field 1</option>
                    <option value="2" <?php if ($is_field == '2') echo 'selected'; ?>>Field 2</option>
                    <option value="3" <?php if ($is_field == '3') echo 'selected'; ?>>Field 3</option>
                    <option value="4" <?php if ($is_field == '4') echo 'selected'; ?>>Field 4</option>
                    <option value="5" <?php if ($is_field == '5') echo 'selected'; ?>>Field 5</option>
                    <option value="6" <?php if ($is_field == '6') echo 'selected'; ?>>Field 6</option>
                </select>
            </div>

            <div class="form-group">
                <label for="link">Link:</label>
                <textarea id="text" type="text" class="form-control" name="link"><?php echo $link; ?></textarea>
            </div>

            <input type="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>
