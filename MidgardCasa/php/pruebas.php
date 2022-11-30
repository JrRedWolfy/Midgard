<?php
include_once "base.php";
//ALMACENAMOS EN UNA VARIABLE EL VALOR QUE SE ENVIO POR JAVASCRIPT
        $id = 20; 

        //HACEMOS LA CONSULTA EN LA BASE DE DATOS UTILIZANDO LA VARIABLE ENVIADA EN JAVASCRIPT
        $con = conexion();
        $consulta="SELECT * FROM PUBLICACION, ESTADO WHERE id = id_estado AND id_publicacion = '$id'";
        $stm = $con->query($consulta);
        $resultado = $stm->fetch();

        // var_dump($resultado);
          
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

        getScreens($datos[0], $id);
        // print_r($buenas);

        function getScreens($datos, $id){
            $con = conexion();
            $consulta2="SELECT mac_pantalla FROM PANTALLA_PUBLICACION WHERE id_publicacion = '$id'";
            $stm2 = $con->query($consulta2);
            $resultado2 = $stm2->fetch();
    
            //AÑADE LAS PANTALLAS EN LAS QUE SE ENCUENTRA LA PUBLICACIÓN
            $contScreen = 0;
            while ($resultado2){
                // print_r($resultado["mac_pantalla"]."<br>");
                $datos[$contScreen] = [
                    'pantalla'.$contScreen => $resultado2['mac_pantalla']
                ];
                $contScreen++;
                $resultado2 = $stm2->fetch();
            }

            print_r($datos);
        }
        // $editNews = ["success"=>true,'news' => $buenas];
        // die(json_encode($editNews));

?>