<?php
if (isset($_GET['id_noticia'])) {
    $id_noticia = $_GET['id_noticia'];
    
    if (isset($_POST['confirmar_eliminar'])) {
        // Conexión a la base de datos
        require('../includes/conexion.php');

        // Prepara la consulta para eliminar la noticia
        $consulta = "DELETE FROM noticias WHERE id = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("i", $id_noticia);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Cerrar la conexión y la declaración
            $stmt->close();
            $conexion->close();
            
            // Redirigir a lista_noticias.php
            header("Location: lista_noticias.php");
            exit();
        } else {
            echo "Error al eliminar la noticia: " . $conexion->error;
        }

        // Cierra la conexión y la declaración
        $stmt->close();
        $conexion->close();
    } else {
        echo "¿Estás seguro de que deseas eliminar esta noticia?";
        echo "<form method='post'>";
        echo "<input type='submit' name='confirmar_eliminar' value='Confirmar Eliminar'>";
        echo "</form>";
    }
} else {
    echo "No se recibió el ID de la noticia a eliminar.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Noticia</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Eliminar Noticia</h2>
        <!-- Formulario para eliminar noticias -->
        <a href="panel_admin.php"><button>Volver al inicio</button></a>
    </div>
</body>
</html>
