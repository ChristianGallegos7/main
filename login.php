<?php
// Incluir el archivo de configuración de la base de datos
include "./includes/config/database.php";

// Conectar a la base de datos
$conexion = conectarDb();

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Query para buscar el usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $query);

    // Verificar si la consulta encontró el usuario
    if ($resultado) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificar la contraseña con hash
        if ($usuario && password_verify($password, $usuario['contrasena'])) {
            // Inicio de sesión exitoso
            echo "Inicio de sesión exitoso";
        } else {
            // Usuario o contraseña incorrectos
            echo "Usuario o contraseña incorrectos";
        }
    } else {
        // Error en la consulta
        echo "Error al intentar iniciar sesión. Por favor, inténtalo de nuevo.";
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="http://localhost/proyecto/build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <form action="login.php">
        <fieldset>
            <legend>LOGIN</legend>
            <label for="correo">Correo</label>
            <input type="text" name="correo" id="correo">
            <label for="passsword">Constraseña</label>
            <input type="password" name="passsword" id="passsword">
            <button type="submit">Iniciar Sésion</button>
        </fieldset>
        
    </form>
</body>
</html>