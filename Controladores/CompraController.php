<?php

    ob_start();

    //Importar archivo de ayuda para generar el PDF
    require_once 'Ayudas/GenerarPdf.php';

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

        public function generarFactura(){
            //Cargar la vista

            require_once "Vistas/Compra/Factura.html";
        }

        public function generarPdf(){

            //Traer la vista de la compra
            require_once('Vistas/Compra/Factura.html');

            //Llamar la funcion que genera el PDF
            GenerarPdf::pdf();
        }

    }

?>