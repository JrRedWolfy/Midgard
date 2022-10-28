<?php
    function conexion(){
        //ESCRIBIR LOS PARAMETROS DE LA BASE DE DATOS
        $id = "localhost"; //192.168.4.231
        $usuario = "root";
        $clave = "1605";
        $bdName = "midgard";

        //METODO QUE SE CONECTA A LA BASE DE DATOS
        $conexion = new mysqli("$id", "$usuario", "$clave", "$bdName");

        //CONDICIONAL QUE VERIFICA LA CONEXIÓN
        /*
        if($conexion){
            echo "Conexión exitosa";
        }
        else{
            echo "Conección fallida";
        }*/
    }
    
    function validarUsuario(){
        conexion();
        $usuario=$_POST['user'];
        $password=$_POST['clave'];

        $consulta="SELECT*FROM usuario where (username='$usuario' or email='$usuario') and clave='$password'";
        $resultado=mysqli_query($conexion,$consulta);

        $filas=mysqli_num_rows($resultado);
        if($filas == 1){
            header("location:index.html");

        }
        else{
            ?>
            <p>contraseña incorrecta</p>
            <?php
                include("login.html");
            ?>
        <?php
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);
    }
    validarUsuario();

    function insertarPublicacion(){
        conexion();
        //ASIGNAR A UNA VARIABLE LA INFORMACIÖN DE CADA CAMPO DEL FORMULARIO
        $var1 = $_POST['name'];
        $var2 = $_POST['mensaje'];

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