<?php
    //base de datos
 include "./includes/config/database.php";
 $conexion = conectarDb();

 if($_SERVER['REQUEST_METHOD'] == "POST"){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    //hash a la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    //query para insertar en la base
    $query = "INSERT INTO tbl_usuarios(nombre,apellido,cedula,telefono,correo,contrasena) VALUES('$nombre','$apellido','$cedula','$telefono','$correo','$contrasenaHash')";

    $resultado = mysqli_query($conexion,$query);


    if($resultado){
        echo "Se inserto correctamene";
    }else{
        echo "no se inserto";
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
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit">Registrarse</button>
        </form>
    </main>

</body>
</html>
