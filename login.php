<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Panel de administración</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión - Panel de administración</h2>
        <form action="admin/index.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>