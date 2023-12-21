<?php
    //base de datos
    include "../../includes/config/database.php";

    //obtener el id que mandamos desde el index para actualizar
    $id = $_GET['id'] ?? null;
    //verificar si es un int y que no nos pasen un string o algo raro
    $id = filter_var($id,FILTER_VALIDATE_INT);

    // si es un string o otra cosa que no redirija al index
    if(!$id){
        header('Location: index.php');
        exit;
    }

    include "../templates/header.php";

    $conexion = conectarDb();

    //obtener los datos del doctor
    $consultaDoctor = "SELECT * FROM tbl_doctores WHERE id = " . $id;
    $resultadoDoctor = mysqli_query($conexion, $consultaDoctor);
    $datosDoctor = mysqli_fetch_assoc($resultadoDoctor);

    // echo "<pre>";
    //     var_dump($datosDoctor);
    // echo "</pre>";


    //seleccionar la especialidad 
    $query = "SELECT * FROM tbl_especialidades";
    $resultado = mysqli_query($conexion,$query);

    //arreglo de errores
    $errores = [];

    $nombre = $datosDoctor['nombre'];
    $apellido = $datosDoctor['apellido'];
    $especialidad = $datosDoctor['especialidad'];
    $horario = $datosDoctor['horario'];
    $foto = $datosDoctor['foto'];

    

    if($_SERVER['REQUEST_METHOD']== "POST"){

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $especialidad = $_POST['especialidad'];
        $horario = $_POST['horario'];

        //imagen 
        $foto = $_FILES['foto'];
       
        if(!$nombre){
            $errores[] = "El nombre es requerido";
        }

        if(!$apellido){
            $errores[] = "El apellido es requerido";
        }

        if(!$especialidad){
            $errores[] = "la especialidad es requerido";
        }
        if(!$horario){
            $errores[] = "El horario es requerido";
        }

        

        if(empty($errores)){

            // //SUBIR ARCHIVOS
            // //CREEAAMOS LAA CARPETAA

            $carpetaImagenes = "../../imagenes/";
            // SI LA CARPETA NO EXISTE LA CREA
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';
            //si actualizamos la imagen tenemos que eliminarla de la carpeta para que no se llene el servidor

            if ($foto['name']) {
                // ELIMINAR LA IMAGEN PREVIA
                unlink($carpetaImagenes . $datosDoctor['foto']);
                
                // GENERAR UN NOMBRE ÚNICO PARA LA NUEVA IMAGEN
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                
                // SUBIR LA NUEVA IMAGEN
                move_uploaded_file($foto['tmp_name'], $carpetaImagenes . $nombreImagen);
            } else {
                // SI NO SE SUBE UNA NUEVA IMAGEN, MANTENER LA IMAGEN ACTUAL
                $nombreImagen = $datosDoctor['foto'];
            }



            //query para insertarwd
            $doctor = "UPDATE tbl_doctores SET 
            nombre = '$nombre',
            apellido = '$apellido', 
            especialidad = '$especialidad',
            horario = '$horario',
            foto = '$nombreImagen'
            WHERE id = $id ";

            //insertar en la base
            $result = mysqli_query($conexion,$doctor);

            if($result){
                //redireccionar si se inserto correctamente el doctor en la base de datos
                //mandamos el parametro resultado para crear la alerta desde el index
                header('Location: index.php?resultado=2');
            }
        }
    }
    mysqli_close($conexion);

?>
    <main>
        <h1>Actualizar Doctor</h1>

        <?php foreach($errores as $error):?>
            <div>
                <?php echo $error;?>
            </div>
        <?php endforeach;?>    
        <form method="POST" enctype="multipart/form-data" class="formulario">
            <fieldset>
                <legend>Información General</legend>
                
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>">
                </div>
                <div>
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo $apellido;?>"> 
                </div>
                <div>
                    <label for="especialidad">Especialidad:</label>
                    <select name="especialidad" id="especialidad">
                        <option value="">Seleccione una especialdiad por Doctor</option>
                        <?php while($row = mysqli_fetch_assoc($resultado)):?>
                            <option value="<?php echo $row['id'];?>" <?php echo $especialidad === $row['id'] ? 'selected': '' ?>> 
                                <?php echo $row['nombre'];?> 
                            </option>
                        <?php endwhile;?>   
                    </select>
                </div>
                <div>
                    <label for="horario">Horario:</label>
                    <input type="text" name="horario" id="horario" value="<?php echo $horario;?>">
                </div>
                <div>
                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" id="foto" accept=".jpg">
                    <img width="150px" src="http://localhost/proyecto/imagenes/<?php echo $foto;?>" alt="IMAGEN">
                </div>

                <button type="submit" class="btn-verde">Actualizar Doctor</button>
            </fieldset>
        </form>
    </main>
</body>

</html>