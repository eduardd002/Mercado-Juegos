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

    require_once 'Modelos/Videojuego.php';

    class TransaccionController{

        public function editarEstado($id, $estado){

            //Instanciar el objeto
            $transaccion = new Transaccion();
            //Crear objeto
            $transaccion -> setId($id);
            $transaccion -> setIdEstado($estado);
            //Ejecutar la consulta
            $actualizado = $transaccion -> cambiarEstado();
            return $actualizado;
        }

        public function cambiarEstado(){

            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $idEstado = isset($_POST['estado']) ? $_POST['estado'] : false;

                //Si el dato existe
                if($id && $idEstado){

                    //Llamar la funcion de actualizar
                    $actualizado = $this -> editarEstado($id, $idEstado);
                    $factura = $id + 999;

                    if($actualizado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarestadoacierto', "Estado actualizado con exito", '?controller=TransaccionController&action=verVenta&factura='.$factura);
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarestadosugerencia', "Agrega un nuevo estado", '?controller=TransaccionController&action=verVenta&factura='.$factura);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizarestadoerror', "Ha ocurrido un error al actualizar el estado de la transaccion", '?controller=UsuarioController&action=ventas');
                }
            }
        }

        /*
        Funcion para ver el formulario de direccion y compra al comprar un videojuego
        */

        public function direccionYPago(){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Listar todas las categorias desde la base de datos
            $listadoTarjetas = $tarjeta -> listar();

            //Comprobar si el dato está llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existen
                $id = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
                $unidades = isset($_POST['cantidadAComprar']) ? $_POST['cantidadAComprar'] : false;

                //Comprobar los datos existen
                if($id && $unidades){

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

        public function guardarTransaccion($factura, $departamento, $municipio, $codigoPostal, $barrio, $direccion, $idPago, $idVideojuego, $unidades){

            $videojuego = Ayudas::obtenerVideojuegoEnConcreto($idVideojuego);
            $comprador = Ayudas::obtenerUsuarioEnConcreto($_SESSION['loginexitoso'] -> id);
            $vendedor = Ayudas::obtenerUsuarioEnConcreto($this -> traerDuenioDeVideojuego($idVideojuego));

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
            $transaccion -> setNombreComprador($comprador -> nombre);
            $transaccion -> setApellidoComprador($comprador -> apellido);
            $transaccion -> setCorreoComprador($comprador -> correo);
            $transaccion -> setTelefonoComprador($comprador -> numeroTelefono);
            $transaccion -> setNombreVendedor($vendedor -> nombre);
            $transaccion -> setApellidoVendedor($vendedor -> apellido);
            $transaccion -> setCorreoVendedor($vendedor -> correo);
            $transaccion -> setTelefonoVendedor($vendedor -> numeroTelefono);
            $transaccion -> setTotal($unidades * ($videojuego['videojuego']['precioVideojuego']));
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

        public function guardarTransaccionVideojuego($id, $idVideojuego, $unidades){

            $videojuego = Ayudas::obtenerVideojuegoEnConcreto($idVideojuego);

            //Instanciar el objeto
            $transaccionVideojuego = new TransaccionVideojuego();
            $transaccionVideojuego -> setIdTransaccion($id);
            $transaccionVideojuego -> setIdVideojuego($idVideojuego);
            $transaccionVideojuego -> setUnidades($unidades);
            $transaccionVideojuego -> setNombreVideojuego($videojuego['videojuego']['nombreVideojuego']);
            $transaccionVideojuego -> setPrecioVideojuego($videojuego['videojuego']['precioVideojuego']);
            $transaccionVideojuego -> setUsoVideojuego($videojuego['videojuego']['nombreUso']);
            $transaccionVideojuego -> setConsolaVideojuego($videojuego['videojuego']['nombreConsola']);
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
            $chat -> setActivo(1);
            $chat -> setFechaCreacion(date('Y-m-d'));
            //Guardar en la base de datos
            $guardado = $chat -> guardar();
            //Retornar el resultado
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
            $usuarioChat -> setActivo(1);
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($destinatario);
            $usuarioChat -> setIdChat($this -> obtenerUltimoChat());
            $usuarioChat -> setIdMensaje(null);
            //Guardar en la base de datos el primer objeto
            $guardado = $usuarioChat -> guardar();
            //Retonar el resultado
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
                $unidades = isset($_GET['unidades']) ? $_GET['unidades'] : false;
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
                    $guardadoTransaccion = $this -> guardarTransaccion($factura, $departamento, $municipio, $codigoPostal, $barrio, $direccion, $pago, $idVideojuego, $unidades);

                    //Comprobar si los datos se guardaron con exito en la base de datos
                    if($guardadoTransaccion && $guardadoPago){

                        //Obtener id de la ultima transaccion
                        $idTransaccion = $this -> obtenerUltimaTransaccion();

                        //Obtener el resultado
                        $guardadoTransaccionVideojuego = $this -> guardarTransaccionVideojuego($idTransaccion, $idVideojuego, $unidades);

                        //Comprobar si la transaccion videojueo se guardo con exito
                        if($guardadoTransaccionVideojuego){

                            $this -> actualizarStock($idVideojuego, $unidades);
                            //Guardar el chat
                            $guardadoChat = $this -> guardarChat();

                            //Comprobar si el chat ha sido guardado con exito
                            if($guardadoChat){

                                //Guardar usuario chat
                                $this -> guardarUsuarioChat($this -> traerDuenioDeVideojuego($idVideojuego));
                                //Redirigir al menu de direccion y pago
                                header("Location:"."http://localhost/Mercado-Juegos/?controller=TransaccionController&action=exito");
                                
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

            //Establecer una bandera para el detalle de la compra
            $detalleCompra = null;

            //Comprobar si esta llegando la factura por parametro
            if(isset($_GET['factura'])){

                //Asignar valor a la factura
                $factura = $_GET['factura'];
                //Instanciar el objeto
                $transaccion = new Transaccion();
                //Crear objeto
                $transaccion -> setNumeroFactura($factura);
                //Obtener detalle de la compra
                $detalle = $transaccion -> detalleCompra();

                //Comprobar si el detalle ha llegado
                if($detalle){

                    //Asignar nuevo valor a la bandera
                    $detalleCompra = $detalle;
                    //Incluir la vista
                    require_once "Vistas/Compra/Factura.html";
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("verCompraError", "Ha ocurrido un error al ver el detalle de la compra", "?controller=UsuarioController&action=compras");
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("verCompraError", "Ha ocurrido un error al ver el detalle de la compra", "?controller=VideojuegoController&action=inicio");
            }
            //Retornar el resultado
            return $detalleCompra;
        }

        /*
        Funcion para generar reporte de factura en formato PDF
        */

        public function generarPdf(){

            //Obtener la compra
            $detalleCompra = $this -> verCompra();
            //Llamar la funcion de ayuda que genera el archivo PDF
            Ayudas::pdf($detalleCompra);
        }

        /*
        Funcion para ver el detalle de la venta realizada
        */

        public function verVenta(){

            //Comprobar si esta llegando la factura por parametro
            if(isset($_GET['factura'])){
                $factura = $_GET['factura'];

                $transaccion = new Transaccion();
                $transaccion -> setNumeroFactura($factura);
                $detalle = $transaccion -> detalleVenta();

                if($detalle){

                    //Instanciar el objeto
                    $estado = new Estado();
                    //Listar todos los usuarios desde la base de datos
                    $listadoEstados = $estado -> listar();
                    //Incluir la vista
                    require_once "Vistas/Venta/Detalle.html";
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("verVentaError", "Ha ocurrido un error al ver el detalle de la venta", "?controller=UsuarioController&action=ventas");
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("verVentaError", "Ha ocurrido un error al ver el detalle de la venta", "?controller=VideojuegoController&action=inicio");
            }
        }

        public function actualizarStock($id, $unidadesCompradas){
            $videojuegoUnico = Ayudas::obtenerVideojuegoEnConcreto($id);
            $stockActual = $videojuegoUnico['videojuego']['stockVideojuego'];

            $videojuego = new Videojuego();
            $videojuego -> setId($id);
            $videojuego -> setStock($stockActual - $unidadesCompradas);
            $videojuego -> actualizarStock();
        }
    }

?>