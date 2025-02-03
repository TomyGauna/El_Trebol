<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se envió el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Hash de la contraseña
    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

    // Consulta para insertar un nuevo usuario en la base de datos
    $consulta_registro = "INSERT INTO usuarios (nombre, correo, contraseña, tipo_usuario) VALUES (?, ?, ?, 'normal')";
    $stmt = $conexion->prepare($consulta_registro);
    $stmt->bind_param("sss",  $nombre, $correo, $hashed_password);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
