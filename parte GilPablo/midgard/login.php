<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/preloader.css">
    <title>Login</title>
</head>
<body>
    <!-- PRELOADER -->
    <!-- <div id="preloader" class="fade">
        <div class="cssload-loader"></div>
    </div> -->
    
    <main>
        <form action="base.php" method="post"> <!--Sujeto a cambios-->
            <div class="container">
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
                        <h3>DATOS INCORRECTOS</h3>
                    <?php endif; ?>
            </div>
                    <input type="submit" name="loginButton" value="Entrar">
                </fieldset>
            </div>    
        </form>
    </main>

    <script src="js/script.js"></script>
</body>
</html>