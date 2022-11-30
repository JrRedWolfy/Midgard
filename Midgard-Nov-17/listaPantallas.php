<?php include_once "base.php";  permisosListas();?>
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
    <title>Document</title>
</head>
<body>

    <div class="preloader">
        <div class="cssload-loader"></div>
    </div>
    
    <nav id="menu" class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid ">
            <a class="navbar-brand" href="inicio">
                <!-- LOGO -->
                <i class="fas fa-arrow-left" style="color:#565656; font-size: 50px;"></i>
                
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- ICONO VERSIÓN MOVIL -->
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul id="menu2" class="navbar-nav">
                <li class="nav-item"> <!-- LISTA USUARIOS -->
                    <a class="nav-link" aria-current="page" href="listaUsers.php">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Usuarios
                    </a>
                </li>
                <li class="nav-item"> <!-- LISTA PUBLICACIONES -->
                    <a class="nav-link" aria-current="page" href="listaPublicaciones.php">
                        <i class="fa-solid fa-file-pen"></i> 
                        Publicaciones
                    </a>
                </li>
                <li class="nav-item"> <!-- LISTA PANTALLAS -->
                    <a class="nav-link active" aria-current="page" href="listaPantallas.php">
                        <i class="fa-solid fa-desktop"></i>
                        Pantallas
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


    

    <section id="listas" class="container-fluid">
        <div class="row">
            <?php 
                    $con = conexion();
                    $consulta="SELECT mac_pantalla, nombre FROM PANTALLA";
                    $stm = $con->query($consulta);
                    $resultado = $stm->fetch();
                    while ($resultado) :
                ?>

                <div class="mt-5 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="elemento">
                        <div class="lateral">
                            <a href="#" title="Datos" data-bs-toggle="modal" data-bs-target="#modalPantalla">
                                <div id="<?php echo $resultado["mac_pantalla"]; ?>" class="pc" onclick="ajaxPantalla(this);">
                                    <i class="fa fa-desktop"></i>
                                </div>
                            </a>
                            <div class="botones">
                                <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["mac_pantalla"];?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <button class="boton blue onBlue" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                        <div class="nombre">
                            <h3><?php echo $resultado["nombre"];?></h3>
                        </div>
                    </div>
                </div>
                
                <?php 
                    $resultado = $stm->fetch();
                    endwhile;
                ?>
        </div>
    </section>

    <div class="modal fade" id="modalPantalla" tabindex="-1" aria-labelledby="modalPantalla" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PANTALLA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL USUARIO -->
                <form id="formUser" method="post" action="base.php" novalidate>
                    <div class="modal-body">

                        <table class="tablaVer" id="tablaPantalla">

                            <tr>
                                <th>NOMBRE</th>
                                <td id="nombre"></td>
                            </tr>
                            <tr>
                                <th>DIRECCION MAC</th>
                                <td id="direccion"></td>
                            </tr>
                            <tr>
                                <th>UBICACION</th>
                                <td id="ubicacion"></td>
                            </tr>

                        </table>
                  



                    </div>

                </form>
            </div>
        </div>
    </div>
    

    <footer class="fixed-bottom">
        <img src="img/logo.webp" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
        <p>CPIFP Bajo Aragon</p>
    </footer>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>