<?php

    /* =============================== */
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    /* =============================== */

    //ESTA FUNCIÓN ME DEVUELVE UN OBJETO DE CONEXIÓN A LA BD USANDO PDO
    function conexion(){
        /* ==================================== */
        //AQUI SE DEBEN ESCRIBIR LOS PARAMETROS DE LA BASE DE DATOS
            $id = "localhost"; //192.168.4.231
            $dbName = "midgard";
            $usuario = "root"; //midgard
            $clave = "root_Root1"; // 
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

        //IGUALAMOS 2 VARIABLES A LO ESCRITO EN LOS FORMULARIOS
        $usuario = $_POST['user'];
        $password = $_POST['clave'];
        
        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM USUARIO where (username = '$usuario' or email = '$usuario') and clave = '$password'";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //ENVIA AL USUARIO A UNA PAGINA U OTRA EN FUNCIÓN DEL RESULTADO DE LA CONSULTA 
        if($resultado){

            //EVITA QUE LOS USUARIOS CON EL ATRIBUTO INACTIVO ENTREN EN LA WEB
            if($resultado["inactivo"] == '1'){
                header("location: ../login.php?inactivo=true");
            }
            //SINO ESTAN INACTIVOS INICIAN SESIÓN
            else{
                 //ALMACENAMOS DOS VARIABLES DE TIPO SESION CON LA INFORMACION DEL USUARIO QUE SE ESTA LOGUEANDO
                $_SESSION['rol'] = $resultado["id_rol"];
                $_SESSION['nombre'] = $resultado["nombre"];
                $_SESSION['email'] = $resultado["email"];
                $_SESSION['dni'] = $resultado["dni"];
                $_SESSION['id'] = $resultado["username"];
                header("location: ../index.php");
            }
        }
        else{
            header("Location: ../login.php?error=true");
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


     //ACTIVA LA FUNCIÓN DE INSERTAR PANTALLA SI SE ENVIA POR POST ALGO DESDE EL BOTÓN 'pantaButton'
    if(isset($_POST['pantaButton'])) {
        insertarPantalla(); 
    }

    function insertarPantalla(){
        //CONECTAMOS A LA BD
        $con = conexion();
 
        try{
            //REDACTAR COMANDO SQL A EJECUTAR
            $insert = "INSERT INTO PANTALLA(mac_pantalla, ubicacion, nombre) VALUES (:mac_pantalla, :ubicacion, :nombre)";

            //LLENAR LOS PARAMETROS DEL COMANDO A EJECUTAR
            $parametros = [
                "mac_pantalla" => $_POST["mac"],
                "ubicacion" => $_POST["ubicacion"],
                "nombre" => $_POST["nombre"]
            ];

            //PREPARAMOS LA EJECUCIÓN DEL COMANDO (VENDRA EN STATEMENT)
            $stm = $con->prepare($insert);

            //LLENAMOS LOS PARAMETROS DEL COMANDO Y LO EJECUTAMOS
            $stm->execute($parametros);

            //CERRAMOS LA CONEXION A LA BD
            $con = null;

            //REGRESAMOS A LA PÁGINA INDEX (PENDIENTE SACAR UN MENSAJE DE APROBACIÓN)
            header("location: ../index.php");

        }catch(Exception $e){
           echo "Error al insertar a los datos<br>".$e;
        }
    }
    
    //LLAMA A INSERTAR USUARIO SI SE PULSO USERBUTTON
    if(isset($_POST['userButton'])) {
        insertarUsuario(); 
    }

    //INSERTAR USUARIO EN LA BASE DE DATOS
    function insertarUsuario(){
        $conexion = conexion();

        if (noRepetidos($_POST['username'], $_POST['email'])){
            $username = $_POST['username'];
            $clave = $_POST['clave'];
            $nombre = $_POST['fullname'];
            $email = $_POST['email'];
            $dni = $_POST['dni'];
            $id_rol = $_POST['rol'];

            $sqlAddUser = "INSERT INTO USUARIO (username, clave, nombre, email, dni, inactivo, id_rol) VALUES ('$username', '$clave', '$nombre', '$email', '$dni', '0', '$id_rol');";

            $consulta=$conexion->prepare($sqlAddUser);
            $consulta->execute();
            $conexion = null; //CERRAMOS LA CONEXION DE LA BD

            //REDIRECCIONAMOS
            header("location: ../index.php");
        }else{
            $conexion = null;
            header("location: ../index.php?repetidos=true"); //COLOCAR UN ALETRT (EMAIL O USUARIO YA REGISTRADOS EN LA BD) AQUI MIRAR LA MANERA DE RELLENAR LOS CAMPOS NUEVAMENTE AL RECARGAR LA WEB
        }
    }

    //FUNCIÓN AUXILIAR QUE VERIFICA SI EL USERNAME O EL CORREO ELECTRONICO YA ESTAN EN LA BASE DE DATOS
    function noRepetidos($username, $email){
        $con = conexion();

        $consulta = "SELECT username, email FROM USUARIO WHERE username = '$username' or email = '$email'";
        echo "$consulta";

        $stm = $con->query($consulta);
        $resultado = $stm->fetch();
        $con = null;

        if (!$resultado){
            return true;
        }else{
            return false;
        }
    }

    //ACTIVA LA FUNCIÓN DE INSERTAR PUBLICACIÓN SI SE ENVIA POR POST ALGO DESDE EL BOTÓN 'publiButton'
    if(isset($_POST['publiButton'])) {
        insertarPublicacion(); 
    }

    //INSERTA UNA PUBLICACIÓN CON SUS CORRESPONDIENTES DATOS EN LA TABLA M:N
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
            if($_FILES['publiImg']['name'] != ""){

                //RECIBIMOS LOS DATOS DE LA IMAGEN
                $nombreImg = $_FILES['publiImg']['name'];
                $tipoImg = $_FILES['publiImg']['type'];
                $sizeImg = $_FILES['publiImg']['size'];

                //RUTA DE LA CARPETA DESTINO EN EL SERVIDOR
                $ruta_destino = $_SERVER['DOCUMENT_ROOT']."/img/userImage/";

                //MOVEMOS LA IMAGEN DEL DIRECTORIO TEMPORAL AL DIRECTIORIO ESCOGIDO
                move_uploaded_file($_FILES['publiImg']['tmp_name'], $ruta_destino.$nombreImg);

                //SOLO SE EJECUTA SI EL ARCHIVO SUBIDO ES UN PDF
                if ($tipoImg == "application/pdf"){
                    //MODIFICAMOS EL NOMBRE DE LA VARIABLE IMG
                    $img = substr($nombreImg, 0, -3)."png"; 

                    //INDICAMOS LA RUTA EN LA QUE ESTA EL PDF Y LA PAGINA QUE QUEREMOS CONVERTIR
                    $url = $ruta_destino.$nombreImg.'[0]';

                    //PARA CONVERTIR UN PDF A IMAGEN

                    //CREAMOS UN OBJETO DE LA BIBLIOTECA IMAGICK
                    $image = new Imagick();
                    //ESTABLECEMOS SU RESOLUCIÓN
                    $image-> setResolution(300, 300);
                    //LEE EL ARCHIVO EN LA RUTA QUE LE INDICAMOS
                    $image->readImage($url);
                    //ESTABLECEMOS EL FORMATO QUE QUEREMOS PARA LA IMAGEN
                    $image->setImageFormat( "png" );
                    //COMPRIMIMOS EL TAMAÑO DE LA IMGAEN LO MAXIMO POSIBLE
                    $image->setImageCompression(imagick::COMPRESSION_JPEG); 
                    $image->setImageCompressionQuality(100);
                    //CONVERTIMOS EL PDF A IMAGEN
                    $image->writeImage($ruta_destino.$img);
                    //LIMPIAMOS Y ELIMINAMOS ELL OBJETO CREADO PARA EVITAR DEJAR PROCESOS SUELTOS EN EL SERVIDOR
                    $image->clear();
                    $image->destroy();
                    //ELIMINAMOS EL PDF PARA DEJAR SOLO LA IMAGEN CONVERTIDA
                    unlink($ruta_destino.$nombreImg);
                }else{
                    $img = $nombreImg;
                }
            }else{
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
            $stm = $con -> prepare($insert);

            //LLENAMOS LOS PARAMETROS DEL COMANDO Y LO EJECUTAMOS
            $stm -> execute($parametros);
            
            //CREAMOS STRING QUE PASAREMOS A OTRA FUNCION
            $consulta = "SELECT max(id_publicacion) AS ultimo FROM PUBLICACION";

            //LLAMAMOS A LA FUNCIÓN QUE ME OBTIENE EL ID_PUBLICACIÓN
            $id_publicacion = idPubli($consulta);

            //INSERT M:N (PANTALLA_PUBLICACION)
            for ($i = 1; $i <= $_SESSION['numPantallas']; $i++){
                //SI SE MARCO LA PANTALLA HACEMOS UN INSERT EN LA TABLA M:N QUE REFERENCIE LA PANTALLA CON LA PUBLICACIÓN
                if (isset($_POST['pantalla'.$i])){
                    $pantalla = $_POST['pantalla'.$i];
                    $insert2 = "INSERT INTO PANTALLA_PUBLICACION(id_publicacion, mac_pantalla) VALUES ('$id_publicacion', '$pantalla')";
                    $MN = $con -> prepare($insert2);
                    $MN -> execute();
                }
           }

            //CERRAMOS LA CONEXION A LA BD
            $con = null;

            //REGRESAMOS A LA PÁGINA INDEX (PENDIENTE SACAR UN MENSAJE DE APROBACIÓN)
            header("location: ../index.php");

        }catch(Exception $e){
           echo "Error al insertar a los datos<br>".$e;
        }
    }

    //FUNCION AUXILIAR DE INSERTPUBLICACION() QUE HACE UNA CONSULTA Y BUSCA LOS DATOS DE LA PUBLICACIÓN MÁS RECIENTE
    function idPubli($consulta){
        $con = conexion();
        $stm = $con->query($consulta);
        $resultado = $stm->fetch();

        if ($resultado){
            $id_publicacion = $resultado['ultimo'];
            $con = null;
            return $id_publicacion;
        }
    }

    //RESTRINGE LA VISUALIZACIÓN DE LISTAS SEGUN EL ROL
    function permisosListas(){
        session_start();
        //echo $_SESSION['rol'];

        if ($_SESSION['rol'] == '3'){
            header('location: ../index.php');
        }
    }

    // FUNCION PARA COGER IMAGENES -> CAROUSEL

    // FUNCION PARA COGER IMAGENES -> CAROUSEL

    function getImagen(){

        $select = "SELECT fechaInicio, fechaFin, imagen FROM PUBLICACION";
                    //ESPERAR AL PROCEDURE DE MARIO

        $con = conexion();
        $stm = $con->query($select);
        $resultado = $stm->fetch_assoc();


        $fechainicio = $resultado['fechaInicio'];
        $fechafin = $resultado['fechaFin'];
        $imagen = $resultado['imagen'];

        foreach ($resultado as $row) {
            if ($fechainicio>=NOW() && $fechafin<=NOW()) {

                // return echo "<div class='carousel-item active'>
                //                 <img src='img/"+$imagen+"' class='d-block mx-auto'>
                //             </div>"

            } 
        }
    
    }
?>

