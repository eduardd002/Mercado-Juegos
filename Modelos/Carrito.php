<?php

    class Carrito{

        private $id;
        private $idUsuario;
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

        /*
        Funcion para guardar el carrito en la base de datos
        */

        public function guardar(){
            //Construir consulta
            $consulta = "INSERT INTO carritos VALUES({$this -> getIdUsuario()})";
            //Ejecutar la consulta
            $guardado = $this -> db -> query($consulta);
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($guardado && mysqli_affected_rows($this -> db) > 0){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }
    }

?>