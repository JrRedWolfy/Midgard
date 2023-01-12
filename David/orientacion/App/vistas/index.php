
<?php require_once RUTA_APP.'/vistas/inc/header.php'?>

    <div class="row d-flex justify-content-center text-center mt-3">
        <div class="col-12">
            <h1>Asesorias Pendientes</h1>
        </div>
    </div>

    <!-- ?php print_r($datos);?> -->


    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a class="btn btn-primary me-md-2" href="<?php echo RUTA_URL ?>/asesorias/addAsesoria" type="button"><h2>+</h2></a>
    </div>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>


    

        <table class="table table-dark table-striped">

            <thead>
                <tr>
                    <th scope="col">Id_Asesoria</th>
                    <td scope="col">Titulo</td>
                    <td scope="col">Datos Personales</td>
                    <td scope="col">Descripcion</td>
                    <td scope="col">Domicilio</td>
                    <td scope="col">Fecha Inicio</td>
                    <td scope="col">Estado</td>
                    <td scope="col">Funciones</td>
                </tr>

            </thead>

            <tbody>
                <?php foreach($datos["asesoriasActivas"] as $asesoria):?>

                <tr>
                    <th scope="row"><?php echo $asesoria->id_asesoria;?></th>
                    <td><?php echo $asesoria->titulo_as;?></td>
                    <td><?php 
                        echo ($asesoria->dni_as) ? "DNI: ".$asesoria->dni_as.'</br>' : "";
                        echo ($asesoria->nombre_as) ? "Nombre: ".$asesoria->nombre_as.'</br>' : "";
                        echo ($asesoria->telefono_as) ? "Telefono: ".$asesoria->telefono_as.'</br>' : "";
                        echo ($asesoria->email_as) ? "Email: ".$asesoria->email_as : "";?>
                    </td>
                    <td><?php echo $asesoria->descripcion_as;?></td>
                    <td><?php echo $asesoria->domicilio_as;?></td>
                    <td><?php echo formatFecha($asesoria->fecha_inicio);?></td>
                    <td>
                        
                        <?php if($asesoria->id_estado == 1): ?>
                        <p class="text-success"> <?php echo $asesoria->estado;?> </p>
                        <?php else: ?>
                        <p class="text-warning"> <?php echo $asesoria->estado;?> </p>
                        <?php endif ?>
                    
                    </td>
                    <td>
                        <div class="botonForm">
                            <a href="<?php echo RUTA_URL ?>/asesorias/seeAsesoria/<?php echo $asesoria->id_asesoria?>" type="button">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <div class="botonForm">
                            <a href="<?php echo RUTA_URL ?>/asesorias/editAsesoria/<?php echo $asesoria->id_asesoria?>" type="button">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="botonForm">
                            <a href="">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                        
                    </td>
                </tr>

                <?php endforeach ?>

            </tbody>
            

        </table>
    </div>
    


    
<?php require_once RUTA_APP.'/vistas/inc/footer.php'?>