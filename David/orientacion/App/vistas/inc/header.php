<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NOMBRE_SITIO?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo RUTA_URL?>/public/css/estilos.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../">Orientación</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
                <?php if (isset($datos["menuActivo"]) && $datos["menuActivo"] == "home"): ?>
                    <a class="nav-link active" aria-current="page" href="<?php echo RUTA_URL ?>">Home</a>
                <?php else: ?>
                    <a class="nav-link" aria-current="page" href="<?php echo RUTA_URL ?>">Home</a>
                <?php endif ?>
             
            </li>
            <li class="nav-item">
                <?php if (isset($datos["menuActivo"]) && $datos["menuActivo"] == "asesorias"): ?>
                    <a class="nav-link active" href="<?php echo RUTA_URL ?>/asesorias">Asesorias</a>
                <?php else: ?>
                    <a class="nav-link" href="<?php echo RUTA_URL ?>/asesorias">Asesorias</a>
                <?php endif ?>
             
              
            </li>
          </ul>
        </div>
      </div>
    </nav>