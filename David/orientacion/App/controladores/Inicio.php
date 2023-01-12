<?php
    class Inicio extends Controlador{
        public function __construct(){
            // echo 'Inicio controlador cargado';
            $this->datos["menuActivo"] = "home";
            $this->asesoriaModelo = $this->modelo('AsesoriaModelo');

            $this->datos["usuarioSesion"] = $this->asesoriaModelo->getProfesor(2);
            $this->datos["usuarioSesion"]->roles = $this->asesoriaModelo->getRoles($this->datos["usuarioSesion"]->id_profesor);
            

            $this->datos["usuarioSesion"]->id_rol = obtenerRol($this->datos["usuarioSesion"]->roles);

            print_r($this->datos["usuarioSesion"]);
            

            
        }

        public function index(){
            
            $this->datos["asesoriasActivas"] = $this->asesoriaModelo->listarAsesorias();

            $this->vista("index", $this->datos);
        }
    }

    
?>