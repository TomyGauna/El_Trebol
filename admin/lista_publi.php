<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Obtener todas las publis
$consulta_publi = "SELECT * FROM publi";
$resultado = $conexion->query($consulta_publi);

if ($resultado->num_rows > 0) {
    // Mostrar todas las publis en forma de lista
    while ($fila = $resultado->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $fila['titulo'] . "</h3>";
        echo "<p><strong>is field:</strong> " . $fila['is_field'] . "</p>";
        // Botón para editar la publi
        echo "<a href='editar_publi.php?id_publi=" . $fila['id'] . "'>Editar</a> |";
        // Botón para eliminar la publi
        echo " <a href='eliminar_publi.php?id_publi=" . $fila['id'] . "'>Eliminar</a>";
        echo "</div>";
        echo "<hr>";
    }
} else {
    echo "No hay publis para mostrar.";
}

echo "<a href='panel_admin.php'><button>Volver al inicio</button></a>";

// Cerrar la conexión
$conexion->close();
?>