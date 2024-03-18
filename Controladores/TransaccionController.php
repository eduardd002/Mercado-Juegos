<?php

    /*OBS_START(); para */
    ob_start();

    //Incluir archivo de ayuda para generar el PDF
    require_once 'Ayudas/Ayudas.php';
    // antes ayudas/generarpdf

    //Incluir el objeto de transaccion
    require_once 'Modelos/Transaccion.php';

    //Incluir el objeto de tarjeta
    require_once 'Modelos/Tarjeta.php';

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

    //Incluir el objeto de pago
    require_once 'Modelos/Pago.php';

    class TransaccionController{

        /*
        Funcion para ver el formulario de direccion al comprar un videojuego
        */

        public function direccion(){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Listar todas las categorias desde la base de datos
            $listadoTarjeas = $tarjeta -> listar();

            //Comprobar si el dato está llegando
            if(isset($_GET)){
                //Comprobar si el dato existe
                $id = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;

                //Comprobar el dato exsiten
                if($id){

                    //Incluir la vista
                    require_once "Vistas/Transaccion/EnvioYPago.html";
                }
            }
        }

        /*
        Funcion para guardar el usuario en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){
                
                //Comprobar si cada dato existe
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;
                $codigoPostal = isset($_POST['codigoPostal']) ? $_POST['codigoPostal'] : false;
                $barrio = isset($_POST['barrio']) ? $_POST['barrio'] : false;
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
                $idTarjeta = 4;
                $numeroTarjeta = isset($_POST['numeroTarjeta']) ? $_POST['numeroTarjeta'] : false;
                $titular = isset($_POST['titular']) ? $_POST['titular'] : false;
                $codigoDeSeguridad = isset($_POST['codigoSeguridad']) ? $_POST['codigoSeguridad'] : false;
                $fechaExpedicion = isset($_POST['fechaExpedicion']) ? $_POST['fechaExpedicion'] : false;

                //Comprobar si todos los datos exsiten
                if($departamento && $municipio && $codigoPostal && $barrio && $direccion && 
                    $idTarjeta && $numeroTarjeta && $titular && $codigoDeSeguridad && $fechaExpedicion){

                    //Instanciar el objeto
                    $transaccion = new Transaccion();

                    $transaccion -> setIdComprador(4);
                    $transaccion -> setIdVendedor(1);
                    $transaccion -> setIdPago(1);
                    $transaccion -> setIdEstado(1);
                    $transaccion -> setDepartamento($departamento);
                    $transaccion -> setMunicipio($municipio);
                    $transaccion -> setCodigoPostal($codigoPostal);
                    $transaccion -> setBarrio($barrio);
                    $transaccion -> setDireccion($direccion);
                    $transaccion -> setNombreComprador("Edu");
                    $transaccion -> setApellidoComprador("Edu");
                    $transaccion -> setCorreoComprador("Edu");
                    $transaccion -> setTelefonoComprador("Edu");
                    $transaccion -> setTotal(400);
                    $transaccion -> setFechaRelizacion(date('Y-m-d'));
                    $transaccion -> setHoraRealizacion(date("H:i:s"));

                    //Guardar en la base de datos
                    $guardadoTransaccion = $transaccion -> guardar();

                    //Instanciar el objeto
                    $pago = new Pago();

                    $pago -> setIdTarjeta($idTarjeta);
                    $pago -> setNumeroTarjeta($numeroTarjeta);
                    $pago -> setTitular($titular);
                    $pago -> setCodigoSeguridad($codigoDeSeguridad);
                    $pago -> setFechaExpedicion($fechaExpedicion);

                    //Guardar en la base de datos
                    $guardadoPago = $pago -> guardar();

                    if($guardadoPago && $guardadoTransaccion){
                        $this -> exito();
                    }else{
                        var_dump('mal');
                        die();
                    }
                    

                }
            }
        }

        /*
        Funcion para ver el mensaje de exito al comprar un videojuego de manera correcta
        */

        public function exito(){

            //Incluir la vista
            require_once "Vistas/Transaccion/Exito.html";
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
            Ayudas::pdf();
        }

    }

?>