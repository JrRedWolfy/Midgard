<?php include_once "php/base.php";  permisosListas(); $con = conexion();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="icon" type="image/vnd.microsoft.icon" href="img/Logo.ico">
    <link rel="shortcut icon" href="img/webImage/Logo.ico" type="image/x-icon">
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <!-- <link rel="stylesheet" href="css/preloader.css"> -->
    <link rel="stylesheet" href="css/indexStyle.css">
    <link rel="stylesheet" href="css/simplefooter.css">
    <title>Usuarios</title>
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
                    <a class="nav-link active" aria-current="page" href="usuarios">
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

    
    <!-- FILTRO BUSCADOR USUARIOS -->
    <form action="listaUsers.php" method="get">
        Buscador
        <input type="text" id="palabra" name="palabra" >
        <input type="submit" name="search" id="search" value="Buscar" />
        <input type="submit" name="todas" id="todas" value="MostrarTodosUsuarios" />       
    </form>
  
    <!-- IMAGEN + SCRIPT CAMBIAR VISTA DE USUARIOS ENTRE ICONO Y LISTA -->
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
                $consulta="SELECT username FROM USUARIO";
                
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
                        $sqlBuscarUsuario = "SELECT * FROM USUARIO WHERE username LIKE '%" . $palabra . "%' OR nombre LIKE '%" . $palabra . "%' OR email LIKE '%" . $palabra . "%' OR dni LIKE '%" . $palabra . "%';";
                        
                        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                        $stm = $con->query($sqlBuscarUsuario);

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
                    $consulta="SELECT username FROM USUARIO";
                    
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
                                    <a href="#" title="Datos" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                                        <div id="<?php echo $resultado["username"];?>" class="face" onclick="ajaxUser(this);">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </a>
                                    <div class="botones">
                                        <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["username"];?>" onclick="getIdUser(this);" data-bs-toggle="modal" data-bs-target="#deleteUser">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <button class="boton blue onBlue" title="Editar" name="<?php echo $resultado["username"];?>" onclick="ajaxUserEdit(this);" data-bs-toggle="modal" data-bs-target="#usuario">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </div>
                                </div>
                    
                                <div class="nombre">
                                    <h3><?php echo $resultado["username"];?></h3>
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
                $consulta="SELECT * FROM USUARIO";
                
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
                        $sqlBuscarUsuario = "SELECT * FROM USUARIO WHERE username LIKE '%" . $palabra . "%' OR nombre LIKE '%" . $palabra . "%' OR email LIKE '%" . $palabra . "%' OR dni LIKE '%" . $palabra . "%';";
                        
                        //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                        $stm = $con->query($sqlBuscarUsuario);

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
                    $consulta="SELECT * FROM USUARIO";
                    
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
                            <th>USERNAME</th>
                            <th>NOMBRE</th>
                            <th>EMAIL</th>
                            <th>DNI</th>
                            <th>INACTIVO</th>
                            <th>ROL</th>
                            <th>FUNCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($resultado) :
                    ?>

                            <tr>
                                <td><?php echo $resultado['username']; ?></td>
                                <td><?php echo $resultado['nombre']; ?></td>
                                <td><?php echo $resultado['email']; ?></td>
                                <td><?php echo $resultado['dni']; ?></td>
                                <td><?php if($resultado['inactivo']==0){echo "No";}elseif($resultado['inactivo']==1){echo "Si";}?></td>
                                <?php 
                                
                                    $id_rol = $resultado['id_rol'];
                                    //REALIZAMOS LA CONSULTA
                                    $consulta2="SELECT nombre_rol FROM ROL WHERE id_rol = '$id_rol'";
                                                        
                                    //EJECUTAMOS LA CONSULTA SQL (EL RESULTADO VIENE EN UN OBJETO DE TIPO STATEMENT)
                                    $stm2 = $con->query($consulta2);

                                    //CREAMOS UN OBJETO PARA CADA FILA DE LA CONSULTA
                                    $resultado2 = $stm2->fetch();
                                
                                ?>
                                <td><?php echo $resultado2['nombre_rol']; ?></td>
                                <td>
                                        <button class="boton red onRed" title="Eliminar" name="<?php echo $resultado["username"];?>" onclick="getIdUser(this);" data-bs-toggle="modal" data-bs-target="#deleteUser">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <button class="boton blue onBlue" title="Editar" name="<?php echo $resultado["username"];?>" onclick="ajaxUserEdit(this);" data-bs-toggle="modal" data-bs-target="#usuario">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
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


    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuario" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">USUARIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL USUARIO -->
                <form method="post" action="base.php" novalidate>
                    <div class="modal-body">
                    
                    <table class="tablaVer" id="tablaUser">
                        
                        <tr>
                            <th>USUARIO</th>
                            <td id="user"></td>
                        </tr>
                        <tr>
                            <th>CONTRASEÑA</th>
                            <td id="pass"></td>
                        </tr>
                        <tr>
                            <th>NOMBRE</th>
                            <td id="nombre"></td>
                        </tr>
                        <tr>
                            <th>EMAIL</th>
                            <td id="email"></td>
                        </tr>
                        <tr>
                            <th>DNI</th>
                            <td id="dni"></td>
                        </tr>
                        <tr>
                            <th>INACTIVO</th>
                            <td id="inactive"></td>
                        </tr>
                        <tr>
                            <th>FUNCION</th>
                            <td id="funcion"></td>
                        </tr>
                        
                    </table>
                    

                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="modal fade modalForm" id="deleteUser" tabindex="-1" aria-labelledby="modalUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Esta seguro de borrar este usuario?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL DELETE USUARIO -->
                <form method="post" action="php/base.php">
                <input id="deleteUserInp" type="text" value="" name="id" hidden>
                    <div class="modal-footer">
                        <button type="submit" class="btnModal btn-success" name="deleteUserBtn">Si</button>
                        <button type="submit" class="btnModal btn-secondary" name="deshabilitarUser">Solo Deshabilitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- ==================== MODAL USUARIO ==================== -->
<div class="modal fade" id="usuario" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">AÑADIR NUEVO USUARIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL USUARIO -->
                <form id="formUser" method="post" action="php/base.php" novalidate onsubmit="return validarUser();">
                <div class="modal-body">
                
                    <div class="grupo" id="grupo__username">
                        <label for="username" class="form-label mt-2">Username</label>
                        <div class="grupo-input" id="input__username">
                            <input type="text" class="form-control" id="usernameEdit" name="username"required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">El usuario tiene que ser de 4 a 20 dígitos y solo puede contener numeros, letras o guion.</p>
                    </div>

                    <div class="grupo" id="grupo__clave">
                        <label for="clave" class="form-label mt-2">Contraseña</label>
                        <div class="grupo-input" id="input__clave">
                            <input type="text" class="form-control" id="claveEdit" name="clave" required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">La contraseña debe ser de 6 a 20 digitos y contener al menos un numero.</p>
                    </div>

                    <div class="grupo" id="grupo__fullname">
                        <label for="fullname" class="form-label mt-2">Nombre Completo</label>
                        <div class="grupo-input" id="input__fullname">
                            <input type="text" class="form-control" id="fullnameEdit" name="fullname" required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">Su nombre debe tener de 4 a 50 dígitos y solo puede contener letras y espacios.</p>
                    </div>

                    <div class="grupo" id="grupo__email">
                        <label for="email" class="form-label mt-2">Email</label>
                        <div class="grupo-input" id="input__email">
                            <input type="text" class="form-control" id="emailEdit" name="email" required>
                            <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">El email es incorrecto.</p>
                    </div>

                    <div class="grupo" id="grupo__dni">
                        <label for="dni" class="form-label mt-2">DNI</label>
                        <div class="grupo-input" id="input__dni">
                        <input type="text" class="form-control" id="dniEdit" name="dni" required>
                        <i class="validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="input-error">Un DNI se compone de 8 numeros y una letra.</p>
                    </div>
                    
                    <select name="rol" id="rol" class="mt-2">
                        <option id="rol1" value="1">Admin</option>
                        <option id="rol2" value="2">Aprobador</option>
                        <option id="rol3" value="3">Publicador</option>
                    </select> 
                </div>

                <div id="formulario__publicacion" class="alert alert-danger fade show mt-2 mb-2 p-2 formulario__mensaje" role="alert">
                    <p class="mb-0"><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="userButton">Registrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ==================== FIN MODAL USUARIO ==================== -->

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

<?php include ('footer.php'); ?>
