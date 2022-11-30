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
    <title>Usuarios</title>
    <!-- FONTAWESOME LIBRARY -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="../css/preloader.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>

    <nav id="menu" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid ">
            <a class="navbar-brand" href="../index.php">
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

            $sqlListUsers = "SELECT * FROM USUARIO";

            $consulta=$conexion->prepare($sqlListUsers);
            $consulta->execute();

            $usuarios=$consulta->fetchAll();

            // $nfilas=$consulta->rowCount();

            // echo $nfilas;

            //print_r($usuarios);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>USERNAME</th>
                    <th>NOMBRE</th>
                    <th>EMAIL</th>
                    <th>DNI</th>
                    <th>ROL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $users) : ?>
                    <tr>
                        <td><?php echo $users['username']; ?></td>
                        <td><?php echo $users['nombre']; ?></td>
                        <td><?php echo $users['email']; ?></td>
                        <td><?php echo $users['dni']; ?></td>
                        <td><?php if ($users['id_rol'] == 1) {echo "Admin";} elseif ($users['id_rol'] == 2) {echo "Aprobador";}elseif ($users['id_rol'] == 3) {echo "Publicador";}else {echo "-";}?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>



        

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usuario">
            Añadir Usuario
        </button>

        <!-- ==================== MODAL USUARIO ==================== -->
        <div class="modal fade" id="usuario" tabindex="-1" aria-labelledby="modalPublicación" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">AÑADIR NUEVO USUARIO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <!-- CONTENIDO DEL MODAL USUARIO -->
                    <form method="post">
                    <div class="modal-body"> 
                        
                        <label for="username" class="form-label mt-2">Username</label>
                        <input type="text" class="form-control" id="username" name="username">

                        <label for="clave" class="form-label mt-2">Contraseña</label>
                        <input type="text" class="form-control" id="clave" name="clave" >

                        <label for="fullname" class="form-label mt-2">Nombre Completo</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" >

                        <label for="email" class="form-label mt-2">Email</label>
                        <input type="text" class="form-control" id="email" name="email" >
                        
                        <label for="dni" class="form-label mt-2">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" >
                        
                        <select name="id_rol" id="id_rol" class="mt-2">
                            <option value="select" hidden selected>Seleccione un rol</option>
                            <option value="admin">Admin</option>
                            <option value="aprobador">Aprobador</option>
                            <option value="publicador">Publicador</option>
                        </select> 
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="userButton">Añadir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- ==================== FIN MODAL USUARIO ==================== -->

        <!-- Button trigger modal -->
        
    </div>
    
    
</body>
</html>