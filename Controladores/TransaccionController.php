<?php

    /*OBS_START(); para */
    ob_start();

    //Incluir archivo de ayuda para generar el PDF
    require_once 'Ayudas/GenerarPdf.php';

    //Incluir el objeto de transaccion
    require_once 'Modelos/Transaccion.php';

    class TransaccionController{

        /*
        Funcion para ver el formulario de direccion al comprar un videojuego
        */

        public function direccion(){

            //Incluir la vista
            require_once "Vistas/Compra/Envio.html";

        }

        /*
        Funcion para ver el formulario de pago al comprar un videojuego
        */

        public function pago(){

            //Incluir la vista
            require_once "Vistas/Compra/Pago.html";

        }

        /*
        Funcion para ver el mensaje de exito al comprar un videojuego de manera correcta
        */

        public function exito(){

            //Incluir la vista
            require_once "Vistas/Compra/Exito.html";
        }

        /*
        Funcion para ver el detalle de la compra realizada
        */

        public function verCompras(){

            //Incluir la vista
            require_once "Vistas/Compra/Factura.html";
        }

        /*
        Funcion para ver el detalle de la venta realizada
        */

        public function verVentas(){

            //Incluir la vista
            require_once "Vistas/Venta/Detalle.html";
        }

        /*Funcion para generar reporte de factura en formato PDF*/

        public function generarPdf(){

            //Incluir la vista de la compra
            require_once('Vistas/Compra/Factura.html');

            //Llamar la funcion de ayuda que genera el archivo PDF
            GenerarPdf::pdf();
        }

    }

?>