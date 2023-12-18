<?php

function conectarDb() {
    $host = 'localhost';
    $dbname = 'citas_medicas';
    $usuario = 'root';
    $contrasena = '';

    // Crear una conexión
    $conexion = mysqli_connect($host, $usuario, $contrasena, $dbname);

    // Verificar la conexión
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Configurar la codificación de caracteres
    mysqli_set_charset($conexion, "utf8");

    return $conexion;
}


?>
