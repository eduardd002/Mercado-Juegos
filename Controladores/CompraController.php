<?php

    class CompraController{

        public function direccion(){
            //Cargar la vista

            require_once "Vistas/Compra/Envio.html";
        }

        public function pago(){
            //Cargar la vista

            require_once "Vistas/Compra/Pago.html";
        }

        public function exito(){
            //Cargar la vista

            require_once "Vistas/Compra/Exito.html";
        }

        public function ver(){
            //Cargar la vista

            require_once "Vistas/Compra/Detalle.html";
        }

    }

?>