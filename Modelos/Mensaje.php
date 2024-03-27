<?php

    class Mensaje{

        private $id;
        private $idRemitente;
        private $idDestinatario;
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

                /**
         * Get the value of idRemitente
         */ 
        public function getIdRemitente()
        {
                return $this->idRemitente;
        }

        /**
         * Set the value of idRemitente
         *
         * @return  self
         */ 
        public function setIdRemitente($idRemitente)
        {
                $this->idRemitente = $idRemitente;

                return $this;
        }

        /**
         * Get the value of idDestinatario
         */ 
        public function getIdDestinatario()
        {
                return $this->idDestinatario;
        }

        /**
         * Set the value of idDestinatario
         *
         * @return  self
         */ 
        public function setIdDestinatario($idDestinatario)
        {
                $this->idDestinatario = $idDestinatario;

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

        /*Funcion para guardar un mensaje en la base de datos*/

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT IGNORE INTO mensajes VALUES(NULL, {$this -> getIdRemitente()}, 
            {$this -> getIdDestinatario()}, '{$this -> getContenido()}', '{$this -> getFechaEnvio()}', 
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

        /*
        Funcion para obtener todos los mensajes
        */

        public function obtenerMensajes(){
            //Construir la consulta
            $consulta = "SELECT * FROM mensajes WHERE idRemitente = {$this -> getIdRemitente()} 
                AND idDestinatario = {$this -> getIdDestinatario()} ORDER BY id ASC";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar el resultado
            return $resultado;
        }
    }

?>