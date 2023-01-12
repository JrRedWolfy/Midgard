<?php
    class Asesorias extends Controlador{
        public function __construct(){
            // echo 'Inicio controlador cargado';
            $this->datos["menuActivo"] = "asesorias";

            $this->asesoriaModelo = $this->modelo('AsesoriaModelo');
        }

        public function index(){
            
            $this->vista("asesorias/index", $this->datos);
        }



        public function addAsesoria($error = 0){

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo("Ursaring");
                $asesoria = $_POST;

                if(!$_POST["nombreF"] || !$_POST["dniF"] || !$_POST["titulo"] || !$_POST["tlfn"] || !$_POST["email"] || !$_POST["descF"] || !$_POST["domi"]){
                    echo "Gengar";
                    redireccionar('/asesorias/addAsesoria/1');
                } else {
                    echo "Plusle";
                    if($this->asesoriaModelo->addAsesoria($asesoria)){
                    
                    } else {
                        echo "Pupitar";
                    }
                }


                

                
            } else {
                $this->datos["menuActivo"] = "";
                $this->datos["error"] = $error;

                $this->vista("asesorias/addAsesoria", $this->datos);
            }

        }

        public function seeAsesoria($id_asesoria){

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
               $asesoria = $_POST; 
               if ($this->asesoriaModelo->editAsesoria($asesoria, $id_asesoria)){
                redireccionar("/asesorias/seeAsesoria/$id_asesoria");
               } else {
                echo("Piplup");
               }

            } else {
                $this->datos['asesoria'] = $this->asesoriaModelo->getAsesoria($id_asesoria);
                $this->datos['asesoria']->acciones = $this->asesoriaModelo->getAccionesAsesoria($id_asesoria);
                print_r($this->datos['asesoria']);
                $this->vista("asesorias/seeAsesoria", $this->datos);
            }

        }



    }

    
?>