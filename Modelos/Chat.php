<?php

    class Chat{

        private $id;
        private $mensaje;
        private $idComprador;
        private $idVendedor;
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

        public function getMensaje(){
            return $this->mensaje;
        }

        public function setMensaje($mensaje){
            $this->mensaje = $mensaje;
            return $this;
        }

        public function getIdComprador(){
            return $this->idComprador;
        }

        public function setIdComprador($idComprador){
            $this->idComprador = $idComprador;
            return $this;
        }

        public function getIdVendedor(){
            return $this->idVendedor;
        }

        public function setIdVendedor($idVendedor){
            $this->idVendedor = $idVendedor;
            return $this;
        }

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO chats VALUES(NULL, '{$this -> getMensaje()}', {$this -> getIdComprador()}, {$this -> getIdVendedor()})";
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