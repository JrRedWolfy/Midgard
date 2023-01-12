<?php require_once RUTA_APP.'/vistas/inc/header.php'?>

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo RUTA_URL?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ver Asesoria</li>
            </ol>
        </nav>


        <h1><?php echo $datos['asesoria']->titulo_as ?></h1>

        

        <div class="row">
            <div class="mb-3 col-6">
                <div class="infoCard">
                    <h3>Información del Asesorado</h3>
                    <p><span>Nombre:</span> <?php echo $datos['asesoria']->nombre_as ?></p>
                    <p><span>DNI:</span> <?php echo $datos['asesoria']->dni_as ?></p>
                    <p><span>Telefono:</span> <?php echo $datos['asesoria']->telefono_as ?></p>
                    <p><span>Email:</span> <?php echo $datos['asesoria']->email_as ?></p>
                    <p><span>Domicilio:</span> <?php echo $datos['asesoria']->domicilio_as ?></p>
                </div>
                
            </div>
            <div class="mb-3 col-6">
                <div class="infoCard">
                    <h3>Información de la Asesoria</h3>
                    <p><span>Fecha de Creacion:</span> <?php echo $datos['asesoria']->fecha_inicio ?></p>
                    <p><span>Titulo:</span> <?php echo $datos['asesoria']->titulo_as ?></p>
                    <p><span>Descripcion:</span> <?php echo $datos['asesoria']->descripcion_as ?></p>
                    <?php if($datos['asesoria']->fecha_fin != null):?>
                        <p><span>Fecha de Finalizacion:</span> <?php echo $datos['asesoria']->fecha_fin ?></p>
                    <?php else:?>
                        <p><span>Fecha de Finalizacion:</span> Sin Concluir</p>
                    <?php endif ?>
                    <p><span>Estado:</span> <?php echo $datos['asesoria']->estado ?></p>
                </div>
                
            </div>
        </div>

        <form action="" method="POST">

            <div class="row">
                <div class="mb-3 col-4">
                    <label for="nombreF" class="form-label">Nombre</label>
                    <input type="text" for="form-control-sm" name="nombreF" class="NombreF" id="imnombre" aria-describedby="emailHelp" value="<?php echo $datos['asesoria']->nombre_as ?>">
                </div>
                

                <div class="mb-3 col-4">
                    <label for="dniF" class="form-label">DNI</label>
                    <input type="text" for="form-control form-control-sm" name="dniF" class="dniF" id="imdni" aria-describedby="emailHelp" value="<?php echo $datos['asesoria']->dni_as ?>">
                </div>


                <div class="mb-3 col-4">
                    <label for="titloF" class="form-label">Titulo</label>
                    <input type="text" for="form-control form-control-sm" name="titulo" class="tituloF" id="imtitulo" aria-describedby="emailHelp" value="<?php echo $datos['asesoria']->titulo_as ?>">
                </div>


                <div class="mb-3 col-4">
                    <label for="tlfnF" class="form-label">Telefono</label>
                    <input type="text" for="form-control form-control-sm" name="tlfn" class="tlfnF" id="imtlfn" aria-describedby="emailHelp" value="<?php echo $datos['asesoria']->telefono_as ?>">
                </div>


                <div class="mb-3 col-4">
                    <label for="emailF" class="form-label">Email</label>
                    <input type="email" for="form-control form-control-sm" name="email" class="emailF" id="imemail" aria-describedby="emailHelp" value="<?php echo $datos['asesoria']->email_as ?>">
                </div>


                <div class="mb-3 col-4">
                    <label for="domiF" class="form-label">Domicilio</label>
                    <input type="text" for="form-control form-control-sm" name="domi" class="domiF" id="imdomi" aria-describedby="emailHelp" value="<?php echo $datos['asesoria']->domicilio_as ?>">
                </div>


                <div class="mb-3">
                    <label for="descF" class="form-label">Descripción</label>
                    <textarea type="text" cols="18" rows="4" for="form-control form-control-sm" name="descF" class="descF" id="imdesc"><?php echo $datos['asesoria']->descripcion_as ?></textarea>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>





        
        <h2>Acciones</h2>

        <div class="row">

        <?php foreach($datos['asesoria']->acciones as $accion):?>

            <div class="mb-3 col-6">
                <div class="infoCard">
                    <h3>Accion</h3>
                    <p><span>Fecha:</span> <?php echo $accion->fecha_reg;?></p>
                    <p><span>Descripcion:</span> <?php echo $accion->accion;?></p>
                    <p><span>Automatica:</span> <?php echo $accion->automatica;?></p>
                    <p><span>Profesor:</span> <?php echo $accion->nombre_completo;?></p>
                </div>
                
            </div>
        <?php endforeach ?>
        </div>
    </div>

    

<?php require_once RUTA_APP.'/vistas/inc/footer.php'?>