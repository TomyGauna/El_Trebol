<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se enviaron datos de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para obtener la contraseña almacenada del usuario
    $consulta = "SELECT contraseña FROM usuarios WHERE nombre = ?";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($consulta);
    
    // Enlazar parámetros
    $stmt->bind_param("s", $usuario);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontró un usuario con el nombre proporcionado
    if ($result->num_rows == 1) {
        // Obtener la contraseña almacenada
        $fila = $result->fetch_assoc();
        $contraseña_almacenada = $fila['contraseña'];

        // Verificar si la contraseña coincide utilizando password_verify()
        if (password_verify($contrasena, $contraseña_almacenada)) {
            // Iniciar sesión y redirigir al panel de administración
            session_start();
            $_SESSION['usuario'] = $usuario;
            header('Location: panel_admin.php');
            exit;
        }
    }

    // Mostrar mensaje de error si las credenciales son incorrectas
    $error = "Usuario o contraseña incorrectos.";

    // Cerrar la consulta
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de inicio de sesión</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="error-container">
        <h2>Error de inicio de sesión</h2>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        <a href="../login.php">Volver al inicio de sesión</a>
    </div>
</body>
</html>
