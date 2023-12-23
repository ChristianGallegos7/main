<?php
// Incluir el archivo de configuración de la base de datos
include "./includes/config/database.php";

// Conectar a la base de datos
$conexion = conectarDb();

$errores = [];

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email) {
        $errores[] = "El correo es obligatorio para iniciar sesion";
    }

    if (!$password) {
        $errores[] = "La contraseña es obligatorio para iniciar sesion";
    }

    // echo "<pre>";
    //     var_dump($errores);
    // echo "</pre>";

    if(empty($errores)){
        //revisar si el usuario existe
        $query = "SELECT * FROM tbl_usuarios WHERE correo = '$email' ";
        $resultado = mysqli_query($conexion,$query);

        // var_dump($resultado);
        if($resultado->num_rows){
            //revisar si el passoword es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            //verificar si el passwors es correcto

            $auth = password_verify($password,$usuario['contrasena']);

            if($auth){
                //el usuario esta autenticado
                session_start();
                $_SESSION['usuario'] = $usuario['correo'];
                $_SESSION['login'] = true;

            }else{
                $errores[] = "Contraseña incorrecta";
            }
        }else{
            $errores[] = "Usuario no encontrado";
        }
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
    <h1>Iniciar Sesión</h1>
    <?php foreach ($errores as $error) : ?>
        <div>
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form action="login.php" method="post" novalidate>
        <fieldset>
            <legend>LOGIN</legend>
            <label for="correo">E-Mail</label>
            <input type="text" name="correo" id="correo" required>
            <label for="passsword">Constraseña</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Iniciar Sésion</button>
        </fieldset>

    </form>
</body>

</html>