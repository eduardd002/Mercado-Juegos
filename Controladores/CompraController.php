<?php

    /*OBS_START(); para */
    ob_start();

    //Importar archivo de ayuda para generar el PDF
    require_once 'Ayudas/GenerarPdf.php';

    class CompraController{

        /*
        Funcion para ver el formulario de direccion al comprar un videojuego
        */

        public function direccion(){

            //Cargar la vista
            require_once "Vistas/Compra/Envio.html";

        }

        /*
        Funcion para ver el formulario de pago al comprar un videojuego
        */

        public function pago(){

            //Cargar la vista
            require_once "Vistas/Compra/Pago.html";

        }

        /*
        Funcion para ver el mensaje de exito al comprar un videojuego de manera correcta
        */

        public function exito(){

            //Cargar la vista
            require_once "Vistas/Compra/Exito.html";
        }

        /*
        Funcion para ver el detalle de la compra realizada
        */

        public function ver(){

            //Cargar la vista
            require_once "Vistas/Compra/Detalle.html";
        }

        /*
        Funcion para ver la factura de la compra realizada
        */

        public function generarFactura(){

            //Cargar la vista
            require_once "Vistas/Compra/Factura.html";
        }

        /*Funcion para generar reporte de factura en formato PDF*/

        public function generarPdf(){

            //Traer la vista de la compra
            require_once('Vistas/Compra/Factura.html');

            //Llamar la funcion de ayuda que genera el archivo PDF
            GenerarPdf::pdf();
        }

    }

?>