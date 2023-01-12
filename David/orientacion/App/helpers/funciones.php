<?php

    function redireccionar($pagina){
        header('location: '.RUTA_URL.$pagina);
    }

    function formatFecha($fechaIngles){
        return date("d/m/Y H:i:s", strtotime($fechaIngles));
    }

    function obtenerRol($datos){
        $id_rol = 0;
            
        foreach($datos as $rol){
            if($rol->id_departamento == 1){
                if($rol->id_rol==30){
                    $id_rol = 10;
                }
            } else if($rol->id_departamento == 2){
                if($rol->id_rol==20){
                    $id_rol = 20;
                }
                if($rol->id_rol==10){
                    $id_rol = 30;
                }
            }
        }
        return $id_rol;
    }


?>