<?php include_once "php/base.php";  permisosListas(); $con=conexion();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="shortcut icon" href="img/webImage/Logo.ico" type="image/x-icon">
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/indexStyle.css">
    <link rel="stylesheet" href="css/simplefooter.css">
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
            <a class="navbar-brand" href="inicio">
                <!-- LOGO -->
                <img src="img/webImage/logoazul.png" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
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

    <!-- ==================== FIN MENÚ ==================== -->
    
    
    <div>

        <section id="listas" class="container-fluid">

        <div class="row">
            <?php 
                    $con = conexion();
                    $usuarioactivo = $_SESSION['id'];
                    $mispublicaciones = "SELECT * FROM PUBLICACION WHERE escritor='$usuarioactivo'";
                    $stm = $con->query($mispublicaciones);
                    $publicaciones = $stm -> fetch();
                    
                    while ($publicaciones) :
                ?>

                <div class="mt-5 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="elemento">
                        <div class="lateral">
                            <a href="#" title="Datos">
                                <div id="<?php echo $publicaciones["id_publicacion"]; ?>" class="pc" onclick="ajaxMismensajes(this);">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                            </a>
                            <div class="botones">
                                <button class="boton red onRed" title="Eliminar" name="<?php echo $publicaciones["id_publicacion"];?>" onclick="getIdPubli(this);" data-bs-toggle="modal" data-bs-target="#deleteNews">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <button class="boton blue onBlue" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                        <div class="nombre">
                            <h3> <?php echo $publicaciones["titulo"];?> </h3>
                        </div>
                    </div>
                </div>
                
                <?php 
                    $publicaciones = $stm->fetch();
                    endwhile;
                ?>
        </div>

    </div>



    <div class="modal fade modalForm" id="deleteNews" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Esta seguro de borrar esta publicacion?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PUBLICACIÓN -->
                <form method="post" action="php/base.php">
                    <input id="deletePubliInp" type="text" value="" name="id" hidden>
                    <div class="modal-footer">
                        <button type="submit" class="btnModal btn-success" name="deleteNewsBtn">Si</button>
                        <button type="button" class="btnModal btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php include ('footer.php'); ?>
