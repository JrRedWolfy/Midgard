<?php

    /* =============================== */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    /* =============================== */

    //ESTA FUNCIÓN ME DEVUELVE UN OBJETO DE CONEXIÓN A LA BD USANDO PDO
    function conexion(){
        /* ==================================== */
        //AQUI SE DEBEN ESCRIBIR LOS PARAMETROS DE LA BASE DE DATOS
            $id = "192.168.4.231"; //192.168.4.231
            $dbName = "midgard";
            $usuario = "midgard"; //midgard
            $clave = "midgard"; // 
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

        $consultaclave ="SELECT clave FROM USUARIO where (username = '$usuario' or email = '$usuario')";

        $stm = $con->query($consultaclave);
        
        $resultado = $stm->fetch();

        $hashbd = $resultado['clave'];

        $verificar = password_verify($password, $hashbd);

        if ($verificar) { //REALIZAMOS LA CONSULTA

            $consulta="SELECT * FROM USUARIO where (username = '$usuario' or email = '$usuario') and clave = '$hashbd'";

        }    else {

            $consulta="SELECT * FROM USUARIO where (username = '123' or email = '123') and clave = '123'";

        }


        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //ENVIA AL USUARIO A UNA PAGINA U OTRA EN FUNCIÓN DEL RESULTADO DE LA CONSULTA 
        if($resultado){

            //EVITA QUE LOS USUARIOS CON EL ATRIBUTO INACTIVO ENTREN EN LA WEB
            if($resultado["inactivo"] == '1'){
                header("location: ../login?inactivo=true");
            }
            //SINO ESTAN INACTIVOS INICIAN SESIÓN
            else{
                //ALMACENAMOS DOS VARIABLES DE TIPO SESION CON LA INFORMACION DEL USUARIO QUE SE ESTA LOGUEANDO
                $_SESSION['rol'] = $resultado["id_rol"];
                $_SESSION['nombre'] = $resultado["nombre"];
                $_SESSION['email'] = $resultado["email"];
                $_SESSION['dni'] = $resultado["dni"];
                $_SESSION['id'] = $resultado["username"];
                header("location: ../inicio");
            }
        }
        else{
            header("Location: ../login?error=true");
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

    function isPantalla(){
         //IP Cliente
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        // echo "La ip del cliente es: ".$ip_cliente."<br>";
        
        //MAC PANTALLA
        $comando= shell_exec("arp -a ".$ip_cliente);
        $separador = explode(" ", $comando);
        
        $mac_cliente = $separador[3];

        echo "La mac del cliente es: ".$mac_cliente."<br>";

        //BUCAMOS LA MAC EN LA BASE DE DATOS
        $con = conexion();
        $consulta="SELECT mac_pantalla FROM PANTALLA WHERE mac_pantalla = '$mac_cliente'";
        $stm = $con->query($consulta);
        $resultado = $stm->fetch();
        
        if($resultado){
            header("location: pantalla.php");
        }
    }

    //REALIZA UNA CONSULTA Y ESCRIBE EN EL DOCUMENTO EL CONTENIDO DE LA MISMA
    function checkboxPantallas(){
        //include_once "base.php";

        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM PANTALLA WHERE mac_pantalla != '00:00:00:00:00:00'";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //RECORRER TODAS LOS VALORES OBTENIDOS
        $cont=1;
        while ($resultado){
            //MOSTRAMOS LOS DATOS DE LA CONSULTA
            echo '<div class="col-4">';
            echo '<input class="form-check-input checkPantalla" type="checkbox" name="pantalla'.$cont.'" value="'.$resultado["mac_pantalla"].'">';
            echo '<label class="form-check-label margin_check" for="flexCheckDefault">'.$resultado["nombre"].'</label><br>';
            echo '</div>';

            //PASAR A LA SIGUIENTE FILA
            $cont++;
            $resultado = $stm->fetch();
        }
        $cont--;

        //ALMACENAMOS EN UNA VARIABLE SUPERGLOBAL EL NÚMERO DE PANTALLAS
        $_SESSION['numPantallas'] = $cont;
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
            header("location: ../inicio");

        }catch(Exception $e){
           echo "Error al insertar a los datos<br>".$e;
        }
    }

    //ELIMINAR PANTALLA

    
    
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

            $clavehash = password_hash($clave, PASSWORD_DEFAULT);

            $sqlAddUser = "INSERT INTO USUARIO (username, clave, nombre, email, dni, inactivo, id_rol) VALUES ('$username', '$clavehash', '$nombre', '$email', '$dni', '0', '$id_rol');";

            $consulta=$conexion->prepare($sqlAddUser);
            $consulta->execute();
            $conexion = null; //CERRAMOS LA CONEXION DE LA BD

            //REDIRECCIONAMOS
            header("location: ../inicio");
        }else{
            $conexion = null;
            header("location: ../inicio?repetidos=true"); //COLOCAR UN ALERT (EMAIL O USUARIO YA REGISTRADOS EN LA BD) AQUI MIRAR LA MANERA DE RELLENAR LOS CAMPOS NUEVAMENTE AL RECARGAR LA WEB
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
            for ($i = 0; $i <= $_SESSION['numPantallas']; $i++){
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
            header("location: ../inicio");

        }catch(Exception $e){
           echo "Error al insertar a los datos<br>".$e;
        }
    }


    //FUNCION APROBAR UNA NOTICIA
    

    if(isset($_POST['AprobarNewsBtn'])) {
        aproveNew();
    }

    function aproveNew(){

        session_start();

        $id = $_POST['aprobado'];
        $con = conexion();

        $hoy = getdate();
        $fechaActual = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];

        $consulta ="UPDATE PUBLICACION SET id='1', fechaAprobacion='".$fechaActual."', aprobador='".$_SESSION['id']."' WHERE id_publicacion='$id'";

        $con->query($consulta);
        $con = null;

        header("location: publicaciones");
    }


     //FUNCION RECHAZAR UNA NOTICIA
    if(isset($_POST['rechazarNewsBtn'])) {
        rechazarNew();
    }

    function rechazarNew(){

        $id = $_POST['rechazado'];
        $motivo = $_POST['motivo'];
        $con = conexion();

        if ($motivo == ""){
            $motivo = "No Cualifica";
        }

        $consulta ="UPDATE PUBLICACION SET id='3', motivo='".$motivo."' WHERE id_publicacion='$id'";

        $con->query($consulta);
        $con = null;

        header("location: publicaciones");
    }

    
    //FUNCION ELIMINAR PUBLICACION
    if(isset($_POST['deleteNewsBtn'])) {
        deleteNew();
    }

    function deleteNew(){

        $id = $_POST['id'];
        $con = conexion();


        $consulta ="DELETE FROM PUBLICACION WHERE id_publicacion='$id'";
        
        $con->query($consulta);
        $con = null;

        header("location: ../publicaciones");
    }

    if(isset($_GET['id_publicacion'])) {
        deletePublicaGet();
    }

    function deletePublicaGet(){

        $id = $_GET['id_publicacion'];
        $con = conexion();

        $consulta ="DELETE FROM PUBLICACION WHERE id_publicacion = $id;";

        $con->query($consulta);
        $con = null;

        header("location: ../publicaciones");
    }



    //FUNCION ELIMINAR USUARIO
    if(isset($_POST['deleteUserBtn'])) {
        deleteUser();
    }

    function deleteUser(){

        $id = $_POST['id'];
        $con = conexion();

        $consulta ="DELETE FROM USUARIO WHERE username='$id'";

        echo $consulta;
        $con->query($consulta);
        $con = null;

        header("location: ../usuarios");
    }

    //FUNCION DESHABILITAR USUARIO
    if(isset($_POST['deshabilitarUser'])) {
        inhibiteUser();
    }

    function inhibiteUser(){

        $id = $_POST['id'];
        $con = conexion();

        $consulta ="SELECT inactivo FROM USUARIO WHERE username='$id'";
        $stm = $con->query($consulta);
        $n = $stm->fetch();

        if($n['inactivo'] == 1){
            $consulta ="UPDATE USUARIO SET inactivo='0' WHERE username='$id'";
        } else{
            $consulta ="UPDATE USUARIO SET inactivo='1' WHERE username='$id'";
        }

        $con->query($consulta);
        $con = null;

        header("location: ../usuarios");
    }


    //FUNCION ELIMINAR PANTALLA
    if(isset($_POST['deletePantallaBtn'])) {
        deletePantalla();
    }

    function deletePantalla(){

        $id = $_POST['id'];
        $con = conexion();

        $consulta ="DELETE FROM PANTALLA WHERE mac_pantalla='$id'";

        $con->query($consulta);
        $con = null;

        header("location: ../pantallas");
    }

    if(isset($_GET['mac_pantalla'])) {
        deletePantallaGet();
    }

    function deletePantallaGet(){

        $id = $_GET['mac_pantalla'];
        $con = conexion();

        $consulta ="DELETE FROM PANTALLA WHERE mac_pantalla='$id'";

        $con->query($consulta);
        $con = null;

        header("location: ../pantallas");
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

    //LISTA PUBLICAIONES POR DEFECTO
    function porDefecto(){
        $con = conexion();
        $porDefecto = "SELECT * FROM  PUBLICACION, PANTALLA_PUBLICACION WHERE PANTALLA_PUBLICACION.mac_pantalla='00:00:00:00:00:00' and PANTALLA_PUBLICACION.id_publicacion = PUBLICACION.id_publicacion";
        $stm2 = $con->query($porDefecto);
        $publicacion = $stm2->fetchAll();
        $con = null;
        return $publicacion;
    }

    //RESTRINGE LA VISUALIZACIÓN DE LISTAS SEGUN EL ROL
    function permisosListas(){

        session_start();
        //echo $_SESSION['rol'];

        if ($_SESSION['rol'] == '3'){
            header('location: ../inicio');
        }

    }

    function misMensajes() {

        $con = conexion();

        $mispublicaciones = "SELECT * FROM PUBLICACION WHERE ID";
        
    }

?>

