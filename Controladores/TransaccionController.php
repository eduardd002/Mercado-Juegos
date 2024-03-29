<?php

    /*OBS_START(); para */
    ob_start();

    //Incluir archivo de ayuda para generar el PDF
    require_once 'Ayudas/Ayudas.php';
    // antes ayudas/generarpdf

    //Incluir el objeto de transaccionvideojuego
    require_once 'Modelos/TransaccionVideojuego.php';

    //Incluir el objeto de transaccion
    require_once 'Modelos/Transaccion.php';

    //Incluir el objeto de tarjeta
    require_once 'Modelos/Tarjeta.php';

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

    //Incluir el objeto de pago
    require_once 'Modelos/Pago.php';

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    //Incluir el objeto de usuario chat
    require_once 'Modelos/UsuarioChat.php';

    //Incluir el objeto de usuario videojuego
    require_once 'Modelos/UsuarioVideojuego.php';

    class TransaccionController{

        /*
        Funcion para ver el formulario de direccion y compra al comprar un videojuego
        */

        public function direccionYPago(){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Listar todas las categorias desde la base de datos
            $listadoTarjetas = $tarjeta -> listar();

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
        Funcion para obtener la factura
        */

        public function obtenerFactura(){

            //Instanciar el objeto
            $transaccion = new Transaccion();
            //Traer el ultimo id de transaccion
            $ultimoId = $transaccion -> traerUltimoIdTransaccion();
            //Retornar el resultado
            return $ultimoId;
        }

        /*
        Funcion para obtener la ultima transaccion guardada
        */

        public function obtenerUltimaTransaccion(){

            //Instanciar el objeto
            $transaccion = new Transaccion();
            //Obtener id del ultimo videojuego registrado
            $id = $transaccion -> ultima();
            //Retornar resultado
            return $id;
        }

        /*
        Funcion para obtener el ultimo pago
        */

        public function obtenerUltimoPago(){

            //Instanciar el objeto
            $pago = new Pago();
            //Obtener id del ultimo videojuego registrado
            $id = $pago -> ultimo();
            //Retornar resultado
            return $id;
        }

        /*
        Funcion para traer el dueño del videojuego
        */

        public function traerDuenioDeVideojuego($idVideojuego){
            //Instanciar el objeto
            $usuarioVideojuego = new UsuarioVideojuego();
            //Crear el objeto
            $usuarioVideojuego -> setIdVideojuego($idVideojuego);
            //Obtener el usuario
            $idUsuario = $usuarioVideojuego -> obtenerUsuarioVideojuego();
            //Obtener el id del usuario
            $id = $idUsuario -> idUsuario;
            //Retornar el id
            return $id;
        }

        /*
        Funcion para guardar la transaccion en la base de datos
        */

        public function guardarTransaccion($factura, $departamento, $municipio, $codigoPostal, $barrio, $direccion, $idPago, $idVideojuego){

            //Instanciar el objeto
            $transaccion = new Transaccion();
            $transaccion -> setNumeroFactura($factura + 1000);
            $transaccion -> setIdComprador($_SESSION['loginexitoso'] -> id);
            $transaccion -> setIdVendedor($this -> traerDuenioDeVideojuego($idVideojuego));
            $transaccion -> setIdPago($idPago);
            $transaccion -> setIdEstado(1);
            $transaccion -> setDepartamento($departamento);
            $transaccion -> setMunicipio($municipio);
            $transaccion -> setCodigoPostal($codigoPostal);
            $transaccion -> setBarrio($barrio);
            $transaccion -> setDireccion($direccion);
            $transaccion -> setNombreComprador("Edu");
            $transaccion -> setApellidoComprador("cor");
            $transaccion -> setCorreoComprador("Edu");
            $transaccion -> setTelefonoComprador("315");
            $transaccion -> setNombreVendedor("juanda");
            $transaccion -> setApellidoVendedor("giraldo");
            $transaccion -> setCorreoVendedor("jd");
            $transaccion -> setTelefonoVendedor("321");
            $transaccion -> setTotal(400);
            $transaccion -> setFechaRelizacion(date('Y-m-d'));
            $transaccion -> setHoraRealizacion(date("H:i:s"));
            //Guardar en la base de datos
            $guardadoTransaccion = $transaccion -> guardar();
            //Retornar el resultado
            return $guardadoTransaccion;
        }

        /*
        Funcion para guardar la transaccion videojuego en la base de datos
        */

        public function guardarTransaccionVideojuego($id, $idVideojuego){

            //Instanciar el objeto
            $transaccionVideojuego = new TransaccionVideojuego();
            $transaccionVideojuego -> setIdTransaccion($id);
            $transaccionVideojuego -> setIdVideojuego($idVideojuego);
            $transaccionVideojuego -> setUnidades(1);
            $transaccionVideojuego -> setNombreVideojuego(1);
            $transaccionVideojuego -> setPrecioVideojuego(459999);
            $transaccionVideojuego -> setCategoriaVideojuego("Hola");
            $transaccionVideojuego -> setConsolaVideojuego("Hola");
            //Guardar en la base de datos
            $guardadoTransaccionVideojuego = $transaccionVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoTransaccionVideojuego;
        }

        /*
        Funcion para guardar el pago en la base de datos
        */

        public function guardarPago($idTarjeta, $numeroTarjeta, $titular, $codigoDeSeguridad, $fechaExpedicion){

            //Instanciar el objeto
            $pago = new Pago();
            $pago -> setIdTarjeta($idTarjeta);
            $pago -> setNumeroTarjeta($numeroTarjeta);
            $pago -> setTitular($titular);
            $pago -> setCodigoSeguridad($codigoDeSeguridad);
            $pago -> setFechaExpedicion($fechaExpedicion);
            //Guardar en la base de datos
            $guardadoPago = $pago -> guardar();
            //Retornar el resultado
            return $guardadoPago;
        }

        /*
        Funcion para guardar el chat en la base de datos
        */

        public function guardarChat(){

            //Instanciar el objeto
            $chat = new Chat;
            //Crear el objeto
            $chat -> setFechaCreacion(date('Y-m-d'));
            //Guardar en la base de datos
            $guardado = $chat -> guardar();
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo chat guardado
        */

        public function obtenerUltimoChat(){

            //Instanciar el objeto
            $chat = new Chat();
            //Obtener id del ultimo videojuego registrado
            $id = $chat -> ultimo();
            //Retornar resultado
            return $id;
        }

        /*
        Funcion para guardar el usuario chat en la base de datos
        */

        public function guardarUsuarioChat($destinatario){

            //Instanciar el primer objeto
            $usuarioChat = new UsuarioChat;
            //Crear el primer objeto
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($destinatario);
            $usuarioChat -> setIdChat($this -> obtenerUltimoChat());
            //Guardar en la base de datos el primer objeto
            $guardado = $usuarioChat -> guardar();
            return $guardado;
        }

        /*
        Funcion para guardar la transaccion en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST) && isset($_GET)){
                
                //Comprobar si cada dato existe
                $idVideojuego = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;
                $codigoPostal = isset($_POST['codigoPostal']) ? $_POST['codigoPostal'] : false;
                $barrio = isset($_POST['barrio']) ? $_POST['barrio'] : false;
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
                $idTarjeta = isset($_POST['idTarjeta']) ? $_POST['idTarjeta'] : false;
                $numeroTarjeta = isset($_POST['numeroTarjeta']) ? $_POST['numeroTarjeta'] : false;
                $titular = isset($_POST['titular']) ? $_POST['titular'] : false;
                $codigoDeSeguridad = isset($_POST['codigoSeguridad']) ? $_POST['codigoSeguridad'] : false;
                $fechaExpedicion = isset($_POST['fechaExpedicion']) ? $_POST['fechaExpedicion'] : false;

                //Comprobar si todos los datos exsiten
                if($departamento && $municipio && $codigoPostal && $barrio && $direccion && 
                    $idTarjeta && $numeroTarjeta && $titular && $codigoDeSeguridad && $fechaExpedicion){

                    //Obtener los resultados
                    $guardadoPago = $this -> guardarPago($idTarjeta, $numeroTarjeta, $titular, $codigoDeSeguridad, $fechaExpedicion);

                    //Traer ultimo pago
                    $pago = $this -> obtenerUltimoPago();
                    //Traer ultima factura
                    $factura = $this -> obtenerFactura();
                    //Guardar la transaccion
                    $guardadoTransaccion = $this -> guardarTransaccion($factura, $departamento, $municipio, $codigoPostal, $barrio, $direccion, $pago, $idVideojuego);

                    //Comprobar si los datos se guardaron con exito en la base de datos
                    if($guardadoTransaccion && $guardadoPago){

                        //Obtener id de la ultima transaccion
                        $idTransaccion = $this -> obtenerUltimaTransaccion();

                        //Obtener el resultado
                        $guardadoTransaccionVideojuego = $this -> guardarTransaccionVideojuego($idTransaccion, $idVideojuego);

                        //Comprobar si la transaccion videojueo se guardo con exito
                        if($guardadoTransaccionVideojuego){

                            //Guardar el chat
                            $guardadoChat = $this -> guardarChat();

                            //Comprobar si el chat ha sido guardado con exito
                            if($guardadoChat){

                                //Guardar usuario chat
                                $guardadoUsuarioChat = $this -> guardarUsuarioChat($this -> traerDuenioDeVideojuego($idVideojuego));

                                //Comprobar si el usuario chat ha sido guardado con exito
                                if($guardadoUsuarioChat){
                                    //Redirigir al menu de direccion y pago
                                    header("Location:"."http://localhost/Mercado-Juegos/?controller=TransaccionController&action=exito");
                                }
                            }

                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
                        }
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=VideojuegoController&action=inicio");
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

        public function verCompra(){

            $factura = $_GET['factura'];

            $transaccion = new Transaccion();
            $transaccion -> setNumeroFactura($factura);
            $detalle = $transaccion -> detalleCompra();

            //Incluir la vista
            require_once "Vistas/Compra/Detalle.html";
        }

        /*
        Funcion para ver el detalle de la venta realizada
        */

        public function verVenta(){

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