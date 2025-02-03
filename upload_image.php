<?php
// Ruta donde se guardarán las imágenes
$uploadDirectory = 'uploads/';

// Nombre de archivo único
$fileName = uniqid() . '_' . basename($_FILES['image']['name']);

// Ruta completa del archivo
$uploadPath = $uploadDirectory . $fileName;

// Intenta mover el archivo cargado al directorio de carga
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
    // Devuelve la URL de la imagen cargada
    echo $uploadPath;
} else {
    // Si hay un error, devuelve un mensaje de error
    echo 'Error al subir la imagen.';
}
?>
