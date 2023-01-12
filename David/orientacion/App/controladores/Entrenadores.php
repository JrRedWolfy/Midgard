<?php
    class Entrenadores extends Controlador{
        public function __construct(){
            $this->entrenadorModelo = $this->modelo('Entrenador');
        }

        public function index(){
            echo "Metodo Index cargado";
            $atletas = $this->entrenadorModelo->obtenerAtletas();

            $datos["atletas"] = $atletas;

            $this->vista("paginas/index", $datos);
        }

        /*
        public function add(){
            $colores =[
                'rojo' => 'red',
                'azul' => 'blue',
                'blanco' => 'white'
            ];

            //$this->vista("paginas/index", "ola k ase");
            $this->vista("paginas/index", $colores);
        }
        */
        


    }
?>