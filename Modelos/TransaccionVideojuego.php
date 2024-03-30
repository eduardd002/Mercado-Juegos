<?php

    class TransaccionVideojuego{

        private $id;
        private $idTransaccion;
        private $idVideojuego;
        private $unidades;
        private $nombreVideojuego;
        private $precioVideojuego;
        private $usoVideojuego;
        private $consolaVideojuego;
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
 
        public function getIdTransaccion(){
            return $this->idTransaccion;
        }

        public function setIdTransaccion($idTransaccion){
            $this->idTransaccion = $idTransaccion;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        public function getUnidades(){
            return $this->unidades;
        }

        public function setUnidades($unidades){
            $this->unidades = $unidades;
            return $this;
        }

        public function getNombreVideojuego(){
            return $this->nombreVideojuego;
        }

        public function setNombreVideojuego($nombreVideojuego){
            $this->nombreVideojuego = $nombreVideojuego;
            return $this;
        }

        public function getPrecioVideojuego(){
            return $this->precioVideojuego;
        }

        public function setPrecioVideojuego($precioVideojuego){
            $this->precioVideojuego = $precioVideojuego;
            return $this;
        }

        public function getUsoVideojuego(){
            return $this->usoVideojuego;
        }

        public function setUsoVideojuego($usoVideojuego){
            $this->usoVideojuego = $usoVideojuego;
            return $this;
        }

        public function getConsolaVideojuego(){
            return $this->consolaVideojuego;
        }

        public function setConsolaVideojuego($consolaVideojuego){
            $this->consolaVideojuego = $consolaVideojuego;
            return $this;
        }

        /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO transaccionvideojuego VALUES(NULL, {$this -> getIdTransaccion()}, 
                {$this -> getIdVideojuego()}, {$this -> getUnidades()}, '{$this -> getNombreVideojuego()}', 
                {$this -> getPrecioVideojuego()}, '{$this -> getUsoVideojuego()}', 
                '{$this -> getConsolaVideojuego()}')";
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