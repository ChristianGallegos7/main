<?php
    include "../templates/header.php";
    //base de datos
    include "../../includes/config/database.php";

    $conexion = conectarDb();

    //seleccionar la especialidad 
    $query = "SELECT * FROM tbl_especialidades";
    $resultado = mysqli_query($conexion,$query);
    //arreglo de errores
    $errores = [];

    $nombre = '';
    $apellido = '';
    $especialidad = '';
    $horario = '';
    $foto = '';

    

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

        if(!$foto['name']){
            $errores[] = "La foto es requerida";
        }

        if(empty($errores)){

            //SUBIR ARCHIVOS

            //CREEAAMOS LAA CARPETAA
            $carpetaImagenes = "../../imagenes/";

            //si la carpeta no existe la crea
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }
            //Generar un nombre unico para cada imagen
            $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
            //subir la imagen
            move_uploaded_file($foto['tmp_name'], $carpetaImagenes . $nombreImagen);

            //query para insertarwd
            $doctor = "INSERT INTO tbl_doctores(nombre,apellido,especialidad,horario,foto) VALUES('$nombre','$apellido','$especialidad','$horario', '$nombreImagen')";

            //insertar en la base
            $result = mysqli_query($conexion,$doctor);

            if($result){
                //redireccionar si se inserto correctamente el doctor en la base de datos
                //mandamos el parametro resultado para crear la alerta desde el index
                header('Location: index.php?resultado=1');
            }
        }
    }

    //cerrar la conexion
    mysqli_close($conexion);
?>
    <main>
        <h1>Crear Doctor</h1>

        <?php foreach($errores as $error):?>
            <div>
                <?php echo $error;?>
            </div>
        <?php endforeach;?>   
        
        <h3 style="color: #000;">
        <a href="http://localhost/proyecto/admin/doctores/index.php">Volver</a>

        </h3>
        
        <form action="" method="POST" enctype="multipart/form-data" class="formulario">
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
                    <input type="file" name="foto" id="foto" accept=".jpg, .png" value="<?php echo $foto;?>">
                </div>

                <button type="submit" class="btn-verde">Añadir Doctor</button>
            </fieldset>
        </form>
    </main>
</body>

</html>