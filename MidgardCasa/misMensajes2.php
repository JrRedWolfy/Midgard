<?php include_once "php/base.php"; permisosListas();

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
                    <a class="nav-link" aria-current="page" href="usuarios">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Usuarios
                    </a>
                </li>
                <li class="nav-item"> <!-- LISTA PUBLICACIONES -->
                    <a class="nav-link active" aria-current="page" href="publicaciones">
                        <i class="fa-solid fa-file-pen"></i> 
                        Publicaciones
                    </a>
                </li>
                <li class="nav-item"> <!-- LISTA PANTALLAS -->
                    <a class="nav-link" aria-current="page" href="pantallas">
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
   
    <!-- FILTRO BUSCADOR PUBLICACIONES -->
    <form action="listaPublicaciones.php" method="get">
        Buscador
        <input type="text" id="palabra" name="palabra" >
        <input type="submit" name="search" id="search" value="Buscar" />
        <input type="submit" name="todas" id="todas" value="MostrarTodasPublicaciones" />       
    </form>
  
    <!-- IMAGEN + SCRIPT CAMBIAR VISTA DE PUBLICACIONES ENTRE ICONO Y LISTA -->
    <img src="img/webImage/list-ul.svg" width="50px" onclick="cambiarContenido(listaIconos, listaTabla)">
    
    <script>
        function cambiarContenido(iconos, tabla){ 
            
            if (iconos.style.display=="none"){
                iconos.style.display="";
                tabla.style.display="none";

            }else{
                iconos.style.display="none";
                tabla.style.display="";

            } 

            
            
            
         }

    </script>
    

    <section id="listas"  class="container-fluid">
        
        <div class="row" style="display:" id="listaIconos">
            <?php
        

                //REALIZAMOS LA CONSULTA
                $usuarioActivo = $_SESSION['id'];
                $consulta="SELECT id_publicacion, titulo FROM PUBLICACION where escritor = '$usuarioActivo'";
                
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
                    $usuarioActivo = $_SESSION['id'];
                    $consulta="SELECT id_publicacion, titulo FROM PUBLICACION where escritor = '$usuarioActivo'";
                    
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
                                    <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["id_publicacion"] ?>" onclick="getIdPubli(this);" data-bs-toggle="modal" data-bs-target="#deleteNews">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                    <button class="boton blue onBlue" title="Editar" name="<?php echo $resultado["id_publicacion"]; ?>" onclick="fetchNews(this);" data-bs-toggle="modal" data-bs-target="#publicacion">
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
        
        <div class="row" style="display:none" id="listaTabla">
            <?php
        
                $usuarioActivo = $_SESSION['id'];
                //REALIZAMOS LA CONSULTA
                $consulta="SELECT * FROM PUBLICACION where escritor = '$usuarioActivo'";
                
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
                    $consulta="SELECT * FROM PUBLICACION";
                    
                    //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                    $stm = $con->query($consulta);

                    //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
                    $resultado = $stm->fetch();
                }

                

                if ($resultado == "") {
                    
                }else{ ?>

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
                            <th>FUNCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($resultado) :
                    ?>

                            <tr>
                                <td><?php echo $resultado['id_publicacion']; ?></td>
                                <td><?php echo $resultado['fechaCreacion']; ?></td>
                                <td><?php echo $resultado['titulo']; ?></td>
                                <td><?php echo $resultado['fechaInicio']; ?></td>
                                <td><?php echo $resultado['fechaFin']; ?></td>
                                <td onclick="expandirMensaje('<?php echo $resultado['mensaje']; ?>')"><?php echo "Mensaje " . $resultado['titulo']; ?></td>
                                <td><?php if ($resultado['imagen'] == NULL) {echo "-";}else {echo $resultado['imagen'];}?></td>
                                <td><?php if ($resultado['fechaAprobacion'] == NULL) {echo "-";}else {echo $resultado['fechaAprobacion'];}?></td>
                                <td><?php if ($resultado['escritor'] == NULL) {echo "-";}else {echo $resultado['escritor'];}?></td>
                                <td><?php if ($resultado['aprobador'] == NULL) {echo "-";}else {echo $resultado['aprobador'];}?></td>
                                <td><?php if ($resultado['id'] == NULL) {echo "-";}elseif ($resultado['id'] == 1) {echo "Activo";}elseif ($resultado['id'] == 2) {echo "Pendiente";} elseif ($resultado['id'] == 3) {echo "Denegado";}?></td>
                                <td>
                                    <a href="php/base.php?id_publicacion=<?php echo $resultado['id_publicacion'];?>"><img src="img/webImage/trash.svg"></a>
                                    <a href="editarPublicacion.php?tituloEdit=<?php echo $resultado['titulo'];?>&id_publicacionEdit=<?php echo $resultado['id_publicacion'];?>&fechaInicioEdit=<?php echo $resultado['fechaInicio'];?>&fechaFinEdit=<?php echo $resultado['fechaFin'];?>&mensajeEdit=<?php echo $resultado['mensaje'];?>&imagenEdit=<?php echo $resultado['imagen'];?>"><img src="img/webImage/pencil-square.svg"></a>
                                </td>
                            </tr>
                    <?php
                        $resultado = $stm->fetch();
                        endwhile;
                        
                        ?>
                    </tbody> 
                </table> <?php
                }

            
            ?>
        </div>

        <script>
            function expandirMensaje(mensaje){

                window.alert(mensaje);

            }

        </script>
    </section>


    <div class="modal fade" id="modalNews" tabindex="-1" aria-labelledby="modalNews" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PUBLICACION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL USUARIO -->
                <form method="post" action="/php/base.php">
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

                    <input id="aprobarBtn" type="text" value="" name="aprobado" hidden>

                    <div id="NewPendiente" class="modal-footer">
                        <button type="submit" class="btnModal btn btn-success" name="AprobarNewsBtn">Aprobar</button>
                        <button type="button" class="btnModal btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rechazar">Rechazar</button>
                    </div>
                </form>

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

    <div class="modal fade modalForm" id="rechazar" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Motivo del Rechazo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PUBLICACIÓN -->
                <form method="post" action="php/base.php">
                    <div class="modal-body">
                    <textarea name="motivo" class="form-control" id="" cols="24" rows="3"></textarea>

                    <input id="rechazarBtn" type="text" value="" name="rechazado" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btnModal btn-success" name="rechazarNewsBtn">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- ==================== MODAL PUBLICACIÓN ==================== -->
        <div class="modal fade modalForm" id="publicacion" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">REALIZAR PUBLICACIÓN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PUBLICACIÓN -->
                <form id="formPubli" method="post" action="php/base.php" enctype="multipart/form-data"  novalidate onsubmit="return validarPubli();">
                <div class="modal-body"> 

                <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == '1'):?>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="porDefecto">Por defecto</label>
                            <input class="form-check-input" type="checkbox" name="pantalla0" value="00:00:00:00:00:00" onclick="ocultar();">
                        
                        <!-- ICONO QUE DESPLIEGA UNA VENTANA DE AYUDA -->
                            <a tabindex="0" role="button" class="popover-dismiss" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="Click aquí si quieres que esta publicación se muestre cuando no halla ninguna programada">
                                <i class="fa-solid fa-circle-info text-success" style="font-size: 18px;"></i>
                            </a>
                            <!-- Si quiere agregar un titulo al popover utiliza  title="titulo popover"  -->
                    </div>
                        <hr>
                <?php endif; ?>
                
                    <p class="m-0 mb-2">Seleccione las pantallas que mostraran su mensaje</p>
                    <div class="row mt-2 mb-0"><!-- VERIFICAR EL LARGO DE ASUNTO Y MENSAJE EN LA BASE DE DATOS PARA EVITAR ERRORES -->
                        <?php include_once "php/base.php"; checkboxPantallas();?>
                    </div>
                    <button type="button" id="botonMarcar" class="btn btn-success btn-sm mt-2" onclick="marcarTodos()">Marcar todos</button><br>
                    
                    <div class="grupo" id="grupo__asunto">
                        <label for="asunto" name="asunto" class="form-label mt-2">Asunto</label>
                        <div class="grupo-input" id="input__asunto">
                    <input type="text" class="form-control" id="asunto" name="asunto" required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">El asunto es obligatorio y debe conformarse por al menos 4 digitos.</p>
                    </div>

                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea id=mensaje name="mensaje" class="form-control"cols="3" rows="3" maxlength="2300"></textarea>

                    <div class="row mt-2">
                        <p class="m-0 mb-2">Establece el rango de fechas en que tu mensaje sera público</p>
                        <div id="grupo__fechaInicio" class="col">
                            <label for="fechaInicio" class="form-label m-0">Fecha inicio</label>
                            <div class="grupo-input" id="input_fechaInicio">
                                <input id="dateA" type="date" onchange="selectDate();" class="form-control" name="fechaInicio" min="">
                                <i class="validacion-estado fas fa-times-circle" style="right: 35px;"></i>
                        </div>
                            <p class="input-error">Campo Obligatorio.</p>
                        </div>

                        <div id="grupo__fechaFin" class="col">
                            <label for="fechaFin" class="form-label m-0">Fecha fin</label>
                            <div class="grupo-input" id="input__fechaFin">
                                <input id="dateB" type="date" onchange="selectDate();" class="form-control" name="fechaFin" min="" disabled>
                                <i class="validacion-estado fas fa-times-circle" style="right: 35px;"></i>
                        </div>
                            <p class="input-error">Campo Obligatorio.</p>
                    </div>
                </div>

                    <div id="campo__publiImg" class="mt-2">
                        <div class="grupo-input" id="grupo__publiImg">
                            <input class="form-control" type="file" id="publiImg" accept="image/*,.pdf" name="publiImg">
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">Este campo es obligatorio en caso de no haber mensaje.</p>
                    </div>

                    <div id="formulario__publicacion" class="alert alert-danger fade show mt-2 mb-2 p-2 formulario__mensaje" role="alert">
                        <p class="mb-0"><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                    </div>
                </div>

                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="publiButton">Publicar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ==================== FIN MODAL PUBLICACIÓN ==================== -->






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

    <!--PARA PRUEBAS ELIMINAR AL FINAL -->
    <script src="js/macscript.js"></script>


    <?php include ('footer.php'); ?>