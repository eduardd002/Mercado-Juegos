<?php

    class VideojuegoCategoria{

        private $id;
        private $idVideojuego;
        private $categoriaId;

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

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        public function getCategoriaId(){
            return $this->categoriaId;
        }

        public function setCategoriaId($categoriaId){
            $this->categoriaId = $categoriaId;
            return $this;
        }
    }

?>