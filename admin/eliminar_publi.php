<?php
if (isset($_GET['id_publi'])) {
    $id_publi = $_GET['id_publi'];
    
    if (isset($_POST['confirmar_eliminar'])) {
        // Conexión a la base de datos
        require('../includes/conexion.php');

        // Prepara la consulta para eliminar la noticia
        $consulta = "DELETE FROM publi WHERE id = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("i", $id_publi);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Cerrar la conexión y la declaración
            $stmt->close();
            $conexion->close();
            
            // Redirigir a lista_noticias.php
            header("Location: lista_publi.php");
            exit();
        } else {
            echo "Error al eliminar la publi: " . $conexion->error;
        }

        // Cierra la conexión y la declaración
        $stmt->close();
        $conexion->close();
    } else {
        echo "¿Estás seguro de que deseas eliminar esta publi?";
        echo "<form method='post'>";
        echo "<input type='submit' name='confirmar_eliminar' value='Confirmar Eliminar'>";
        echo "</form>";
    }
} else {
    echo "No se recibió el ID de la publi a eliminar.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Publi</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="admin-container">
        <h2>Eliminar Publi</h2>
        <!-- Formulario para eliminar noticias -->
        <a href="panel_admin.php"><button>Volver al inicio</button></a>
    </div>
</body>
</html>
