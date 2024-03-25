<?php

    class Chat{

        private $id;
        private $idUsuario;
        private $idContacto;
        private $fechaCreacion;
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

        public function getIdContacto(){
            return $this->idContacto;
        }

        public function setIdContacto($idContacto){
            $this->idContacto = $idContacto;
            return $this;
        }

        public function getFechaCreacion(){
            return $this->fechaCreacion;
        }

        public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
            return $this;
        }

        /*
        Funcion para guardar el chat en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO chats VALUES (NULL, {$this -> getIdUsuario()}, {$this -> getIdContacto()}, {$this -> fechaCreacion})";
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
        Funcion para traer el listado de chats que tiene un usuario en particular
        */

        public function obtenerChats(){
            //Construir la consulta
            $consulta = "SELECT * FROM chats WHERE idUsuario = {$this -> getIdUsuario()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar el resultado
            return $resultado;
        }
    }

?>