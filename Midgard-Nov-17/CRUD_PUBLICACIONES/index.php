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
    <title>Publicaciones</title>
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
    
    <div class="container-fluid">

        <?php 

            $sql = "SELECT * FROM PUBLICACION";

            $consulta=$conexion->prepare($sql);
            $consulta->execute();

            $publicaciones=$consulta->fetchAll();

            // $nfilas=$consulta->rowCount();

            // echo $nfilas;

            //print_r($publicaciones);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>FECHA CREACION</th>
                    <th>TITULO</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA FIN</th>
                    <th>MENSAJE</th>
                    <th>IMAGEN</th>
                    <th>FECHA APROBACION</th>
                    <th>ESCRITOR</th>
                    <th>APROBADOR</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($publicaciones as $publis) : ?>
                    <tr>
                        <td><?php echo $publis['id_publicacion']; ?></td>
                        <td><?php echo $publis['fechaCreacion']; ?></td>
                        <td><?php echo $publis['titulo']; ?></td>
                        <td><?php echo $publis['fechaInicio']; ?></td>
                        <td><?php echo $publis['fechaFin']; ?></td>
                        <td><?php echo $publis['mensaje']; ?></td>
                        <td><?php if ($publis['imagen'] == NULL) {echo "-";}else {echo $publis['imagen'];}?></td>
                        <td><?php if ($publis['fechaAprobacion'] == NULL) {echo "-";}else {echo $publis['fechaAprobacion'];}?></td>
                        <td><?php if ($publis['escritor'] == NULL) {echo "-";}else {echo $publis['escritor'];}?></td>
                        <td><?php if ($publis['aprobador'] == NULL) {echo "-";}else {echo $publis['aprobador'];}?></td>
                        <td><?php if ($publis['id'] == NULL) {echo "-";}elseif ($publis['id'] == 1) {echo "Activo";}elseif ($publis['id'] == 2) {echo "Pendiente";} elseif ($publis['id'] == 3) {echo "Denegado";}?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </div>
    
</body>
</html>