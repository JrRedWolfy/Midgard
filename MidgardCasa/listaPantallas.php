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
    <title>Pantallas</title>
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
                    <a class="nav-link" aria-current="page" href="publicaciones">
                        <i class="fa-solid fa-file-pen"></i> 
                        Publicaciones
                    </a>
                </li>
                <li class="nav-item"> <!-- LISTA PANTALLAS -->
                    <a class="nav-link active" aria-current="page" href="pantallas">
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


    <!-- FILTRO BUSCADOR PANTALLAS -->
    <form action="listaPantallas.php" method="get">
        Buscador
        <input type="text" id="palabra" name="palabra" >
        <input type="submit" name="search" id="search" value="Buscar" />
        <input type="submit" name="todas" id="todas" value="MostrarTodasPantallas" />       
    </form>
  
    <!-- IMAGEN + SCRIPT CAMBIAR VISTA DE PANTALLAS ENTRE ICONO Y LISTA -->
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
                $consulta="SELECT mac_pantalla, nombre FROM PANTALLA";
                
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
                        $sqlBuscarPantalla = "SELECT * FROM PANTALLA WHERE mac_pantalla LIKE '%" . $palabra . "%' OR ubicacion LIKE '%" . $palabra . "%' OR nombre LIKE '%" . $palabra . "%';";
                        
                        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                        $stm = $con->query($sqlBuscarPantalla);

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
                    $consulta="SELECT mac_pantalla, nombre FROM PANTALLA";
                    
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
                                    <a href="#" title="Datos" data-bs-toggle="modal" data-bs-target="#modalPantalla">
                                        <div id="<?php echo $resultado["mac_pantalla"]; ?>" class="pc" onclick="ajaxPantalla(this);">
                                            <i class="fa fa-desktop"></i>
                                        </div>
                                    </a>
                                    <div class="botones">
                                        <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["mac_pantalla"];?>" onclick="getIdPantalla(this);" data-bs-toggle="modal" data-bs-target="#deletePantalla">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <button class="boton blue onBlue" title="Editar" name="<?php echo $resultado["mac_pantalla"]; ?>" onclick="ajaxEditPantalla(this);" data-bs-toggle="modal" data-bs-target="#pantalla">
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
                }



            ?>
        </div>
        
        <div class="row" style="display:none" id="listaTabla">
            <?php
        

                //REALIZAMOS LA CONSULTA
                $consulta="SELECT * FROM PANTALLA";
                
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
                        $sqlBuscarPantalla = "SELECT * FROM PANTALLA WHERE mac_pantalla LIKE '%" . $palabra . "%' OR ubicacion LIKE '%" . $palabra . "%' OR nombre LIKE '%" . $palabra . "%';";
                        
                        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                        $stm = $con->query($sqlBuscarPantalla);

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
                    $consulta="SELECT * FROM PANTALLA";
                    
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
                            <th>MAC_PANTALLA</th>
                            <th>UBICACION</th>
                            <th>NOMBRE</th>
                            <th>FUNCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($resultado) :
                    ?>

                            <tr>
                                <td><?php echo $resultado['mac_pantalla']; ?></td>
                                <td><?php echo $resultado['ubicacion']; ?></td>
                                <td><?php echo $resultado['nombre']; ?></td>
                                <td>

                                        <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["mac_pantalla"];?>" onclick="getIdPantalla(this);" data-bs-toggle="modal" data-bs-target="#deletePantalla">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <button class="boton blue onBlue" title="Editar" name="<?php echo $resultado["mac_pantalla"]; ?>" onclick="ajaxEditPantalla(this);" data-bs-toggle="modal" data-bs-target="#pantalla">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>

                                    <!-- <a href="php/base.php?mac_pantalla=<?php echo $resultado['mac_pantalla'];?>"><img src="img/webImage/trash.svg"></a>
                                    <a href="editarPantalla.php?macEdit=<?php echo $resultado['mac_pantalla'];?>&ubicacionEdit=<?php echo $resultado['ubicacion'];?>&nombreEdit=<?php echo $resultado['nombre'];?>"><img src="img/webImage/pencil-square.svg"></a> -->
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


    <!-- ==================== MODAL PANTALLA ==================== -->
    <div class="modal fade" id="pantalla" tabindex="-1" aria-labelledby="modalPantalla" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">EDITAR PANTALLA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PANTALLA -->
                <form method="post" action="php/base.php" id="formPantalla" onsubmit="return validarPantalla();">
                <div class="modal-body"> 
                    
                    <div class="grupo" id="grupo__nombre">
                        <label for="nombre" class="form-label mt-2" >Nombre Pantalla</label>
                        <div class="grupo-input" id="input__nombre">
                            <input type="text" class="form-control" id="nombreEdit"  name="nombre" placeholder="Ej: LOSCOS 1 " maxlength="12" required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">El nombre de pantalla debe tener al menos 3 caracteres.</p>
                    </div>

                    <div class="grupo" id="grupo__mac">
                    <label for="mac" class="form-label mt-2">Dirección MAC</label>
                        <div class="grupo-input" id="input__mac">
                            <input type="text" class="form-control" id="macEdit" name="mac" placeholder="a1:b2:c3:d4:e5:f6" maxlength="17" style="text-transform: uppercase" required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">Introduzca una Mac valida.</p>
                    </div>
                   
                    <div class="grupo" id="grupo__ubicacion">
                    <label for="ubicacion" class="form-label mt-2">Ubicación Pantalla</label>
                        <div class="grupo-input" id="input__mac">
                            <textarea name="ubicacion" id="ubicacionEdit" class="form-control" cols="3" rows="3" maxlength="500" placeholder="Ej: Edificio Botánico LOSCOS" required></textarea>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">Introduce de forma breve donde se ubica.</p>
                    </div>

                    <div id="formulario__mensaje" class="alert alert-danger fade show mt-2 mb-2 p-2 formulario__mensaje" role="alert">
                        <p class="mb-0"><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="pantaButton">Registrar</button>
                
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ==================== FIN MODAL PANTALLA ==================== -->


    <div class="modal fade modalForm" id="deletePantalla" tabindex="-1" aria-labelledby="modalPantalla" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Esta seguro de borrar esta pantalla?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL DELETE USUARIO -->
                <form method="post" action="php/base.php">
                    <input id="deletePantallaInp" type="text" value="" name="id" hidden>
                    <div class="modal-footer">
                        <button type="submit" class="btnModal btn-success" name="deletePantallaBtn">Si</button>
                        <button type="button" class="btnModal btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

    <?php include ('footer.php'); ?>