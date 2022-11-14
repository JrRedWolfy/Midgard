<?php

        session_start();

        include "../base.php";

        $conexion = conexion();


        if(isset($_POST['guardar'])){
      
            $username = $_POST['username'];
            $clave = $_POST['clave'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $dni = $_POST['dni'];
            
            $sqlEditUser = "UPDATE USUARIO SET clave = '$clave', nombre = '$nombre', email = '$email', dni = '$dni' WHERE username = '$username';";

            $consulta=$conexion->prepare($sqlEditUser);
            $consulta->execute();

            header("location: index.php");

        }elseif (isset($_POST['volver'])) {
            header("location: index.php");
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios</title>
    <!-- FONTAWESOME LIBRARY -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="../css/preloader.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    
<h1>EDITAR USUARIO</h1>
    <form method="post">

        <label for="username" >Username</label>
        <input type="text" id="username" name="username" value="<?php echo $_GET['usernameEdit']; ?>" readonly><br><br>

        <label for="clave" >Clave</label>
        <input type="text" id="clave" name="clave" value="<?php echo $_GET['claveEdit']; ?>"><br><br>

        <label for="nombre" >Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $_GET['nombreEdit']; ?>"><br><br>

        <label for="email" >Email</label>
        <input type="text" id="email" name="email" value="<?php echo $_GET['emailEdit']; ?>"><br><br>

        <label for="dni" >DNI</label>
        <input type="text" id="dni" name="dni" value="<?php echo $_GET['dniEdit']; ?>"><br><br>

        <input type='submit' name='guardar' value='GUARDAR CAMBIOS' id='guardar'>
        <input type='submit' name='volver' value='VOLVER' id='volver'>


    </form>

</body>
</html>