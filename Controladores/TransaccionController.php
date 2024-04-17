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

    //Incluir el objeto de medio de pago
    require_once 'Modelos/MedioPago.php';

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

    //Incluir el objeto de pago
    require_once 'Modelos/Envio.php';

    //Incluir el objeto de pago
    require_once 'Modelos/Pago.php';

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    //Incluir el objeto de usuario chat
    require_once 'Modelos/UsuarioChat.php';

    require_once 'Modelos/Videojuego.php';

    require_once 'Modelos/Usuario.php';

    require_once 'Modelos/Carrito.php';

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

        public function transaccionVideojuego(){
            //Comprobar si el dato está llegando
            if(isset($_GET) && isset($_POST)){
                //Comprobar si los datos existen
                $id = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
                $unidades = isset($_POST['cantidadAComprar']) ? $_POST['cantidadAComprar'] : false;
                $carrito = isset($_GET['carrito']) ? $_GET['carrito'] : false;
                //Comprobar los datos existen
                if($id && $unidades){
                    if($_POST["accion"] == "Comprar Ahora"){
                        $this -> direccionYPago($id, $unidades, 2);
                    }elseif($_POST["accion"] == "Agregar al carrito"){
                        $this -> carrito($id, $unidades);
                    }
                }elseif($carrito == 'true'){
                    $carrito = new Carrito();
                    $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
                    $lista = $carrito -> listar();
                    $videojuego = $lista['carrito']['videojuegos'];
                    for($i = 0; $i < count($videojuego); $i++){
                        $idVideojuego = $videojuego[$i]['idVideojuegoCarrito'];
                        $unidadesComprar = $videojuego[$i]['unidadesCarrito'];
                        $this -> direccionYPago($idVideojuego, $unidadesComprar, 1);
                    }
                }
            }
        }

        /*
        Funcion para ver el formulario de direccion y compra al comprar un videojuego
        */

        public function direccionYPago($idVideojuegos, $unidadesComprar, $carrito){
            //Instanciar el objeto
            $usuario = new Usuario();
            $usuario -> setId($_SESSION['loginexitoso'] -> id);
            //Listar todas las categorias desde la base de datos
            $listadoPagos = $usuario -> obtenerPagos();

            //Instanciar el objeto
            $usuario = new Usuario();
            $usuario -> setId($_SESSION['loginexitoso'] -> id);
            //Listar todas las categorias desde la base de datos
            $listadoEnvios = $usuario -> obtenerEnvios();

            $idVideojuego = $idVideojuegos;
            $unidadComprar = $unidadesComprar;
            $opcionCarrito = $carrito;

            $carrito = new Carrito();
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $listadoCarritos = $carrito -> listar();

            //Incluir la vista
            require_once "Vistas/Transaccion/EnvioYPago.html";
        }

        public function carrito($id, $unidades){
            Ayudas::crearSesionYRedirigir("guardaradministradorerror", "Ha ocurrido un error al guardar el administrador", "?controller=CarritoController&action=guardar&idVideojuego=$id&unidades=$unidades");
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
        Funcion para traer el dueño del videojuego
        */

        public function traerDuenioDeVideojuego($idVideojuego){
            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear el objeto
            $videojuego -> setId($idVideojuego);
            //Obtener el usuario
            $idUsuario = $videojuego -> obtenerUsuarioVideojuego();
            //Obtener el id del usuario
            $id = $idUsuario -> idUsuario;
            //Retornar el id
            return $id;
        }

        /*
        Funcion para guardar la transaccion en la base de datos
        */

        public function guardarTransaccion($idVideojuego, $opcion, $factura, $idPago, $idEnvio){
            $carrito = new Carrito();
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $lista = $carrito -> listar();
            $videojuego = Ayudas::obtenerVideojuegoDeTransaccionEnConcreto($this -> obtenerUltimaTransaccion() + 999);
            $transaccion = new Transaccion();
            $transaccion -> setNumeroFactura($factura + 1000);
            $transaccion -> setIdComprador($_SESSION['loginexitoso'] -> id);
            $transaccion -> setIdEstado(1);
            if($opcion == 1){
                foreach($idVideojuego as $videojuego){
                    $vendedor = $this -> traerDuenioDeVideojuego($videojuego);
                    $transaccion -> setIdVendedor($vendedor);
                }
                $total = $lista['totalCarrito']['totalCarrito'];
            }elseif($opcion == 2){
                $vendedor = $this -> traerDuenioDeVideojuego($idVideojuego);
                $transaccion -> setIdVendedor($vendedor);
                $vid = $videojuego -> fetch_object();
                $unidades = $vid -> unidades;
                $precio = $vid -> precio;
                $total = $unidades*$precio;
            }
            $transaccion -> setTotal($total);
            $transaccion -> setIdPago($idPago);
            $transaccion -> setIdEnvio($idEnvio);
            $transaccion -> setFechaHora(date('Y-m-d H:i:s'));
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
            //Guardar en la base de datos
            $guardadoTransaccionVideojuego = $transaccionVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoTransaccionVideojuego;
        }

        public function traerPago($id){
            //Instanciar el objeto
            $pago = new Pago();
            $pago -> setId($id);
            $pagoUnico = $pago -> obtenerUno();
            return $pagoUnico;
        }

        public function traerEnvio($id){
            //Instanciar el objeto
            $envio = new Envio();
            $envio -> setId($id);
            $envioUnico = $envio -> obtenerUno();
            return $envioUnico;
        }


        /*
        Funcion para guardar el pago en la base de datos
        */

        public function guardarPago($pagoUnico){
            //Instanciar el objeto
            $pago = new Pago();
            $pago -> setActivo(1);
            $pago -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $pago -> setIdMedioPago($pagoUnico -> idMedioPago);
            $pago -> setNumero($pagoUnico -> numeroPago);
            //Guardar en la base de datos
            $guardadoPago = $pago -> guardar();
            //Retornar el resultado
            return $guardadoPago;
        }

        /*
        Funcion para guardar el envio en la base de datos
        */

        public function guardarEnvio($envioUnico){

            //Instanciar el objeto
            $envio = new Envio();
            $envio -> setActivo(1);
            $envio -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $envio -> setDepartamento($envioUnico -> departamento);
            $envio -> setMunicipio($envioUnico -> municipio);
            $envio -> setCodigoPostal($envioUnico -> codigoPostal);
            $envio -> setBarrio($envioUnico -> barrio);
            $envio -> setDireccion($envioUnico -> direccion);
            //Guardar en la base de datos
            $guardadoEnvio = $envio -> guardar();
            //Retornar el resultado
            return $guardadoEnvio;
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
            $usuarioChat -> setFechaHora(date('Y-m-d H:i:s'));
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
                $idVideojuego = isset($_POST['idVideojuego']) ? $_POST['idVideojuego'] : false;
                $unidades = isset($_POST['unidad']) ? $_POST['unidad'] : false;
                $pago = isset($_POST['idPago']) ? $_POST['idPago'] : false;
                $envio = isset($_POST['idEnvio']) ? $_POST['idEnvio'] : false;
                $opcionCarrito = isset($_GET['opcionCompra']) ? $_GET['opcionCompra'] : false;
                //Comprobar si todos los datos exsiten
                if($pago && $envio && $idVideojuego && $unidades){
                    $carrito = new Carrito();
                    $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
                    $lista = $carrito -> listar();
                    if($opcionCarrito == 1){
                        $listado = count($lista['carrito']['videojuegos']);
                    }
                    //Traer ultima factura
                    $factura = $this -> obtenerFactura();
                  
                        //Guardar la transaccion
                        $guardadoTransaccion = $this -> guardarTransaccion($idVideojuego, $opcionCarrito, $factura, $pago, $envio);
                    
                        //Comprobar si los datos se guardaron con exito en la base de datos
                        if($guardadoTransaccion){

                            //Obtener id de la ultima transaccion
                            $idTransaccion = $this -> obtenerUltimaTransaccion();
                            //Obtener el resultado
                            if($opcionCarrito == 1){
                                for($i = 0; $i < $listado; $i++){
                                    $guardadoTransaccionVideojuego = $this -> guardarTransaccionVideojuego($idTransaccion, $idVideojuego[$i], $unidades[$i]);
                                }
                            }elseif($opcionCarrito == 2){
                                $guardadoTransaccionVideojuego = $this -> guardarTransaccionVideojuego($idTransaccion, $idVideojuego, $unidades);
                            }
                            //Comprobar si la transaccion videojueo se guardo con exito
                            if($guardadoTransaccionVideojuego){
                                if($opcionCarrito == 1){
                                    for($i = 0; $i < $listado; $i++){
                                        $this -> actualizarStock($idVideojuego[$i], $unidades[$i]);
                                    }
                                }elseif($opcionCarrito == 2){
                                    $this -> actualizarStock($idVideojuego, $unidades);
                                }
                                //Guardar el chat
                                $guardadoChat = $this -> guardarChat();

                                //Comprobar si el chat ha sido guardado con exito
                                if($guardadoChat){
                                    if($opcionCarrito == 1){
                                        for($i = 0; $i < $listado; $i++){
                                            //Guardar usuario chat
                                            $this -> guardarUsuarioChat($this -> traerDuenioDeVideojuego($idVideojuego[$i]));
                                        }
                                    }elseif($opcionCarrito == 2){
                                        $this -> guardarUsuarioChat($this -> traerDuenioDeVideojuego($idVideojuego));
                                    }
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