<?php
    //ESTA FUNCIÓN ME DEVUELVE UN OBJETO DE CONEXIÓN A LA BD USANDO PDO
    function conexion(){
        /* ==================================== */
        //AQUI SE DEBEN ESCRIBIR LOS PARAMETROS DE LA BASE DE DATOS
            $id = "localhost"; //192.168.4.231
            $dbName = "midgard";
            $usuario = "root"; //midgard
            $clave = "1605"; //midgard
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
        $consulta="SELECT * FROM usuario where (username = '$usuario' or email = '$usuario') and clave = '$password'";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);
        //var_dump($resultado);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();
        //var_dump($resultado);

        //ENVIA AL USUARIO A UNA PAGINA U OTRA EN FUNCIÓN DEL RESULTADO DE LA CONSULTA 
        if($resultado){
            //ALMACENAMOS DOS VARIABLES DE TIPO SESION CON EL NOMBRE Y EL ROL DEL USUARIO QUE SE ESTA LOGUEANDO
            $_SESSION['rol'] = $resultado["id_rol"];
            $_SESSION['nombre'] = $resultado["nombre"];
            $_SESSION['id'] = $resultado["username"];
            header("location:index.php");
        }
        else{
            //PREGUNTAR SI SE PUEDE MOSTRAR EL ERROR DE UNA MANERA MÁS BONITA XD
            echo 
            "<script>
                alert('Usuario o contraseña incorrectos, intente nuevamente');
                window.location = 'login.html';
            </script>";
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

    function newPublicacion() {
        // Estructura Insert: https://www.hostinger.es/tutoriales/como-usar-php-para-insertar-datos-en-mysql/
        // Esto podria ser util: https://www.geeksforgeeks.org/how-to-insert-form-data-into-database-using-php/
        // Podria utilizarse $_REQUEST['email'] ?¿

        
        $safeConexion = conexion();
        $insertPublicacion = $safeConexion->prepare("INSERT INTO PUBLICACION (fechaCreacion, titulo, fechaInicio, fechaFin, mensaje, imagen, escritor, id) VALUES (:fechaCreacion, :titulo, :fechaInicio, :fechaFin, :mensaje, :imagen, :escritor, :id)");

        // La fecha de creacion:
        $fechaActual = date('Y/m/d');

        $my_Insert_Statement->bindParam(:fechaCreacion, $fechaActual);
        $my_Insert_Statement->bindParam(:titulo, $_POST['titulo']);
        $my_Insert_Statement->bindParam(:fechaInicio, $_POST['fechaInicio']);
        $my_Insert_Statement->bindParam(:fechaFin, $_POST['fechaFin']);
        $my_Insert_Statement->bindParam(:mensaje, $_POST['mensaje']);
        $my_Insert_Statement->bindParam(:imagen, '');
        $my_Insert_Statement->bindParam(:escritor, $_SESSION['id']);
        $my_Insert_Statement->bindParam(:id, 1);
        
        // El nombre de la imagen sera (si la hay, img[numero id_Publicacion])

        if ($insertPublicacion->execute()) {
            echo "New record created successfully";
        } else {
            echo "Unable to create record";
        }

    }


    //Actualizar, ALERTA DANGER DESACTUALIZADO
    function listarDepartamentos(){ 
        //include_once "base.php";

        //CREO UN OBJETO DE CONEXIÓN USANDO LA FUNCIÓN DE CONEXIÓN() 
        $con = conexion();

        //REALIZAMOS LA CONSULTA
        $consulta="SELECT * FROM departamento";
        
        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
        $stm = $con->query($consulta);

        //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
        $resultado = $stm->fetch();

        //RECORRER TODAS LOS VALORES OBTENIDOS
        while ($resultado){
            //MOSTRAMOS LOS DATOS DE LA CONSULTA
            echo '<div class="col-4">';
            echo '<input class="form-check-input" type="checkbox" name="dept'.$resultado["id_departamento"].' id="dept'.$resultado["id_departamento"].'">';
            echo '<label class="form-check-label margin_check" for="flexCheckDefault">'.$resultado["nombre"].' </label><br>';
            echo '</div>';

            //PASAR A LA SIGUIENTE FILA
            $resultado = $stm->fetch();
        }
    }






















    function insertarPublicacion(){
        conexion();
        //ASIGNAR A UNA VARIABLE LA INFORMACIÖN DE CADA CAMPO DEL FORMULARIO
        $var1 = $_POST['titulo'];
        $var2 = $_POST['mensaje'];
        $var3 = $_POST['fechaInicio'];
        $var4 = $_POST['fechaFin'];
        $var5 = $_POST['mensaje'];
        $var6 = $_POST['mensaje'];
        $var7 = $_POST['mensaje'];

        //VARIABLE QUE ME REALIZA EL INSERT EN LA TABLA
        $insertar = "INSERT INTO tabla(atr1, atr2) VALUES('$var1','$var2')";

        //COMPROBAR QUE SE EJECUTO ADECUADAMENTE
        $resultado = $conexion->query($insertar);

        if($resultado){
            echo "inserción exitosa";
        }
        else{
            echo "Inserción fallida";
        }
    }
?>

