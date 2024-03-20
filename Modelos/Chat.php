<?php

    class Chat{

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

        public function getIdDestinatario(){
            return $this->idDestinatario;
        }

        public function setIdDestinatario($idDestinatario){
            $this->idDestinatario = $idDestinatario;
            return $this;
        }

        /*
        Funcion para guardar el mensaje en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO chats VALUES(NULL, {$this -> getIdRemitente()}, 
                {$this -> getIdDestinatario()}, '{$this -> getContenido()}', 
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

        /*
        Funcion para listar todos los mensajes enviados
        */

        public function listarMensajesEnviados(){
            //Construir la consulta
            $consulta = "SELECT * FROM chats WHERE idRemitente = {$this -> getIdRemitente()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        /*
        Funcion para listar todos los mensajes recibidos
        */

        public function listarMensajesRecibidos(){
            //Construir la consulta
            $consulta = "SELECT * FROM chats WHERE idDestinatario = {$this -> getIdRemitente()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }
    }

?>