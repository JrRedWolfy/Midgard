<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- FONTAWESOME LIBRARY -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <!-- PRELOADER PREGUNTAR COMO REALIZAR UN EFECTO FADEOUT EN JAVASCRIPT --> 
    <!-- <div class="preloader">
        <div class="cssload-loader"></div>
    </div> -->

    <!-- ==================== MENÚ ==================== -->
    <nav id="menu" class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <!-- LOGO -->
                <img src="img/logo.webp" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
                CPIFP Bajo Aragon
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- ICONO VERSIÓN MOVIL -->
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                <li id="usuario" class="nav-item dropdown"> <!-- DROPDOWN DE USUARIO -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mi perfil
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> Modificar datos</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown"> <!-- DROPDOWN DE PUBLICACIONES -->
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Publicaciones 
                </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-list"></i> Mis Publicaciones</a></li>
                        <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#publicacion"><i class="fa-solid fa-file-pen"></i> Nueva Publicación</a></li>
                    </ul>
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
    <!-- ==================== FIN DEL MENÚ ==================== -->

    <!-- ==================== CONTENIDO DE LA WEB ==================== -->
    <h1 class="text-center m-3">Bienvenidos somos el grupo Midgard</h1>
    <!-- ==================== FIN DEL CONTENIDO DE LA WEB ==================== -->

    <!-- ==================== MODAL PUBLICACIÓN ==================== -->
    <div class="modal fade" id="publicacion" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">REALIZAR PUBLICACIÓN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PUBLICACIÓN -->
                <form method="post" action="base.php" class="text-left" onsubmit="return verificarForm();">
                <div class="modal-body"> 
                    <p class="m-0 mb-2">Seleccione los departamentos a los que desea enviar la publicación</p>
                    <div class="row mt-2 mb-0"><!-- VERIFICAR EL LARGO DE ASUNTO Y MENSAJE EN LA BASE DE DATOS PARA EVITAR ERRORES -->
                        <?php include_once "base.php"; listarDepartamentos();?>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2" onclick="marcarTodos()">Marcar todos</button><br>
                    
                    <label for="asunto" class="form-label mt-2">Asunto</label>
                    <input type="text" class="form-control" id="asunto" required>

                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea name="mensaje" class="form-control"cols="3" rows="3" maxlength="5000" required></textarea>

                    <div class="row mt-2">
                        <?php $fecha = date("2022-11-01")?>
                        <p class="m-0 mb-2">Establece el rango de fechas en que tu mensaje sera público</p>
                        <div class="col">
                            <label for="fechaInicio" class="form-label m-0">Fecha inicio</label>
                            <input class="dateA" type="date" class="form-control" name="fechaInicio" onload="thisDate();" min=""><!-- MIRAR COMO COLOCAR AQUI SIEMPRE LA FECHA ACTUAL -->
                        </div>
                        <div class="col">
                            <label for="fechaFin" class="form-label m-0">Fecha fin</label>
                            <input type="date" class="form-control" name="fechaFin" min="2022-11-01"> <!-- EL MINIMO SERIA LA FECHA DE INICIO (SI ES POSIBLE QUE SE ACTUALICE AUTOMATICAMENTE) -->
                        </div>
                    </div>
                        <input class="form-control mt-3" type="file" id="formImg"><!-- GESTIONAR DISEÑO Y METODO QUE SOLO ACEPTE IMAGENES HASTA UN CIERTO TAMAÑO Y SU TRANSFORMACIÓN PARA LA BD -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Publicar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ==================== FIN MODAL PUBLICACIÓN ==================== -->

    <!-- ==================== MODAL USUARIO ==================== -->
    <!-- Pendiente -->
    <!-- ==================== FIN MODAL USUARIO ==================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <?php include_once "base.php"; rol();?>
</body>
</html>