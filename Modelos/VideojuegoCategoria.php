<?php

    class VideojuegoCategoria{

        private $id;
        private $idVideojuego;
        private $categoriaId;

        public function __construct(){
            BaseDeDatos::connect();
        }
    }

?>