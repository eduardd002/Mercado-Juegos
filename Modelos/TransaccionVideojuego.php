<?php

    class TransaccionVideojuego{

        private $id;
        private $idCompra;
        private $idVideojuego;
        private $unidades;
        private $nombreVideojuego;
        private $precioVideojuego;
        private $categoriaVideojuego;
        private $consolaVideojuego;

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
 
        public function getIdCompra(){
            return $this->idCompra;
        }

        public function setIdCompra($idCompra){
            $this->idCompra = $idCompra;
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

        public function getCategoriaVideojuego(){
            return $this->categoriaVideojuego;
        }

        public function setCategoriaVideojuego($categoriaVideojuego){
            $this->categoriaVideojuego = $categoriaVideojuego;
            return $this;
        }

        public function getConsolaVideojuego(){
            return $this->consolaVideojuego;
        }

        public function setConsolaVideojuego($consolaVideojuego){
            $this->consolaVideojuego = $consolaVideojuego;
            return $this;
        }
    }

?>