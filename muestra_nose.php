<?php
// Incluir el archivo de conexión a la base de datos
require('includes/conexion.php');

// Realizar la consulta para obtener las muestras guardadas
$consulta = "SELECT * FROM prueba";
$resultado = $conexion->query($consulta);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Mostrar los datos como una lista
    echo "<h2>Muestras guardadas</h2>";
    echo "<div>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<div>ID: " . $fila['id'] . ", Muestra: " . $fila['muestra'] . "</div>";
    }
    echo "</div>";
} else {
    echo "No se encontraron muestras.";
}

// Liberar el resultado y cerrar la conexión
$resultado->free();
$conexion->close();
?>
