<?php
//base de datos
include "./includes/config/database.php";
$conexion = conectarDb();

//arreglo de errores
$errores = [];

$nombre = '';
$apellido = '';
$cedula = '';
$telefono = '';
$correo = '';
$contrasena = '';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }
    if (!$apellido) {
        $errores[] = "El apellido es obligatorio";
    }
    if (!$cedula) {
        $errores[] = "La cedula es obligatorio";
    }
    if (!$telefono) {
        $errores[] = "El telefono es obligatorio";
    }
    if (!$correo) {
        $errores[] = "El correo es obligatorio";
    }
    if (!$contrasena) {
        $errores[] = "La contraseña es obligatorio";
    }

    //hash a la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    if (empty($errores)) {
        //query para insertar en la base
        $query = "INSERT INTO tbl_usuarios(nombre,apellido,cedula,telefono,correo,contrasena) VALUES('$nombre','$apellido','$cedula','$telefono','$correo','$contrasenaHash')";

        $resultado = mysqli_query($conexion, $query);


        if ($resultado) {
            echo "Se inserto correctamene";
        } else {
            echo "no se inserto";
        }
    }
}
//cerrar la conexion
mysqli_close($conexion);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>

    <main>
        <?php foreach($errores as $error):?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach;?>    
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>" >

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $apellido;?>" >

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" value="<?php echo $cedula;?>" >

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $telefono;?>" >

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $correo;?>" >

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" value="<?php echo $contrasena;?>" >

            <button type="submit">Registrarse</button>
        </form>
    </main>

</body>

</html>