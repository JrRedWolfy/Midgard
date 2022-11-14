<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/indexStyle.css">
    <title>Mis Mensajes</title>
</head>
<body>
<!-- PRELOADER PREGUNTAR COMO REALIZAR UN EFECTO FADEOUT EN JAVASCRIPT --> 
    <!-- <div class="preloader">
        <div class="cssload-loader"></div>
    </div> -->

    <!-- ==================== MENÚ ==================== -->
    
    <nav id="menu" class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid ">
            <a class="navbar-brand" href="index.php">
                <!-- LOGO -->
                <img src="img/logoazul.png" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
                CPIFP Bajo Aragon
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- ICONO VERSIÓN MOVIL -->
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul id="menu2" class="navbar-nav">
                <li class="nav-item"> <!-- NUEVO USUARIO -->
                    <a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#usuario"><!-- LLAMARA AL MODAL DE USUARIO -->
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Nuevo Usuario
                    </a>
                </li>
                <li class="nav-item"> <!-- NUEVA PUBLICACIÓN -->
                    <a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#publicacion"><!-- LLAMARA AL MODAL DE PUBLICACIÓN -->
                        <i class="fa-solid fa-file-pen"></i> 
                        Nueva Publicación
                    </a>
                </li>
                <li class="nav-item"> <!-- NUEVA PANTALLA -->
                    <a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#pantalla"><!-- LLAMARA AL MODAL DE PUBLICACIÓN -->
                        <i class="fa-solid fa-desktop"></i>
                        Nueva Pantalla
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item"> <!-- INICIAR SESIÓN -->
                    <a class="nav-link active" aria-current="page" href="login.html">
                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                        Ingresar
                    </a>
                </li>
                <li class="nav-item">  <!-- CERRAR SESIÓN -->
                    <a class="nav-link active" aria-current="page" href="cerrar.php">
                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                        Cerrar sesión
                    </a>
                </li>
            </ul>
            </div>
        </div> 
    </nav>    


    <div>

        <section id="listas" class="container-fluid">

            <div class="row">
                <?php include_once "base.php"; misMensajes();?>
            </div>

        </section>
    </div>


    <footer class="fixed-bottom">
        <img src="img/logo.webp" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
        <p>CPIFP Bajo Aragon</p>
    </footer>

</body>
</html>