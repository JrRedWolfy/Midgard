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
            $clave = "Salamence!3"; //midgard
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
                header("location: login.php?inactivo=true");
            }
            //SINO ESTAN INACTIVOS INICIAN SESIÓN
            else{
                 //ALMACENAMOS DOS VARIABLES DE TIPO SESION CON LA INFORMACION DEL USUARIO QUE SE ESTA LOGUEANDO
                $_SESSION['rol'] = $resultado["id_rol"];
                $_SESSION['nombre'] = $resultado["nombre"];
                $_SESSION['email'] = $resultado["email"];
                $_SESSION['dni'] = $resultado["dni"];
                $_SESSION['id'] = $resultado["username"];
                header("location:index.php");
            }
        }
        else{
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

    // REALIZA EL LISTADO DE PANTALLAS EN LA VENTANA CORRESPONDIENTE
    function listPantalla(){
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
        
            echo '<div class="mt-5 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">';
                echo '<div class="elemento">';
                    echo '<div class="lateral">';
                        echo '<div class="pc">';
                            echo '<i class="fa fa-desktop"></i>';
                        echo '</div>';
                        echo '<div class="botones">';
                            echo '<button class="boton red onRed" title="Eliminar" name="'.$resultado["mac_pantalla"].'"><i class="fa-solid fa-trash-can"></i></button><button class="boton blue onBlue" title="Editar"><i class="fa-solid fa-pencil"></i></button>';
                        echo '</div>';
                    echo '</div>';
        
                    echo '<div class="nombre">';
                        echo '<h3>'.$resultado["nombre"].'</h3>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            //PASAR A LA SIGUIENTE FILA
            $resultado = $stm->fetch();
        }

    }

    function listUsers(){
        //include_once "base.php";

        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM USUARIO";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //RECORRER TODAS LOS VALORES OBTENIDOS
        while ($resultado){
            //MOSTRAMOS LOS DATOS DE LA CONSULTA

            echo '<div class="mt-5 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">';
                echo '<div class="elemento">';
                    echo '<div class="lateral">';
                        echo  '<a href="#" data-bs-toggle="modal" data-bs-target="#modalUsuario">';
                            echo '<div id="'.$resultado["username"].'" class="face" onclick="ajaxUser(this);">';
                                echo '<i class="fa fa-user"></i>';
                            echo '</div>';
                        echo '</a>';
                        echo '<div class="botones">';
                            echo '<button class="boton red onRed" title="Eliminar" name="'.$resultado["username"].'"><i class="fa-solid fa-trash-can"></i></button><button class="boton blue onBlue" title="Editar" name="'.$resultado["username"].'"><i class="fa-solid fa-pencil"></i></button>';
                        echo '</div>';
                    echo '</div>';
        
                    echo '<div class="nombre">';
                        echo '<h3>'.$resultado["username"].'</h3>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            //PASAR A LA SIGUIENTE FILA
            $resultado = $stm->fetch();
        }
    }

    //   !!!    AJAX USUARIOS    !!!

    $data = ["success"=>false];
    $_POST = json_decode(file_get_contents('php://input'), true); //DECODIFICAMOS LA INFORMACIÓN RECIBIDA DE JAVASCRIPT
    if (isset($_POST['texto'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        ajaxUser();
    }

    function ajaxUser(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $username = $_POST['texto']; 

        //HACEMOS LA CONSULTA EN LA BASE DE DATOS UTILIZANDO LA VARIABLE ENVIADA EN JAVASCRIPT
        $con = conexion();
        $consulta="SELECT * FROM USUARIO WHERE username = '$username'";
        $stm = $con->query($consulta);
        $resultado = $stm->fetch();
         
        //ALMACENAMOS EN UN ARRAY ASOCIATIVO EL RESULTADO DE LA CONSULTA

        $cont=0;
        while ($resultado){
        $datos[$cont] = [
            'username' => $resultado['username'], 
            'clave' => $resultado['clave'], 
            'nombre' => $resultado['nombre'], 
            'email' => $resultado['email'], 
            'dni' => $resultado['dni'], 
            'inactivo' => $resultado['inactivo'], 
            'id_rol' => $resultado['id_rol']
            ];
        $cont++;
        $resultado = $stm->fetch();

        }

        $data = ["success"=>true,'usuario' => $datos];
        
        die(json_encode($data));
    }



    function listNews(){
        //include_once "base.php";

        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM PUBLICACION";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //RECORRER TODAS LOS VALORES OBTENIDOS
        while ($resultado){
            //MOSTRAMOS LOS DATOS DE LA CONSULTA
        
            echo '<div class="mt-5 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">';
                echo '<div class="elemento">';
                    echo '<div class="lateral">';
                        echo '<div class="botones">';
                            echo '<button class="boton red onRed" title="Eliminar" name="'.$resultado["id_publicacion"].'"><i class="fa-solid fa-trash-can"></i></button><button class="boton blue onBlue" title="Editar" name="'.$resultado["id_publicacion"].'"><i class="fa-solid fa-pencil"></i></button>';
                        echo '</div>';

                        echo '<div class="news">';
                            echo '<i class="fa-solid fa-newspaper"></i>';
                        echo '</div>';
                        
                        echo '<div class="botones">';
                            echo '<button class="boton red onRed" title="Eliminar" name="'.$resultado["id_publicacion"].'"><i class="fa-solid fa-trash-can"></i></button><button class="boton blue onBlue" title="Editar" name="'.$resultado["id_publicacion"].'"><i class="fa-solid fa-pencil"></i></button>';
                        echo '</div>';
                        
                    echo '</div>';
        
                    echo '<div class="nombre">';
                        echo '<h3>'.$resultado["titulo"].'</h3>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            //PASAR A LA SIGUIENTE FILA
            $resultado = $stm->fetch();
        }
    }


    //REALIZA UNA CONSULTA Y ESCRIBE EN EL DOCUMENTO EL CONTENIDO DE LA MISMA
    function checkboxPantallas(){
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
        $cont=1;
        while ($resultado){
            //MOSTRAMOS LOS DATOS DE LA CONSULTA
            echo '<div class="col-4">';
            echo '<input class="form-check-input" type="checkbox" name="pantalla'.$cont.'" value="'.$resultado["mac_pantalla"].'">';
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

    function misMensajes(){
        //include_once "base.php";

        session_start();
        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        $id = $_SESSION["id"];
        //REALIZAMOS LA CONSULTA FILTRADA POR USUARIO
        $consulta="SELECT * FROM PUBLICACION WHERE escritor = '$id'";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //RECORRER TODAS LOS VALORES OBTENIDOS
        $cont=1;

        if ($resultado){
            while ($resultado){
            
                //MOSTRAMOS LOS DATOS DE LA CONSULTA
                echo '<div class="col-4">';
                echo '<input class="form-check-input" type="checkbox" name="publicacion'.$cont.'" id= mensaje"'.$resultado["id_publicacion"].'">';
                echo '<label class="form-check-label margin_check" for="flexCheckDefault">'.$resultado["titulo"].' </label><br>';
                echo '</div>';
    
                //PASAR A LA SIGUIENTE FILA
                $cont++;
                $resultado = $stm->fetch();
            }
        } else {
            echo '<h1>Todavía no has escrito ningun mensaje</h1>';
        }

        
    }

    function takeUsernames(){

        $con = conexion();

        //REALIZAMOS LA CONSULTA FILTRADA POR USUARIO
        $consulta="SELECT username FROM USUARIO";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        $names = $stm->fetchAll();

        return $names;
    }

    function miPerfil(){
        session_start();
        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        $id = $_SESSION["id"];
        //REALIZAMOS LA CONSULTA FILTRADA POR USUARIO
        $consulta="SELECT * FROM USUARIO WHERE username = '$id'";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        $resultado = $stm->fetch();

        echo '<div>';
        echo '';//AGREGAR ICONOS DE USUARIO?
        echo '<h2>'.$resultado["username"].' </h2>';//NOMBRE DE USUARIO
        echo '';//NUMERO DE MENSAJES ESCRITOS
        echo '';//ROL
        echo '';//BOTON EDITAR PERFIL
        echo '</div>';

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        



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
            header("location: index.php");

        }catch(Exception $e){
           echo "Error al insertar a los datos<br>".$e;
        }
    }

     // ELIMINAR PANTALLA SI SE PULSA EL BOTON DELETEPANTALLA 
    if(isset($_POST['deletePantalla'])) {
        eliminarPantalla(); 
    }

    //ELIMINAR USUARIO DE LA BASE DE DATOS
    function eliminarPantalla(){

        $conexion = conexion();

        $mac = $_POST['deletePantalla'];

        $sqlDeletePantalla = "DELETE FROM PANTALLA WHERE mac_pantalla = '$mac';";

        $consulta=$conexion->prepare($sqlDeletePantalla);
        $consulta->execute();
        
        header("location: listaPantallas/index.php");

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
            header("location: index.php");
        }else{
            $conexion = null;
            header("location: index.php?repetidos=true"); //COLOCAR UN ALETRT (EMAIL O USUARIO YA REGISTRADOS EN LA BD) AQUI MIRAR LA MANERA DE RELLENAR LOS CAMPOS NUEVAMENTE AL RECARGAR LA WEB
        }
    }

    // ELIMINAR USUARIO SI SE PULSA EL BOTON DELETEUSER 
    if(isset($_POST['deleteUser'])) {
        eliminarUsuario(); 
    }

    //ELIMINAR USUARIO DE LA BASE DE DATOS
    function eliminarUsuario(){

        $conexion = conexion();

        $username = $_POST['username'];

        $sqlDeleteUser = "DELETE FROM USUARIO WHERE username = '$username';";

        $consulta=$conexion->prepare($sqlDeleteUser);
        $consulta->execute();
        
        header("location: CRUD_USUARIOS/index.php");

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
            echo $id_publicacion;

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
            header("location: index.php");

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
            header('location: index.php');
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

