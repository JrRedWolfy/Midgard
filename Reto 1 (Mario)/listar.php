<?php
include_once "base.php";

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