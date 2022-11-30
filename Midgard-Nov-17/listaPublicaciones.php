<?php include_once "base.php"; permisosListas();

    $con = conexion();
?>
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
                    <a class="nav-link active" aria-current="page" href="listaPublicaciones.php">
                        <i class="fa-solid fa-file-pen"></i> 
                        Publicaciones
                    </a>
                </li>
                <li class="nav-item"> <!-- LISTA PANTALLAS -->
                    <a class="nav-link" aria-current="page" href="listaPantallas.php">
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
   
    
    <form action="listaPublicaciones.php" method="get">
        Buscador
        <input type="text" id="palabra" name="palabra" >
        <input type="submit" name="search" id="search" value="Buscar" />
        <input type="submit" name="todas" id="todas" value="MostrarTodasPublicaciones" />
    </form>
    

    <section id="listas"  class="container-fluid">
        
        <div class="row">
        <?php
        

            //REALIZAMOS LA CONSULTA
            $consulta="SELECT id_publicacion, titulo FROM PUBLICACION";
            
            //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
            $stm = $con->query($consulta);

            //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
            $resultado = $stm->fetch();

            
            //Si se ha pulsado el botón de buscar
            if (isset($_GET['search'])) {

                //Recogemos las claves enviadas
                $palabra = $_GET['palabra'];

                if ($palabra == "") {
                    $nfilas = 0;
                    $resultado="";
                }else {
                    $sqlBuscarPubli = "SELECT * FROM PUBLICACION WHERE id_publicacion LIKE '%" . $palabra . "%' OR titulo LIKE '%" . $palabra . "%' OR fechaInicio LIKE '%" . $palabra . "%' OR mensaje LIKE '%" . $palabra . "%' OR imagen LIKE '%" . $palabra . "%' OR escritor LIKE '%" . $palabra . "%';";
                    
                    //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                    $stm = $con->query($sqlBuscarPubli);

                    //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
                    $resultado = $stm->fetch();

                    //NUMERO DE REGISTROS
                    $nfilas = $stm->rowCount();

                    
                }
                

                //Si hay resultados
                if ($nfilas > 0) {

                    echo '<h2>Se han encontrado '.$nfilas.' resultados.</h2>';

    
                }
                else {
                    //Si no hay registros encontrados
                    echo '<h2>No se encuentran resultados con los criterios de búsqueda.</h2>';
                }
            }elseif (isset($_POST['todas'])) {
                //REALIZAMOS LA CONSULTA
                $consulta="SELECT id_publicacion, titulo FROM PUBLICACION";
                
                //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                $stm = $con->query($consulta);

                //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
                $resultado = $stm->fetch();
            }

            

            if ($resultado == "") {
                
            }else{ 

                while ($resultado) :
                ?>

                <div class="mt-5 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="elemento">
                        <div class="lateral">
                            <a href="#" title="Datos" data-bs-toggle="modal" data-bs-target="#modalNews">
                                <div id="<?php echo $resultado["id_publicacion"]; ?>" class="news" onclick="ajaxNews(this);">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                            </a>
                            
                            <div class="botones">
                                <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["id_publicacion"] ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <button class="boton blue onBlue" title="Editar" name="<?php echo $resultado["id_publicacion"]; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </div>
                        </div>
    
                        <div class="nombre">
                            <h3><?php echo $resultado["titulo"]; ?></h3>
                        </div>
                    </div>
                </div>
    
                <?php
                    $resultado = $stm->fetch();
                    endwhile;
            }

            ?>
        </div>
        

    </section>



    <footer class="fixed-bottom">
        <img src="img/logo.webp" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
        <p>CPIFP Bajo Aragon</p>
    </footer>

    <div class="modal fade" id="modalNews" tabindex="-1" aria-labelledby="modalNews" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PUBLICACION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL USUARIO -->
                <div class="modal-body">
                    <div id="imgPublicacion"></div>
                    
                    <table class="tablaVer" id="tablaNews">
                        <tr>
                            <th>TITULO</th>
                            <td id="title"></td>
                        </tr>
                        <tr>
                            <th>MENSAJE</th>
                            <td id="msg"></td>
                        </tr>
                        <tr>
                            <th>ESCRITOR</th>
                            <td id="writer"></td>
                        </tr>
                        <tr>
                            <th>FECHA INICIO</th>
                            <td id="dateS"></td>
                        </tr>
                        <tr>
                            <th>FECHA FIN</th>
                            <td id="dateE"></td>
                        </tr>
                        <tr>
                            <th>ESTADO</th>
                            <td id="state"></td>
                        </tr>
                        <tr>
                            <th>APROBADOR</th>
                            <td id="aprove"></td>
                        </tr>
                        <tr>
                            <th>FECHA APROBACION</th>
                            <td id="dateAprove"></td>
                        </tr>
                    </table>
                
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btnModal btn-success" name="userButton">Aprobar</button>
                    <button type="button" class="btnModal btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rechazar">Rechazar</button>
                    
                </div>

            </div>
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
                <form method="post" action="base.php" enctype="multipart/form-data" onsubmit="return verificarForm();">
                    <div class="modal-body"> 

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btnModal btn-success" name="userButton">Si</button>
                        <button type="button" class="btnModal btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modalForm" id="rechazar" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Motivo del Rechazo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PUBLICACIÓN -->
                <form method="post" action="base.php" enctype="multipart/form-data" onsubmit="return verificarForm();">
                    <div class="modal-body">
                    <textarea name="motivo" class="form-control" id="" cols="24" rows="3"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btnModal btn-success" name="userButton">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>