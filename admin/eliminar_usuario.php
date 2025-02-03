<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario']; // Se asume que el id del usuario se enviará desde el formulario

    // Preparar la consulta para eliminar el usuario
    $consulta = "DELETE FROM usuarios WHERE id=?";

    // Preparar la declaración
    $stmt = $conexion->prepare($consulta);

    // Enlazar parámetro
    $stmt->bind_param("i", $id_usuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conexion->error;
    }

    // Cerrar la consulta
    $stmt->close();
} else {
    // Redirigir si no se recibió un ID válido
    header('Location: gestion_usuarios.php');
    exit;
}
?>
