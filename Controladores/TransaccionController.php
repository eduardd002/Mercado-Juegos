<?php

    /*OBS_START(); para */
    ob_start();

    //Incluir archivo de ayuda para generar el PDF
    require_once 'Ayudas/GenerarPdf.php';

    //Incluir el objeto de transaccion
    require_once 'Modelos/Transaccion.php';

    //Incluir el objeto de tarjeta
    require_once 'Modelos/Tarjeta.php';

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

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

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Listar todos los usuarios desde la base de datos
            $listadoTarjetas = $tarjeta -> listar();
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

            //Instanciar el objeto
            $estado = new Estado();
            //Listar todos los usuarios desde la base de datos
            $listadoEstados = $estado -> listar();
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