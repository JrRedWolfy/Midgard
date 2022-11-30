<?php

        session_start();

        include "php/base.php";

        $conexion = conexion();


        if(isset($_POST['guardar'])){
      
            $id_publicacion = $_GET['id_publicacionEdit'];
            $titulo = $_POST['titulo'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
            $mensaje = $_POST['mensaje'];

            if($_FILES['imagen']['name'] != ""){
                
                //ASIGNAMOS EL NOMBRE DEL ARCHIVO SUBIDO A LA VARIABLE IMG
                $imagen = $_FILES['imagen']['name'];
                //echo $img;
                //RECIBIMOS LOS DATOS DE LA IMAGEN
                $nombreImg = $_FILES['imagen']['name'];
                $tipoImg = $_FILES['imagen']['type'];
                $sizeImg = $_FILES['imagen']['size'];

                //if ($sizeImg <=1000000)
                //RUTA DE LA CARPETA DESTINO EN EL SERVIDOR
                $ruta_destino = $_SERVER['DOCUMENT_ROOT'].'/img/userImage/';
                //echo "$ruta_destino";

                //MOVEMOS LA IMAGEN DEL DIRECTORIO TEMPORAL AL DIRECTIORIO ESCOGIDO
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino.$nombreImg);
                
                $sqlEditPubli = "UPDATE PUBLICACION SET titulo = '$titulo', fechaInicio = '$fechaInicio', fechaFin = '$fechaFin', mensaje = '$mensaje', imagen = '$imagen' WHERE id_publicacion = '$id_publicacion';";

                $consulta=$conexion->prepare($sqlEditPubli);
                $consulta->execute();

                header("location: listaPublicaciones.php");
            }else{
                $imagen = NULL;

                $sqlEditPubli = "UPDATE PUBLICACION SET titulo = '$titulo', fechaInicio = '$fechaInicio', fechaFin = '$fechaFin', mensaje = '$mensaje' WHERE id_publicacion = '$id_publicacion';";

                $consulta=$conexion->prepare($sqlEditPubli);
                $consulta->execute();

                header("location: listaPublicaciones.php");
            }
            
            

        }elseif (isset($_POST['volver'])) {
            header("location: listaPublicaciones.php");
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicaciones</title>
    <!-- FONTAWESOME LIBRARY -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    
<h1>EDITAR PUBLICACION</h1>
    <form method="post" enctype="multipart/form-data">
    
        <label for="titulo" >Titulo</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $_GET['tituloEdit']; ?>" required><br><br>

        <label for="fechaInicio">Fecha Inicio</label>
        <input type="date"  name="fechaInicio" id="fechaInicio" value="<?php echo $_GET['fechaInicioEdit']; ?>"  required><br><br>

        <label for="fechaFin">Fecha Fin</label>
        <input type="date"  name="fechaFin" id="fechaFin" value="<?php echo $_GET['fechaFinEdit']; ?>" min="<?php echo $_GET['fechaInicioEdit']; ?>" required><br><br>

        <label for="mensaje" >Mensaje</label> <br>
        <textarea type="textarea" id="mensaje" name="mensaje" rows="8" cols="100" required><?php echo $_GET['mensajeEdit']; ?></textarea><br><br>

        <label >Imagen</label><br><br>
        <?php 
            if ($_GET['imagenEdit'] == "") { ?>
                
                <label for="upload">
                    
                    <img style="display:none" width="200" height="250" id="output"/>
                    <p id="modificarImg" style="display:none" class="border">Modificar imagen</p>
                    <input type="file" accept="image/png,image/jpeg" name="imagen" id="upload" onchange="loadFile(event)"> 
                       
                </label><br><br>

            <?php }else { ?>
                <img src="img/userImage/<?php echo $_GET['imagenEdit'] ?>" width="200" height="250" id="output"/>
                <label for="upload">
                    <p class="border">Modificar imagen</p>
                    <input type="file" accept="image/png,image/jpeg" name="imagen" id="upload" style="display:none" onchange="loadFile(event)">    
                </label><br><br>
                
                <p onclick="borrarImagen()"><button id="Borrar foto"> Borrar imagen</button></p><br><br>
            <?php }
        
            
        ?>
        

        <input type='submit' name='guardar' value='GUARDAR CAMBIOS' id='guardar'>
        <input type='submit' name='volver' value='VOLVER' id='volver'>


    </form>

    <!-- PREVIEW DE LA IMAGEN CARGADA -->
    <script>
        
        var loadFile = function(event) {
            var output = document.getElementById('output');
            var modificarImg = document.getElementById('modificarImg');
            var upload = document.getElementById('upload');

            output.style.display="";
            modificarImg.style.display="";
            upload.style.display="none";

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
    <script src="../js/script.js"></script>

</body>
</html>