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
    }

?>