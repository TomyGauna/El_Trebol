<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Cambiar si es necesario
$usuario = 'root';
$contraseña = '';
$base_datos = 'el_trebol';

// Crear conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Establecer el tiempo de espera de la conexión en 300 segundos (5 minutos)
mysqli_options($conexion, MYSQLI_OPT_CONNECT_TIMEOUT, 300);

// Establecer juego de caracteres a UTF-8
$conexion->set_charset("utf8");
?>