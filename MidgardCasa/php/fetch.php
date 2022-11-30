<?php
    //INCLUIMOS BASE.PHP PARA HACER LAS CONSULTAS
    include_once "base.php";

    //INICIALIZAMOS TODOS LOS VALORES DE DATA A FALSE
    $dataN = ["success"=>false];
    $dataP = ["success"=>false];
    $dataEP = ["success"=>false];
    $dataU = ["success"=>false];
    $dataEU = ["success"=>false];
    $dataM = ["success"=>false];
    $editNews = ["success"=>false];
    
    //DECODIFICAMOS EL OBJETO ENVIADO
    $_POST = json_decode(file_get_contents('php://input'), true);

    //ACTIVAMOS UNA FUNCIÓN POR MEDIO DEL OBJETO QUE SE ENVIA
    if (isset($_POST['pantalla'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchPantalla();
    }
    if (isset($_POST['pantallaEdit'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchPantallaEdit();
    }
    if (isset($_POST['usuario'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchUser();
    }
    if (isset($_POST['usuarioEdit'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchUserEdit();
    }
    if (isset($_POST['news'])){//SI SE HA DECODIFICADO CORRECTAMENTE ENTRARA EN LA FUNCIÓN
        fetchNews();
    }
    if (isset($_POST['editNews'])){
        editNews();
    }
    if (isset($_POST['mimensaje'])){
        fetchMismensajes();
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
        $con=null;
        
        $dataN = ["success"=>true,'news' => $datos];
        die(json_encode($dataN));
    }
    /*============================================*/

    /*============FETCH PARA MIS MENSAJES============*/
    function fetchMismensajes(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $id = $_POST['mimensaje']; 

        //HACEMOS LA CONSULTA EN LA BASE DE DATOS UTILIZANDO LA VARIABLE ENVIADA EN JAVASCRIPT
        $con = conexion();
        $consulta="SELECT * FROM PUBLICACION WHERE escritor='$id'";
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
        $con=null;
        
        $dataM = ["success"=>true,'news' => $datos];
        die(json_encode($dataM));
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

        $con=null;
        $dataP = ["success"=>true,'pantalla' => $datos];
        die(json_encode($dataP));
    }
    /*===========================================*/
    
    /*============FETCH PARA PANTALLAS============*/
    function fetchPantallaEdit(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $mac = $_POST['pantallaEdit']; 

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

        $con=null;
        $dataEP = ["success"=>true,'pantalla' => $datos];
        die(json_encode($dataEP));
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

        $con=null;
        $dataU = ["success"=>true,'usuario' => $datos];

        die(json_encode($dataU));
    }
    /*================================================*/


    /*============FETCH PARA USUARIOS============*/
    function fetchUserEdit(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $username = $_POST['usuarioEdit']; 

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

        $con=null;
        $dataEU = ["success"=>true,'usuario' => $datos];

        die(json_encode($dataEU));
    }
    /*================================================*/


    /*============FETCH PARA PUBLICACIONES============*/
    function editNews(){
        //ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $id = $_POST['editNews']; 

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
        
        $consulta2="SELECT mac_pantalla FROM PANTALLA_PUBLICACION WHERE id_publicacion = '$id'";
        $stm2 = $con->query($consulta2);
        $resultado2 = $stm2->fetch();
 
            //AÑADE LAS PANTALLAS EN LAS QUE SE ENCUENTRA LA PUBLICACIÓN
            $contScreen = 0;
            while ($resultado2){
                array_push($datos, $resultado2['mac_pantalla']);
                $contScreen++;
                $resultado2 = $stm2->fetch();
            }

        $cont++;
        $resultado = $stm->fetch();
        }
        
        $editNews = ["success"=>true,'news' => $datos];
        die(json_encode($editNews));
    }
    /*============================================*/

    function getScreen($datos, $id){
        $consulta2="SELECT mac_pantalla FROM PANTALLA_PUBLICACION WHERE id_publicacion = '$id'";
        $stm2 = $con->query($consulta);
        $resultado2 = $stm->fetch();

        //AÑADE LAS PANTALLAS EN LAS QUE SE ENCUENTRA LA PUBLICACIÓN
        $contScreen = 1;
        while ($resultado2){
            $datos[0] = [
                'pantalla'.$contScreen => $resultado2['macpantalla']
            ];
            $resultado2 = $stm2->fetch();
        }
        return $datos[0];
    }
?>