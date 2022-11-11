<?php session_start();

    include "../base.php";

    $conexion = conexion();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantallas</title>
    <!-- FONTAWESOME LIBRARY -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <nav id="menu" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid ">
            <a class="navbar-brand" href="index.php">
                <!-- LOGO -->
                <img src="../img/logo.webp" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
                CPIFP Bajo Aragon
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- ICONO VERSIÓN MOVIL -->
            </button>

        </div>
    </nav> 

    <nav class="navbar bg-danger justify-content-center">
        
        <a class="nav-link" style="color: black;" href="../CRUD_PUBLICACIONES/index.php">PUBLICACIONES</a>
        
        <a class="nav-link active" style="color: black;" href="../CRUD_USUARIOS/index.php">USUARIOS</a>
       
        <a class="nav-link" style="color: black;" href="../CRUD_PANTALLAS/index.php">PANTALLAS</a>
        
    </nav>


    <div class="container">

        <?php 

            $sql = "SELECT * FROM PANTALLA";

            $consulta=$conexion->prepare($sql);
            $consulta->execute();

            $pantallas=$consulta->fetchAll();

            // $nfilas=$consulta->rowCount();

            // echo $nfilas;

            print_r($pantallas);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>IP</th>
                    <th>UBICACION</th>
                    <th>NOMBRE</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pantallas as $pant) : ?>
                    <tr>
                        <td><?php echo $pant['ip']; ?></td>
                        <td><?php echo $pant['ubicacion']; ?></td>
                        <td><?php echo $pant['nombre']; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </div>
    
    
</body>
</html>