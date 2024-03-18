<?php

    class Pago{

        private $id;
        private $idTarjeta;
        private $numeroTarjeta;
        private $titular;
        private $codigoSeguridad;
        private $fechaExpedicion;
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

        public function getIdTarjeta(){
            return $this->idTarjeta;
        }

        public function setIdTarjeta($idTarjeta){
            $this->idTarjeta = $idTarjeta;
            return $this;
        }

        public function getNumeroTarjeta(){
            return $this->numeroTarjeta;
        }

        public function setNumeroTarjeta($numeroTarjeta){
            $this->numeroTarjeta = $numeroTarjeta;
            return $this;
        }

        public function getTitular(){
            return $this->titular;
        }

        public function setTitular($titular){
            $this->titular = $titular;
            return $this;
        }

        public function getCodigoSeguridad(){
            return $this->codigoSeguridad;
        }

        public function setCodigoSeguridad($codigoSeguridad){
            $this->codigoSeguridad = $codigoSeguridad;
            return $this;
        }

        public function getFechaExpedicion(){
            return $this->fechaExpedicion;
        }

        public function setFechaExpedicion($fechaExpedicion){
            $this->fechaExpedicion = $fechaExpedicion;
            return $this;
        }

                /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO pagos VALUES(NULL, {$this -> getIdTarjeta()}, 
                '{$this -> getNumeroTarjeta()}', '{$this -> getTitular()}', 
                '{$this -> getCodigoSeguridad()}', '{$this -> getFechaExpedicion()}')";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
            //Establecer una variable bandera
            $resultado = false;
            //Comprobar el registro fue exitoso y el total de columnas afectadas se altero
            if($registro){
                //Cambiar el estado de la variable bandera
                $resultado = true;
            }
            //Retornar el resultado
            return $resultado;
        }
    }

?>