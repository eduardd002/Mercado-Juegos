<?php

    class Videojuego{

        private $id;
        private $idConsola;
        private $idUso;
        private $idClasificacion;
        private $nombre;
        private $precio;
        private $descripcion;
        private $foto;
        private $fechaCreacion;
        private $stock;

        public function __construct(){
            BaseDeDatos::connect();
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function getIdConsola(){
            return $this->idConsola;
        }

        public function setIdConsola($idConsola){
            $this->idConsola = $idConsola;
            return $this;
        }

        public function getIdUso(){
            return $this->idUso;
        }

        public function setIdUso($idUso){
            $this->idUso = $idUso;
            return $this;
        }

        public function getIdClasificacion(){
            return $this->idClasificacion;
        }

        public function setIdClasificacion($idClasificacion){
            $this->idClasificacion = $idClasificacion;
            return $this;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
            return $this;
        }

        public function getPrecio(){
            return $this->precio;
        }

        public function setPrecio($precio){
            $this->precio = $precio;
            return $this;
        }

        public function getDescripcion(){
            return $this->descripcion;
        }

        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
            return $this;
        }

        public function getFoto(){
            return $this->foto;
        }

        public function setFoto($foto){
            $this->foto = $foto;
            return $this;
        }

        public function getFechaCreacion(){
            return $this->fechaCreacion;
        }

        public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
            return $this;
        }

        public function getStock(){
            return $this->stock;
        }

        public function setStock($stock){
            $this->stock = $stock;
            return $this;
        }
    }

?>