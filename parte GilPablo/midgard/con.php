<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['publiButton'])) {
        insertPublicacion(); 
    }
    function insertPublicacion(){
 
        //SOLO SE EJECUTA SI SE HA SUBIDO UNA IMAGEN
        if (isset($_FILES['publiImg']['name'])){
 
            //RECIBIMOS LOS DATOS DE LA IMAGEN
            $nombreImg = $_FILES['publiImg']['name'];
            $tipoImg = $_FILES['publiImg']['type'];
            $sizeImg = $_FILES['publiImg']['size'];
 
            //if ($sizeImg <=1000000)
            //RUTA DE LA CARPETA DESTINO EN EL SERVIDOR
            $ruta_destino = $_SERVER['DOCUMENT_ROOT'].'/midgard/img';
            echo "$ruta_destino";
 
            //MOVEMOS LA IMAGEN DEL DIRECTORIO REMPORAL AL DIRECTIORIO ESCOGIDO
            
            move_uploaded_file($_FILES['publiImg']['tmp_name'], $ruta_destino.$nombreImg);
            chmod($_SERVER['DOCUMENT_ROOT'].$nombreImg, 0777);

            echo 'Se ha subido correctamente la imagen.';
            echo '<img src="'.$ruta_destino.$nombreImg.'">';
        }
    }
?>