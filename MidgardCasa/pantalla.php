<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla</title>
    <!-- BOOTSTRAP LIBRARY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- HOJA DE ESTILOS -->
    <link rel="stylesheet" href="css/preloader.css">
    <link rel="stylesheet" href="css/indexStyle.css">
    <link rel="stylesheet" href="css/carousel.css">
</head>
<body>
    
<section class="container-fluid">



<?php 
    $ip_cliente = $_SERVER["REMOTE_ADDR"];
    // echo "La ip del cliente es: ".$ip_cliente."<br>";
    
    //MAC PANTALLA
    $comando= shell_exec("arp -a ".$ip_cliente);
    $separador = explode(" ", $comando);
    
    $mac_cliente = $separador[3];
            
    //OBTENEMOS LA FECHA ACTUAL
    $hoy = getdate();
    $fechaActual = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];
            
    //UTILIZAMOS EL PROCEDURE QUE ME LISTA LAS PUBLICACIONES DE LA PANTALLA QUE LE MANDE
    include_once "php/base.php"; conexion(); 
    $con = conexion();
    $procedure = "CALL  publicacionPantalla ('$mac_cliente', '$fechaActual')";//echo $procedure;
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

        ?>
        <br>
</section> 



</body>
</html>