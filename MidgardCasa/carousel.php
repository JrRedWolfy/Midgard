<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Actualiza pagina cada 10 minutos -->
    <meta http-equiv="refresh" content="600">
    <title> Noticias </title>
    <link rel="shortcut icon" href="img/webImage/Logo.ico" type="image/x-icon">
    <!-- FUENTE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FONTAWESOME LIBRARY -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/indexStyle.css">
    <link rel="stylesheet" href="css/carousel.css">
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

            </div>
        </div> 
    </nav> 

            <!-- ==================== VISTA DE PANTALLAS CARRUSEL==================== -->
            
    <section class="container-fluid">

        <div class="navegador-carrusel d-flex justify-content-center">
            <div class="menuCarrusel mt-2">
                <button onclick="prev()">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                    
                    <?php //hacemos una consulta para listar las pantallas en el controlador
                        include_once "php/base.php";
                        $con = conexion();
                        $consulta = "SELECT * FROM PANTALLA WHERE mac_pantalla != '00:00:00:00:00:00'";
                        $stm = $con->query($consulta);
                        $listPantalla = $stm->fetch();
                        
                        //LISTA LOS NOMBRES DE CADA PANTALLA
                        $cont=0; //Utilizamos este contador para no colocar el d-none en el primer
                        while ($listPantalla){
                            if ($cont==0){
                                echo "<p class='activo p-0 m-0 d-flex align-items-center justify-content-center carruselPantalla'>".$listPantalla["nombre"]."</p>";
                            }else{
                                echo "<p class='d-none p-0 m-0 d-flex align-items-center justify-content-center carruselPantalla'>".$listPantalla["nombre"]."</p>";
                            }
                            $cont++;
                            $listPantalla = $stm->fetch();
                        }
                        $con = null;
                    ?>

                <button onclick="next()">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

        </div><!-- Fin navegador-carrusel -->

        <?php 
            //HACEMOS UNA SEGUNDA CONSULTA PERO ESTA VEZ PARA OBTENER PUBLICACIONES POR PANTALLA
            include_once "php/base.php";
            $con = conexion();
            $consulta = "SELECT * FROM PANTALLA WHERE mac_pantalla != '00:00:00:00:00:00'";
            $stm1 = $con->query($consulta);
            $pantalla = $stm1->fetch();
            $cont=0;

            //POR CADA PANTALLA DE LA CONSULTA ANTERIOR HACEMOS LO SIGUIENTE
            while($pantalla) :

                if($cont==0){

                    echo "<div class='carrusel-pantalla activo'>";

                }else{

                    echo "<div class='carrusel-pantalla d-none'>";

                }

                $cont++;
                    
                $mac = $pantalla["mac_pantalla"];
                    
                //OBTENEMOS LA FECHA ACTUAL
                $hoy = getdate();
                $fechaActual = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
                    
                //UTILIZAMOS EL PROCEDURE QUE ME LISTA LAS PUBLICACIONES DE LA PANTALLA QUE LE MANDE
                $procedure = "CALL  publicacionPantalla ('$mac', '$fechaActual')";//echo $procedure;
                $stm2 = $con->query($procedure);
                $publicacion = $stm2->fetchAll();
                //SI HAY PUBLICACIONES APROADAS EN LAS PANTALLAS
                
                $contpublicacion = 0;

                if ($publicacion) :
                ?>
                
                <div class='carousel-publicaciones'>
                    <div id="carouselNoticias" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">

                            <?php
                            foreach($publicacion as $mensaje) :
                                if ($contpublicacion==0): //SI ES EL PRIMER ELEMENTO
                            ?>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $contpublicacion ?>" class="active" aria-current="true" aria-label="Slide <?php echo $contpublicacion ?>"></button>

                                <?php else : ?>

                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?php echo $contpublicacion ?>" aria-label="Slide <?php echo $contpublicacion?>"></button>

                            <?php  
                                endif;
                                $contpublicacion++;
                            endforeach;
                            ?>

                        </div> <!-- FIN CAROUSEL-INDICATORS -->

                        <?php $contpublicacion = 0; ?> <!-- INICIALIZAMOS EL CONTADOR A CERO NUEVAMENTE AL SALIR DEL BUCLE -->
                
                        <div class="carousel-inner align-top">
                            
                            <?php
                            foreach($publicacion as $mensaje) :
                                if ($mensaje['imagen']!=NULL && $mensaje['mensaje']==NULL) :  //TIENE SOLO IMAGEN
                                    if ($contpublicacion==0) : //SI ES EL PRIMER ELEMENTO
                            ?>

                                    <div class="carousel-item active">
                                        <div class="divflex">
                                            <div class="soloimg">
                                                <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>      
                                            </div>
                                        </div>
                                    </div>

                                    <?php else : ?> <!-- SI NO ES EL PRIMER ELEMENTO -->
                                    
                                    <div class="carousel-item">
                                        <div class="divflex">
                                            <div class="soloimg">
                                                <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    endif;
                                    
                                elseif ($mensaje['imagen']==NULL && $mensaje['mensaje']!=NULL) : //TIENE SOLO MENSAJE
                                    if ($contpublicacion==0) : //SI ES EL PRIMER ELEMENTO
                                    ?>
                                        <div class="carousel-item active">
                                            <div class="divflex">
                                                <div class="txt">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje']) ?></p> <br>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    <?php else : ?>

                                        <div class="carousel-item">
                                            <div class="divflex">
                                                <div class="txt">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje']) ?></p> <br>
                                                </div>
                                            </div>
                                        </div>

                                    <?php  endif; ?>

                            <?php else : //TIENE TEXTO E IMAGEN
                                    if ($contpublicacion==0) : //ES EL PRIMER ELEMENTO
                                    ?>
                                        <div class="carousel-item active">
                                            <div class="divflex">
                                                <div class="img">
                                                    <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>    
                                                </div>

                                                <div class="txtimg">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje'])?></p> <br>
                                                </div>  
                                            </div>
                                        </div>
                                    
                                    <?php else : ?>
                                        
                                        <div class="carousel-item">
                                            <div class="divflex">
                                                <div class="img">
                                                    <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>
                                                </div>
                                                
                                                <div class="txtimg">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje']) ?></p> <br>
                                                </div>
                                            </div>
                                        </div>

                            <?php
                                    endif;
                                endif; //FIN DEL IF QUE DETERMINA SI ES IMAGEN TEXTO O MIXTA
                            $contpublicacion++;
                            endforeach;
                            ?>
                        </div> <!-- FIN carousel-inner align-top -->
               
                <?php else : 
                    //REALIZAMOS UNA CONSULTA PARA BUSCAR LAS PUBLICACIONES POR DEFECTO
                    $resultado = porDefecto();
                    $contpublicacion = 0;
                    if ($resultado) :
                ?>
                
                <div class='carousel-publicaciones'>
                    <div id="carouselNoticias" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">

                            <?php
                            foreach($resultado as $mensaje) :
                                if ($contpublicacion==0): //SI ES EL PRIMER ELEMENTO
                            ?>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $contpublicacion ?>" class="active" aria-current="true" aria-label="Slide <?php echo $contpublicacion ?>"></button>

                                <?php else : ?>

                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?php echo $contpublicacion ?>" aria-label="Slide <?php echo $contpublicacion?>"></button>

                            <?php  
                                endif;
                                $contpublicacion++;
                            endforeach;
                            ?>

                        </div> <!-- FIN CAROUSEL-INDICATORS -->

                        <?php $contpublicacion = 0; ?> <!-- INICIALIZAMOS EL CONTADOR A CERO NUEVAMENTE AL SALIR DEL BUCLE -->
                
                        <div class="carousel-inner align-top">
                            
                            <?php
                            foreach($resultado as $mensaje) :
                                if ($mensaje['imagen']!=NULL && $mensaje['mensaje']==NULL) :  //TIENE SOLO IMAGEN
                                    if ($contpublicacion==0) : //SI ES EL PRIMER ELEMENTO
                            ?>

                                    <div class="carousel-item active">
                                        <div class="divflex">
                                            <div class="soloimg">
                                                <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>      
                                            </div>
                                        </div>
                                    </div>

                                    <?php else : ?> <!-- SI NO ES EL PRIMER ELEMENTO -->
                                    
                                    <div class="carousel-item">
                                        <div class="divflex">
                                            <div class="soloimg">
                                                <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    endif;
                                    
                                elseif ($mensaje['imagen']==NULL && $mensaje['mensaje']!=NULL) : //TIENE SOLO MENSAJE
                                    if ($contpublicacion==0) : //SI ES EL PRIMER ELEMENTO
                                    ?>
                                        <div class="carousel-item active">
                                            <div class="divflex">
                                                <div class="txt">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje']) ?></p> <br>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    <?php else : ?>

                                        <div class="carousel-item">
                                            <div class="divflex">
                                                <div class="txt">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje']) ?></p> <br>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif; ?>
                                    
                            <?php else : //TIENE TEXTO E IMAGEN
                                    if ($contpublicacion==0) : //ES EL PRIMER ELEMENTO
                                    ?>
                                        <div class="carousel-item active">
                                            <div class="divflex">
                                                <div class="img">
                                                    <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>    
                                                </div>

                                                <div class="txtimg">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje'])?></p> <br>
                                                </div>  
                                            </div>
                                        </div>
                                    
                                    <?php else : ?>
                                        
                                        <div class="carousel-item">
                                            <div class="divflex">
                                                <div class="img">
                                                    <img src="img/userImage/<?php echo $mensaje['imagen'] ?>" class="d-block mx-auto" alt="..."> <br>
                                                </div>
                                                
                                                <div class="txtimg">
                                                    <h3><?php echo $mensaje['titulo'] ?></h3> <br>
                                                    <p class="d-block mx-auto fs-5"><?php echo nl2br($mensaje['mensaje']) ?></p> <br>
                                                </div>
                                            </div>
                                        </div>

                            <?php
                                    endif;
                                endif; //FIN DEL IF QUE DETERMINA SI ES IMAGEN TEXTO O MIXTA
                            $contpublicacion++;
                            endforeach;
                            ?>
                        </div> <!-- FIN carousel-inner align-top -->
                        

                    <?php else : ?>
                        <p>La base de datos no tiene registrada ninguna publicación por defecto</p>
                    
                    <?php
                        endif;
                    ?>
                
                <?php 
                endif; //FIN DEL IF PUBLICACION
                ?>

                    </div> <!-- FIN carouselNoticias -->
                </div> <!-- FIN carouselPublicaciones -->

                <?php 
                $stm2->closeCursor(); //CIERRA EL FETCH ANTERIOR EVITANDO ERRORES

                $pantalla = $stm1->fetch();
                ?>
                <br>
            </div> <!-- FIN carousel-pantalla -->

            <?php endwhile ?>
    </section>

    <!-- ==================== FIN VISTA DE PANTALLAS ==================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>