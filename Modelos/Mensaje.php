<?php

    class Mensaje{

        private $id;
        private $idUsuario;
        private $idChat;
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

        public function getIdUsuario(){
            return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario){
            $this->idUsuario = $idUsuario;
            return $this;
        }

        public function getIdChat(){
            return $this->idChat;
        }

        public function setIdChat($idChat){
            $this->idChat = $idChat;
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

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT IGNORE INTO mensajes VALUES(NULL, '{$this -> getContenido()}', 
                '{$this -> getFechaEnvio()}', '{$this -> getHoraEnvio()}')";
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

        public function obtenerMensajes(){
            //Construir la consulta
            $consulta = "SELECT * FROM mensajes";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar el resultado
            return $resultado;
        }
    }

?>