<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario']; // Se asume que el id del usuario se enviará desde el formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    // Preparar la consulta para editar el usuario
    $consulta = "UPDATE usuarios SET nombre=?, correo=? WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetros
    $stmt->bind_param("ssi", $nombre, $correo, $id_usuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario editado correctamente.";
    } else {
        echo "Error al editar el usuario: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
} else {
    // Recuperar el ID del usuario de la URL
    $id_usuario = $_GET['id'];

    // Consulta para obtener los detalles del usuario
    $consulta = "SELECT * FROM usuarios WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetro
    $stmt->bind_param("i", $id_usuario);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $resultado = $stmt->get_result();

    // Obtener los detalles del usuario
    $usuario = $resultado->fetch_assoc();

    // Cerrar la consulta
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Editar Usuario</h2>
        <!-- Formulario para editar usuarios -->
        <form action="editar_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['id']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required>
            </div>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
