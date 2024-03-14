<?php

    class Chat{

        private $id;
        private $idMensaje;
        private $idDestinatario;
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

        public function getIdMensaje(){
            return $this->idMensaje;
        }

        public function setIdMensaje($idMensaje){
            $this->idMensaje = $idMensaje;
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
        Funcion para guardar el chat en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO chats VALUES(NULL, {$this -> getIdMensaje()}, {$this -> getIdDestinatario()})";
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
    }

?>