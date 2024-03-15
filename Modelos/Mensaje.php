<?php

    class Mensaje{

        private $id;
        private $idRemitente;
        private $contenido;
        private $fechaEnvio;
        private $horaEnvio;
        private $db;

        public function __construct(){
            $this -> db = BaseDeDatos::connect();
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function getIdRemitente(){
            return $this->idRemitente;
        }

        public function setIdRemitente($idRemitente){
            $this->idRemitente = $idRemitente;
            return $this;
        }

        public function getContenido(){
            return $this->contenido;
        }

        public function setContenido($contenido){
            $this->contenido = $contenido;
            return $this;
        }

        public function getFechaEnvio(){
            return $this->fechaEnvio;
        }

        public function setFechaEnvio($fechaEnvio){
            $this->fechaEnvio = $fechaEnvio;
            return $this;
        }

        public function getHoraEnvio(){
            return $this->horaEnvio;
        }

        public function setHoraEnvio($horaEnvio){
            $this->horaEnvio = $horaEnvio;
            return $this;
        }

        /*
        Funcion para guardar el mensaje en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO mensajes VALUES(NULL, {$this -> getIdRemitente()}, 
                '{$this -> getContenido()}', '{$this -> getFechaEnvio()}', 
                '{$this -> getHoraEnvio()}')";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
            //Establecer una variable bandera
            $resultado = false;
            //Comporbar el registro fue exitoso y el total de columnas afectadas se altero
            if($registro && mysqli_affected_rows($this -> db) > 0){
                //Cambiar el estado de la variable bandera
                $resultado = true;
            }
            //Retornar el resultado
            return $resultado;
        }

        /*Funcion para obtener el id del ultimo mensaje enviado*/

        public function ultimo(){
            //Construir la consulta
            $consulta = "SELECT id FROM mensajes ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimoMensaje = $ultimo -> id;
            //Retornar el resultado
            return $ultimoMensaje;
        }
    }

?>