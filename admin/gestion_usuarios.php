<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Consulta para obtener todos los usuarios
$consulta = "SELECT * FROM usuarios";

// Ejecutar la consulta
$resultado = $conexion->query($consulta);

// Verificar si hay usuarios
if ($resultado->num_rows > 0) {
    // Mostrar la tabla de usuarios
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Correo</th></tr>";
    while($fila = $resultado->fetch_assoc()) {
        echo "<tr><td>".$fila["id"]."</td><td>".$fila["nombre"]."</td><td>".$fila["correo"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron usuarios.";
}

// Cerrar la conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Gestionar Usuarios</h2>
        <!-- Lista de usuarios con opciones para editar roles, eliminar, etc. -->
        <!-- Aquí se colocará la tabla de usuarios y opciones de gestión -->
    </div>
</body>
</html>
