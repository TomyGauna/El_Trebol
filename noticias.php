<?php
// Incluir el archivo de conexión a la base de datos
require('includes/conexion.php');

// Consulta para obtener todas las noticias
$consulta_noticias = "SELECT * FROM noticias ORDER BY fecha_publicacion DESC";
$resultado_noticias = $conexion->query($consulta_noticias);

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Todas las Noticias</h1>
        <div class="todas-las-noticias">
            <?php
            // Mostrar todas las noticias
            while ($fila = $resultado_noticias->fetch_assoc()) {
                echo "<div class='noticia'>";
                echo "<h2>".$fila['titulo']."</h2>";
                echo "<p>".$fila['contenido']."</p>";
                echo "<a href='noticia.php?id=".$fila['id']."'>Leer más</a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
