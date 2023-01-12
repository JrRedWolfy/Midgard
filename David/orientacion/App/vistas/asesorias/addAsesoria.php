<?php require_once RUTA_APP.'/vistas/inc/header.php'?>

    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo RUTA_URL?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Añadir Asesoria</li>
            </ol>
        </nav>


        <h1>Add Asesoria</h1>

        <form action="" method="POST">

            <?php if($datos["error"] == 1): ?>
                <div class="alert alert-danger" role="alert">
                    Se han de rellenar todos los campos
                </div>
            <?php endif ?>


            <div class="row">
                <div class="mb-3 col-4">
                    <label for="nombreF" class="form-label">Nombre</label>
                    <input type="text" for="form-control-sm" name="nombreF" class="NombreF" id="imnombre" aria-describedby="emailHelp">
                </div>
                

                <div class="mb-3 col-4">
                    <label for="dniF" class="form-label">DNI</label>
                    <input type="text" for="form-control form-control-sm" name="dniF" class="dniF" id="imdni" aria-describedby="emailHelp">
                </div>


                <div class="mb-3 col-4">
                    <label for="titloF" class="form-label">Titulo</label>
                    <input type="text" for="form-control form-control-sm" name="titulo" class="tituloF" id="imtitulo" aria-describedby="emailHelp">
                </div>


                <div class="mb-3 col-4">
                    <label for="tlfnF" class="form-label">Telefono</label>
                    <input type="text" for="form-control form-control-sm" name="tlfn" class="tlfnF" id="imtlfn" aria-describedby="emailHelp">
                </div>


                <div class="mb-3 col-4">
                    <label for="emailF" class="form-label">Email</label>
                    <input type="email" for="form-control form-control-sm" name="email" class="emailF" id="imemail" aria-describedby="emailHelp">
                </div>


                <div class="mb-3 col-4">
                    <label for="domiF" class="form-label">Domicilio</label>
                    <input type="text" for="form-control form-control-sm" name="domi" class="domiF" id="imdomi" aria-describedby="emailHelp">
                </div>


                <div class="mb-3">
                    <label for="descF" class="form-label">Descripción</label>
                    <textarea type="text" cols="18" rows="4" for="form-control form-control-sm" name="descF" class="descF" id="imdesc"></textarea>
                </div>

            </div>

            



            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="form-control form-control-sm" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    

<?php require_once RUTA_APP.'/vistas/inc/footer.php'?>