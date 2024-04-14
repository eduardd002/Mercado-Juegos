<?php

    class CarritoVideojuego{

        private $id;
        private $activo;
        private $idVideojuego;
        private $idCarrito;
        private $unidades;
        private $precio;
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

        public function getActivo(){
            return $this->activo;
        }

        public function setActivo($activo){
            $this->activo = $activo;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        public function getIdFavorito(){
            return $this->idCarrito;
        }

        public function setIdCarrito($idCarrito){
            $this->idCarrito = $idCarrito;
            return $this;
        }

        public function getPrecio(){
            return $this->precio;
        }

        public function setPrecio($precio){
            $this->precio = $precio;
            return $this;
        }

                /**
         * Get the value of unidades
         */ 
        public function getUnidades()
        {
                return $this->unidades;
        }

        /**
         * Set the value of unidades
         *
         * @return  self
         */ 
        public function setUnidades($unidades)
        {
                $this->unidades = $unidades;

                return $this;
        }

        /*
        Funcion para guardar la relacion entre videojuego y favorito en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO carritovideojuego VALUES(NULL, {$this -> getActivo()}, 
                {$this -> getIdVideojuego()}, {$this -> getIdFavorito()}, {$this -> getUnidades()}, 
                {$this -> getPrecio()})";
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