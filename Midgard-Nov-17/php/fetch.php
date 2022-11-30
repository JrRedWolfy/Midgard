<?php
    //INCLUIMOS BASE.PHP PARA HACER LAS CONSULTAS
    include_once "base.php";

    //INICIALIZAMOS TODOS LOS VALORES DE DATA A FALSE
    $dataN = ["success"=>false];
    $dataP = ["success"=>false];
    $dataU = ["success"=>false];
    
    //DECODIFICAMOS EL OBJETO ENVIADO
    $_POST = json_decode(file_get_contents('php://input'), true);

    //ACTIVAMOS UNA FUNCIÓN POR MEDIO DEL OBJETO QUE SE ENVIA
    if (isset($_POST['pantalla'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchPantalla();
    }
    if (isset($_POST['usuario'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchUser();
    }
    if (isset($_POST['news'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchNews();
    }


    /*============FETCH PARA PUBLICACIONES============*/
    function fetchNews(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $id = $_POST['news']; 

        //HACEMOS LA CONSULTA EN LA BASE DE DATOS UTILIZANDO LA VARIABLE ENVIADA EN JAVASCRIPT
        $con = conexion();
        $consulta="SELECT * FROM PUBLICACION, ESTADO WHERE id = id_estado AND id_publicacion = '$id'";
        $stm = $con->query($consulta);
        $resultado = $stm->fetch();
         
        //ALMACENAMOS EN UN ARRAY ASOCIATIVO EL RESULTADO DE LA CONSULTA

        $cont=0;
        while ($resultado){
        $datos[$cont] = [
            'id_publicacion' => $resultado['id_publicacion'], 
            'fechaCreacion' => $resultado['fechaCreacion'], 
            'titulo' => $resultado['titulo'], 
            'fechaInicio' => $resultado['fechaInicio'], 
            'fechaFin' => $resultado['fechaFin'], 
            'mensaje' => $resultado['mensaje'], 
            'imagen' => $resultado['imagen'],
            'fechaAprobacion' => $resultado['fechaAprobacion'], 
            'escritor' => $resultado['escritor'],
            'aprobador' => $resultado['aprobador'], 
            'estado' => $resultado['nombre_estado']
        ];
        $cont++;
        $resultado = $stm->fetch();

        }
        
        $dataN = ["success"=>true,'news' => $datos];
        die(json_encode($dataN));
    }
    /*============================================*/



    /*============FETCH PARA PANTALLAS============*/
    function fetchPantalla(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $mac = $_POST['pantalla']; 

        //HACEMOS LA CONSULTA EN LA BASE DE DATOS UTILIZANDO LA VARIABLE ENVIADA EN JAVASCRIPT
        $con = conexion();
        $consulta="SELECT * FROM PANTALLA WHERE mac_pantalla = '$mac'";
        $stm = $con->query($consulta);
        $resultado = $stm->fetch();
         
        //ALMACENAMOS EN UN ARRAY ASOCIATIVO EL RESULTADO DE LA CONSULTA

        $cont=0;
        while ($resultado){
        $datos[$cont] = [
            'mac_pantalla' => $resultado['mac_pantalla'], 
            'ubicacion' => $resultado['ubicacion'], 
            'nombre' => $resultado['nombre']
            ];
        $cont++;
        $resultado = $stm->fetch();
        }

        $dataP = ["success"=>true,'pantalla' => $datos];
        die(json_encode($dataP));
    }
    /*===========================================*/
    


    /*============FETCH PARA USUARIOS============*/
    function fetchUser(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $username = $_POST['usuario']; 

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

        $dataU = ["success"=>true,'usuario' => $datos];

        die(json_encode($dataU));
    }
    /*================================================*/



?>