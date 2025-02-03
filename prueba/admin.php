<?php
include 'includes/conexion.php';

// Obtener las noticias organizadas por sección
$consulta = "SELECT * FROM noticias ORDER BY is_field ASC";
$resultado = $conexion->query($consulta);
$noticias = [];

while($fila = $resultado->fetch_assoc()) {
    $noticias[$fila['categoria']][] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Noticias</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>Administrador de Noticias</h1>

    <div class="container">
        <?php foreach ($noticias as $categoria => $noticiasCategoria): ?>
            <div class="category-block" data-category="<?= $categoria; ?>">
                <h2><?= $categoria; ?></h2>
                <ul class="news-list" data-category="<?= $categoria; ?>">
                    <?php foreach ($noticiasCategoria as $noticia): ?>
                        <li class="news-item" data-id="<?= $noticia['id']; ?>">
                            <?= $noticia['titulo']; ?> (is_field: <?= $noticia['is_field']; ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="admin.js"></script>

</body>
</html>
