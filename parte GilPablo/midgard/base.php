<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    //ESTA FUNCIÓN ME DEVUELVE UN OBJETO DE CONEXIÓN A LA BD USANDO PDO
    function conexion(){
        /* ==================================== */
        //AQUI SE DEBEN ESCRIBIR LOS PARAMETROS DE LA BASE DE DATOS
            $id = "localhost"; //192.168.4.231
            $dbName = "midgard";
            $usuario = "root"; //midgard
            $clave = "root"; //midgard
        /* ==================================== */ 
        
        try{
            //HACER LA CONEXIÓN
            $cadenaConexion ="mysql:host=".$id.";dbname=".$dbName;
            $conexion = new PDO($cadenaConexion, $usuario, $clave);

            //HABILITAR ERRORES DE LA BASE DE DATOS (ASI MUESTRA ERRORES DE MYSQL)
            $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //RETORNAR EL OBJETO CREADO
            return $conexion;

        }catch(Exception $e){
            echo "ERROR AL CONECTAR A LA BASE DE DATOS <br>".$e."<br><br>";
            return null;
        }
    }
    
    //ACTIVA LA FUNCIÓN LOGIN
    if(isset($_POST['loginButton'])) {
        login(); 
    }

    function login(){
        //INDICAMOS AL PROGRAMA QUE INICIAMOS UNA SESION
        session_start();

        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();
        //var_dump($con);

        //IGUALAMOS 2 VARIABLES A LO ESCRITO EN LOS FORMULARIOS
        $usuario = $_POST['user'];
        $password = $_POST['clave'];
        

        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM USUARIO where (username = '$usuario' or email = '$usuario') and clave = '$password'";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);
        //var_dump($stm);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();
        var_dump($resultado);

        //ENVIA AL USUARIO A UNA PAGINA U OTRA EN FUNCIÓN DEL RESULTADO DE LA CONSULTA 
        if($resultado){
            //ALMACENAMOS DOS VARIABLES DE TIPO SESION CON EL NOMBRE Y EL ROL DEL USUARIO QUE SE ESTA LOGUEANDO
            $_SESSION['rol'] = $resultado["id_rol"];
            $_SESSION['nombre'] = $resultado["nombre"];
            $_SESSION['id'] = $resultado["username"];
            header("location:index.php");
        }
        else{
            //PREGUNTAR SI SE PUEDE MOSTRAR EL ERROR DE UNA MANERA MÁS BONITA
            
            header("Location: login.php?error=true");
        }
    }

    //GESTIONA LA VISTA DE CADA UNO DE LOS ROLES EN LA WEB 
    function rol(){
        //session_start();
        if(!isset($_SESSION['nombre'])){
            echo "<p class='text-center'>No estas logueado</p>"; 
            echo "<script>noLogin();</script>";
        }
        else if ($_SESSION['rol'] == '1'){//ES EL ID DE ADMIN
            echo "<p class='text-center'>Bienvenido ".$_SESSION['nombre']." tu rol es Admin</p>";
            echo "<script>admin();</script>";
        }
        else if($_SESSION['rol'] == '2'){//ES EL ID DE APROBADOR
            echo "<p class='text-center'>Bienvenido ".$_SESSION['nombre']." tu rol es Aprobador</p>";
            echo "<script>aprobador();</script>";
        }
        else if($_SESSION['rol'] == '3'){//ES EL ID DE PUBLICADOR
            echo "<p class='text-center'>Bienvenido ".$_SESSION['nombre']." tu rol es Publicador</p>";
            echo "<script>publicador();</script>";
        }
    }
    
    //PREGUNTAR COMO LLAMAR A UNA FUNCIÓN PHP DESDE UN BOTÓN HTML O UNA ETIQUETA a Y ASI PODER UTILIZAR ESTA FUNCIÓN
    function cerrarSesion(){
        session_start();
        session_destroy();
        header("location:index.php");
    }


    //REALIZA UNA CONSULTA Y ESCRIBE EN EL DOCUMENTO EL CONTENIDO DE LA MISMA
    function listarPantallas(){
        //include_once "base.php";

        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM PANTALLA";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //RECORRER TODAS LOS VALORES OBTENIDOS
        while ($resultado){
            //MOSTRAMOS LOS DATOS DE LA CONSULTA
            echo '<div class="col-4">';
            echo '<input class="form-check-input" type="checkbox" name="dept'.$resultado["ip"].' id="dept'.$resultado["ip"].'">';
            echo '<label class="form-check-label margin_check" for="flexCheckDefault">'.$resultado["nombre"].' </label><br>';
            echo '</div>';

            //PASAR A LA SIGUIENTE FILA
            $resultado = $stm->fetch();
        }
    }








    if(isset($_POST['userButton'])) {
        insertarUsuario(); 
    }


    function insertarUsuario(){
        

        $conexion = conexion();

        $username = $_POST['username'];
        $clave = $_POST['clave'];
        $nombre = $_POST['fullname'];
        $email = $_POST['email'];
        $dni = $_POST['dni'];
        $id_rol = $_POST['id_rol'];


        $sqlAddUser = "INSERT INTO USUARIO (username, clave, nombre, email, dni, id_rol) VALUES ('$username', '$clave', '$nombre', '$email', '$dni', 1);";
        echo $sqlAddUser;

        $consulta=$conexion->prepare($sqlAddUser);
        $consulta->execute();

        header("location: CRUD_USUARIOS/index.php");
    }

    if(isset($_GET['username'])) {
        eliminarUsuario(); 
    }

    function eliminarUsuario(){

        $conexion = conexion();

        $username = $_GET['username'];

        $sqlDeleteUser = "DELETE FROM USUARIO WHERE username = '$username';";

        $consulta=$conexion->prepare($sqlDeleteUser);
        $consulta->execute();
        
        header("location: CRUD_USUARIOS/index.php");
        

    }



    function insertarPublicacion(){

        //ENLAZAMOS LA SESION PARA PODER UTILIZAR LAS VARIABLES DE SESION
        session_start();
        
        //CONECTAMOS A LA BD
        $con = conexion();
 
        try{
            //REDACTAR COMANDO SQL A EJECUTAR
            $insert = "INSERT INTO PUBLICACION(fechacreacion, titulo, fechaInicio, fechaFin, mensaje, imagen, fechaAprobacion, escritor, aprobador, id) VALUES (:fechacreacion, :titulo, :fechaInicio, :fechaFin, :mensaje, :imagen, :fechaAprobacion, :escritor, :aprobador, :id)";

            //OBTENEMOS LA FECHA ACTUAL
            $hoy = getdate();
            $fechaActual = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
            
             //SOLO SE EJECUTA SI SE HA SUBIDO UNA IMAGEN
            
            if(isset($_FILES['publiImg']['name'])){
                
                //ASIGNAMOS EL NOMBRE DEL ARCHIVO SUBIDO A LA VARIABLE IMG
                $img = $_FILES['publiImg']['name'];
                //echo $img;
                //RECIBIMOS LOS DATOS DE LA IMAGEN
                $nombreImg = $_FILES['publiImg']['name'];
                $tipoImg = $_FILES['publiImg']['type'];
                $sizeImg = $_FILES['publiImg']['size'];

                //if ($sizeImg <=1000000)
                //RUTA DE LA CARPETA DESTINO EN EL SERVIDOR
                $ruta_destino = $_SERVER['DOCUMENT_ROOT'].'/midgard/img/';
                //echo "$ruta_destino";

                //MOVEMOS LA IMAGEN DEL DIRECTORIO TEMPORAL AL DIRECTIORIO ESCOGIDO
                move_uploaded_file($_FILES['publiImg']['tmp_name'], $ruta_destino.$nombreImg);
            }else{
                echo "HOLA";
                $img = NULL;
            }

            //OBTENEMOS VARIABLES EN FUNCIÓN DEL ROL
            if($_SESSION['rol'] == "1" ||  $_SESSION['rol'] == "2"){
               $fechaAprobacion = $fechaActual;
               $aprobador = $_SESSION["id"];
               $estado = "1"; // ACTIVO = 1 
            }else{
                $fechaAprobacion = NULL;
                $aprobador = NULL;
                $estado = "2"; // PENDIENTE = 2
            }

            //LLENAR LOS PARAMETROS DEL COMANDO A EJECUTAR
            $parametros = [
                "fechacreacion" => $fechaActual,
                "titulo" => $_POST["asunto"],
                "fechaInicio" => $_POST["fechaInicio"],
                "fechaFin" => $_POST["fechaFin"],
                "mensaje" => $_POST["mensaje"],
                "imagen" => $img,
                "fechaAprobacion" => $fechaAprobacion,
                "escritor" => $_SESSION["id"],
                "aprobador" => $aprobador,
                "id" => $estado
            ];

            //PREPARAMOS LA EJECUCIÓN DEL COMANDO (VENDRA EN STATEMENT)
            $stm = $con->prepare($insert);

            //LLENAMOS LOS PARAMETROS DEL COMANDO Y LO EJECUTAMOS
            $stm->execute($parametros);

            //CERRAMOS LA CONEXION A LA BD
            $con = null;

            //REGRESAMOS A LA PÁGINA INDEX (PENDIENTE SACAR UN MENSAJE DE APROBACIÓN)
            //header("location: index.php");

        }catch(Exception $e){
           echo "Error al insertar a los datos<br>".$e;
        }
        // // Estructura Insert: https://www.hostinger.es/tutoriales/como-usar-php-para-insertar-datos-en-mysql/
        // // Esto podria ser util: https://www.geeksforgeeks.org/how-to-insert-form-data-into-database-using-php/
        // // Podria utilizarse $_REQUEST['email'] ?¿


        // $safeConexion = conexion();
        // $insertPublicacion = $safeConexion->prepare("INSERT INTO PUBLICACION (fechaCreacion, titulo, fechaInicio, fechaFin, mensaje, imagen, escritor, id) VALUES (fechaCreacion, titulo, fechaInicio, fechaFin, mensaje, imagen, escritor, id)");

        // // La fecha de creacion:
        // $fechaActual = date('Y-m-d');
        // echo $fechaActual;
        // $insertPublicacion->bindParam(fechaCreacion, $fechaActual);
        // $insertPublicacion->bindParam(titulo, $_POST['titulo']);
        // $insertPublicacion->bindParam(fechaInicio, $_POST['fechaInicio']);
        // $insertPublicacion->bindParam(fechaFin, $_POST['fechaFin']);
        // $insertPublicacion->bindParam(mensaje, $_POST['mensaje']);
        // $insertPublicacion->bindParam(imagen, NULL);
        // $insertPublicacion->bindParam(escritor, $_SESSION['id']);
        // $insertPublicacion->bindParam(id, 1);

        // // El nombre de la imagen sera (si la hay, img[numero id_Publicacion])

        // if ($insertPublicacion->execute()) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Unable to create record";
        // }

        // //SOLO SE EJECUTA SI SE HA SUBIDO UNA IMAGEN
        // if (isset($_FILES['publiImg']['name'])){
        //     /* FRACASO TRATANDO DE CONVERTIR EL FORMATO DE LA IMAGEN A WEBP
        //         $file = "$_FILES['publiImg']['name']";
        //         $image = imagecreatefromstring(file_get_contents($file));
        //         ob_start();
        //         imagejpeg($image,NULL,100);
        //         $cont = ob_get_contents();
        //         ob_end_clean();
        //         imagedestroy($image);
        //         $content = imagecreatefromstring($cont);
        //         $output = 'images/output.webp';
        //         imagewebp($content,$output);
        //         imagedestroy($content);
        //     */

        //     //RECIBIMOS LOS DATOS DE LA IMAGEN
        //     $nombreImg = $_FILES['publiImg']['name'];
        //     $tipoImg = $_FILES['publiImg']['type'];
        //     $sizeImg = $_FILES['publiImg']['size'];

        //     //if ($sizeImg <=1000000)
        //     //RUTA DE LA CARPETA DESTINO EN EL SERVIDOR
        //     $ruta_destino = $_SERVER['DOCUMENT_ROOT'].'/Midgard/img/';
        //     echo "$ruta_destino";

        //     //MOVEMOS LA IMAGEN DEL DIRECTORIO REMPORAL AL DIRECTIORIO ESCOGIDO
        //     move_uploaded_file($_FILES['publiImg']['tmp_name'], $ruta_destino.$nombreImg);
        //     $nombreImg = $_FILES['publiImg']['name'];
        //     echo "$nombreImg";
        // }   
    }
?>

