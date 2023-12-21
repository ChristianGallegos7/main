<?php
    include "../templates/header.php";

    include "../../includes/config/database.php";

    $conexion = conectarDb();
    //Escribir el query
    $query = "SELECT * FROM tbl_doctores";
    //consultar la bd
    $resultadoConsulta = mysqli_query($conexion,$query);

    //muestra mensaje condicional si se crea el doctor
    $resultado = $_GET['resultado'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/proyecto/build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        a{
            color: black;
        }
    </style>
</head>

<body>

    <?php if ($resultado == 1) : ?>
        <p>Doctor Creado Correctamente</p>
        <?php elseif ($resultado == 2) : ?>
            <p>Doctor Actualizado Correctamente</p>
    <?php endif; ?>

    

    <a href="http://localhost/proyecto/admin/doctores/crear.php">Crear doctor</a>

    <table>
        <thead>
            <tr>
                <th>Id</th>

                <th>Nombre</th>
                <th>Apellido</th>
                <th>Especialidad</th>
                <th>Horario</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($doctor = mysqli_fetch_assoc($resultadoConsulta)):?>
            <tr>
                <td><?php echo $doctor['id'];?></td>
                <td><?php echo $doctor['nombre'];?></td>
                <td><?php echo $doctor['apellido'];?></td>
                <td><?php echo $doctor['especialidad'];?></td>
                <td><?php echo $doctor['horario'];?></td>
                <td><img width="100px" src="../../imagenes/<?php echo $doctor['foto'];?>" alt="IMAGEN DEL DOCTOR"></td>
                <td>
                    <a href="./actualizar.php?id=<?php echo $doctor['id'];?>">Editar</a>
                    <form action="">
                        <input type="hidden" name="id" value="id">
                    </form>
                </td>

            </tr>
            <?php endwhile;?>
        </tbody>
    </table>

</body>

</html>