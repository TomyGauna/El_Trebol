<?php
include '../includes/conexion.php';

// Obtener el cuerpo del POST en formato JSON
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    foreach ($data as $news_item) {
        $id = $news_item['id'];
        $is_field = $news_item['is_field'];
        $categoria = $news_item['category'];

        // Actualizar la base de datos con el nuevo valor de is_field y la nueva categoría
        $sql = "UPDATE noticias SET is_field = ?, categoria = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isi", $is_field, $categoria, $id);
        $stmt->execute();
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
