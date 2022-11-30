<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/webImage/Logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/preloader.css">

    <title>Login</title>
</head>
<body>
    <!-- PRELOADER -->
    <div class="preloader">
        <div class="cssload-loader"></div>
    </div>

    <main>

        

        <form action="php/base.php" method="post"> <!--Sujeto a cambios-->

            
            <div class="container">

                <img src="img/webImage/LogoFull.png" alt="" width="320" height="200">

                <div id="container" class="container">
                    <fieldset><legend>Login</legend>
                        <div class="cajas">
                            <label for="user"><i class="fa fa-user"></i></label>
                            <input type="text" id="user" name="user" placeholder="Usuario o Email" required>
                        </div>

                        <div class="cajas">
                            <label for="clave"><i class="fas fa-lock"></i></label>
                            <input type="password" id="clave" name="clave" placeholder="Contraseña" required>
                            <i onclick="password()" id="ojo" class="far fa-eye"></i> <!-- <i class="far fa-eye-slash"></i> -->
                        </div>
                        <div  text-align="mensaje">
                        <?php if(isset($_GET['error']) && $_GET['error'] == 'true'): ?>
                            <!-- <script>alert('Usuario o contraseña incorrectos, intente nuevamente');</script> -->
                            <p id="olvidar"><a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#recuperacion">¿Has olvidado la contraseña?</a></p>
                        <?php endif; ?>
                        </div>
                        <input type="submit" name="loginButton" value="Entrar">
                    </fieldset>

                </div>
                
            </div>    
        </form>
    </main>


    <div class="modal fade" id="recuperacion" tabindex="-1" aria-labelledby="modalRecuperacion" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">RECUPERACION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- CONTENIDO DEL MODAL PANTALLA -->
                <form method="post" action="php/base.php" id="formRecuperacion" onsubmit="return validarRecuperacion();">
                    <div class="modal-body"> 
                    
                        <div class="grupo" id="grupo__email">
                            <label for="email" class="form-label mt-2" >Email</label>
                            <div class="grupo-input" id="input__email">
                                <input type="text" class="form-control" id="email"  name="email" placeholder="TuEmail@lodemas.algo" maxlength="50">
                                <i class="validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="input-error">Este email no esta registrado.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="js/script.js"></script>
</body>
</html>