<?php
    class AsesoriaModelo{
        private $db;

        public function __construct(){
            $this->db = new Base;
        }

        public function addAsesoria($datos){
            
            $this->db->query("INSERT INTO asesoria(nombre_as, dni_as, titulo_as, telefono_as, email_as, descripcion_as, domicilio_as, fecha_inicio, id_estado) VALUES (:nombre_as, :dni_as, :titulo_as, :telefono_as, :email_as, :descripcion_as, :domicilio_as, NOW(), 1)");

            $this->db->bind(':nombre_as', trim($datos['nombreF']));
            $this->db->bind(':dni_as', trim($datos['dniF']));
            $this->db->bind(':titulo_as', trim($datos['titulo']));
            $this->db->bind(':telefono_as', trim($datos['tlfn']));
            $this->db->bind(':email_as', trim($datos['email']));
            $this->db->bind(':descripcion_as', trim($datos['descF']));
            $this->db->bind(':domicilio_as', trim($datos['domi']));

            if($this->db->execute()){

                //$this->db->query("INSERT INTO reg_acciones(fecha_reg, accion, automatica, id_asesoria, id_profesor) VALUES (NOW(), 'Inicio', 1, :id_asesoria, 1)");
                //$this->db->bind(':id_asesoria', trim($datos['id_asesoria']));

                //$this->db->execute();

                return true;
            } else {
                return false;
            }

        }

        public function getAccionesAsesoria($id_asesoria){
            
            $this->db->query("SELECT p.nombre_completo, e.fecha_reg, e.accion, e.automatica FROM asesoria a, reg_acciones e, profesores p
                                        WHERE e.id_asesoria = :id_asesoria AND p.id_profesor = e.id_profesor AND e.id_asesoria = a.id_asesoria");

            $this->db->bind(':id_asesoria', $id_asesoria);

            return $this->db->registros();
        }


        public function getAsesoria($id_asesoria){
            
            $this->db->query("SELECT * FROM asesoria a, estados e 
                                        WHERE a.id_estado = e.id_estado AND a.id_asesoria = :id_asesoria");

            $this->db->bind(':id_asesoria', $id_asesoria);

            return $this->db->registro();
        }

        public function editAsesoria($datos, $id_asesoria){
            
            $this->db->query("UPDATE asesoria a 
                                        SET nombre_as = :nombre_as, dni_as = :dni_as, titulo_as = :titulo_as, telefono_as = :telefono_as, email_as = :email_as, descripcion_as = :descripcion_as, domicilio_as = :domicilio_as
                                        WHERE a.id_asesoria = :id_asesoria");

            $this->db->bind(':nombre_as', trim($datos['nombreF']));
            $this->db->bind(':dni_as', trim($datos['dniF']));
            $this->db->bind(':titulo_as', trim($datos['titulo']));
            $this->db->bind(':telefono_as', trim($datos['tlfn']));
            $this->db->bind(':email_as', trim($datos['email']));
            $this->db->bind(':descripcion_as', trim($datos['descF']));
            $this->db->bind(':domicilio_as', trim($datos['domi']));
            $this->db->bind(':id_asesoria', $id_asesoria);

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }


        public function listarAsesorias(){
            
            $this->db->query("SELECT * FROM asesoria a, estados e 
                                        WHERE a.id_estado = e.id_estado AND (a.id_estado = 1 OR a.id_estado = 2) 
                                        ORDER BY fecha_inicio DESC");

            return $this->db->registros();
        }

        public function getProfesor($id_profesor){
            
            $this->db->query("SELECT * FROM profesores p 
                                        WHERE p.id_profesor = :id_profesor");

            $this->db->bind(':id_profesor', $id_profesor);
            return $this->db->registro();
        }

        public function getRoles($id_profesor){
            
            $this->db->query("SELECT r.id_rol, r.rol, p.id_departamento FROM profesores_departamento p , rol r 
                                                    WHERE p.rol_id_rol = r.id_rol AND p.id_profesor = :id_profesor");
            $this->db->bind(':id_profesor', $id_profesor);

            return $this->db->registros();
        }



        /*
        public function obtenerAtletas(){
            $this->db->query("SELECT * from atletas");
            return $this->db->registros();
        }*/

    }

?>