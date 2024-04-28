<?php

    /*Iniciar el buffer de salida*/
    ob_start();
    /*Incluir archivo de ayuda para generar el PDF*/
    require_once 'Ayudas/Ayudas.php';
    /*Incluir el objeto de transaccion de videojuego*/
    require_once 'Modelos/TransaccionVideojuego.php';
    /*Incluir el objeto de transaccion*/
    require_once 'Modelos/Transaccion.php';
    /*Incluir el objeto de medio de pago*/
    require_once 'Modelos/MedioPago.php';
    /*Incluir el objeto de estado*/
    require_once 'Modelos/Estado.php';
    /*Incluir el objeto de pago*/
    require_once 'Modelos/Envio.php';
    /*Incluir el objeto de pago*/
    require_once 'Modelos/Pago.php';
    /*Incluir el objeto de chat*/
    require_once 'Modelos/Chat.php';
    /*Incluir el objeto de usuario chat*/
    require_once 'Modelos/UsuarioChat.php';
    /*Incluir el objeto de videojuego*/
    require_once 'Modelos/Videojuego.php';
    /*Incluir el objeto de usuario*/
    require_once 'Modelos/Usuario.php';
    /*Incluir el objeto de carrito*/
    require_once 'Modelos/Carrito.php';

    /*
    Clase controlador de transaccion
    */

    class TransaccionController{

        /*
        Funcion para editar el estado de la transaccion
        */

        public function editarEstado($id, $estado){
            /*Instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Crear el objeto*/
            $transaccion -> setId($id);
            $transaccion -> setIdEstado($estado);
            /*Ejecutar la consulta*/
            $actualizado = $transaccion -> cambiarEstado();
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para cambiar el estado de la transaccion
        */

        public function cambiarEstado(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $idEstado = isset($_POST['estado']) ? $_POST['estado'] : false;
                /*Si los datos existen*/
                if($id && $idEstado){
                    /*Llamar la funcion de editar estado*/
                    $actualizado = $this -> editarEstado($id, $idEstado);
                    /*Establecer valor de la factura*/
                    $factura = $id + 999;
                    /*Comprobar si el estado ha sido actualizado*/
                    if($actualizado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarestadoacierto', "Estado actualizado con exito", '?controller=TransaccionController&action=verVenta&factura='.$factura);
                    /*De lo contrario*/  
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarestadosugerencia', "Agrega un nuevo estado", '?controller=TransaccionController&action=verVenta&factura='.$factura);
                    }
                /*De lo contrario*/  
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarestadoerror', "Ha ocurrido un error al actualizar el estado de la transaccion", '?controller=UsuarioController&action=ventas');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para realizar la transaccion, ya se compra o agregar al carrito
        */

        public function transaccionVideojuego(){
            /*Comprobar si los datos estan llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $id = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
                $unidades = isset($_POST['cantidadAComprar']) ? $_POST['cantidadAComprar'] : false;
                $carrito = isset($_GET['carrito']) ? $_GET['carrito'] : false;
                $accion = isset($_POST['accion']) ? $_POST['accion'] : false;
                /*Si los datos existen*/
                if($id && $unidades && $accion){
                    /*Llamar la funcion que redirige a la seccion de compra*/
                    $this -> redirigirSeccionCompra($id, $unidades, $accion);
                /*Si la redireccion a carrito es verdadera*/    
                }elseif($carrito == 'true'){
                    /*Llamar la funcion que redirige a la seccion de carrito*/
                    $this -> redirigirSeccionCarrito();
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para realizar la redireccion a la seccion de compra
        */

        public function redirigirSeccionCompra($id, $unidades, $accion){
            /*Comprobar si la accion es comprar el videojuego*/
            if($accion == "Comprar Ahora"){
                /*Llamar la funcion que envia a la seccion de direccion y pago*/
                $this -> direccionYPago($id, $unidades, 2);
            /*Comprobar si la accion es agregar al carrito el videojuego*/    
            }elseif($accion == "Agregar al carrito"){
                /*Redirigir*/
                header("Location:"."http://localhost/Mercado-Juegos/?controller=CarritoController&action=guardar&idVideojuego=$id&unidades=$unidades");
            }
        }

        /*
        Funcion para listar los videojuegos del carrito
        */

        public function listarCarritos(){
            /*Instanciar el objeto*/
            $carrito = new Carrito();
            /*Crear el objeto*/
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            /*Obtener la lista de videojuegos del carrito*/
            $lista = $carrito -> listar();
            /*Retornar el resultado*/
            return $lista;
        }

        /*
        Funcion para realizar la redireccion a la seccion de carrito
        */

        public function redirigirSeccionCarrito(){
            /*Llamar la funcion que trae la lista de videojuegos del carrito*/
            $lista = $this -> listarCarritos();
            /*Obtener lista de videojuegos del carrito*/
            $videojuego = $lista['carrito']['videojuegos'];
            /*Recorrer la lista de videojuegos*/
            for($i = 0; $i < count($videojuego); $i++){
                /*Obtener datos del videojuego*/
                $idVideojuego = $videojuego[$i]['idVideojuegoCarrito'];
                $unidadesComprar = $videojuego[$i]['unidadesCarrito'];
                /*Llamar la funcion que envia a la seccion de direccion y pago*/
                $this -> direccionYPago($idVideojuego, $unidadesComprar, 1);
            }
        }

        /*
        Funcion para listar los pagos del usuario
        */

        public function listarPagos(){
            /*Instanciar el objeto*/
            $usuario = new Usuario();
            /*Crear el objeto*/
            $usuario -> setId($_SESSION['loginexitoso'] -> id);
            /*Obtener la lista de videojuegos del carrito*/
            $listadoPagos = $usuario -> obtenerPagos();
            /*Retornar el resultado*/
            return $listadoPagos;
        }

        /*
        Funcion para listar los envios del usuario
        */

        public function listarEnvios(){
            /*Instanciar el objeto*/
            $usuario = new Usuario();
            /*Crear el objeto*/
            $usuario -> setId($_SESSION['loginexitoso'] -> id);
            /*Obtener la lista de videojuegos del carrito*/
            $listadoEnvios = $usuario -> obtenerEnvios();
            /*Retornar el resultado*/
            return $listadoEnvios;
        }

        /*
        Funcion para ver el formulario de direccion y compra al comprar un videojuego
        */

        public function direccionYPago($idVideojuego, $unidadComprar, $opcionCarrito){
            /*Llamar funciones que traen lista de carritos, envios y pagos*/
            $listadoCarritos = $this -> listarCarritos();
            $listadoPagos = $this -> listarPagos();
            $listadoEnvios = $this -> listarEnvios();
            /*Incluir la vista*/
            require_once "Vistas/Transaccion/EnvioYPago.html";
        }

        /*
        Funcion para obtener la factura
        */

        public function obtenerFactura(){
            /*Instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Traer el ultimo id de transaccion*/
            $ultimoId = $transaccion -> traerUltimoIdTransaccion();
            /*Retornar el resultado*/
            return $ultimoId;
        }

        /*
        Funcion para obtener la ultima transaccion guardada
        */

        public function obtenerUltimaTransaccion(){
            /*Instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Obtener id del ultimo videojuego registrado*/
            $id = $transaccion -> traerUltimoIdTransaccion();
            /*Retornar el resultado*/
            return $id;
        }

        /*
        Funcion para traer el dueño del videojuego
        */

        public function traerDuenioDeVideojuego($idVideojuego){
            /*Instanciar el objeto*/
            $videojuego = new Videojuego();
            /*Crear el objeto*/
            $videojuego -> setId($idVideojuego);
            /*Obtener el usuario*/
            $idUsuario = $videojuego -> obtenerUsuarioVideojuego();
            /*Obtener el id del usuario*/
            $id = $idUsuario -> idUsuario;
            /*Retornar el resultado*/
            return $id;
        }

        /*
        Funcion para guardar la transaccion en la base de datos
        */

        public function guardarTransaccion($idVideojuego, $unidadesCompra, $opcion, $factura, $idPago, $idEnvio){
            /*Comprobar si la transaccion es del carrito*/
            if($opcion == 1){
                /*Llamar la funcion para guardar la transaccion del carrito*/
                $transaccion = $this -> guardarTransaccionCarrito($factura, $idVideojuego, $idPago, $idEnvio);
            /*Comprobar si la transaccion es del videojuego unicamente*/    
            }elseif($opcion == 2){
                /*Llamar la funcion para guardar la transaccion del videojuego*/
                $transaccion = $this -> guardarTransaccionVideojuegoUnico($factura, $idVideojuego, $unidadesCompra, $idPago, $idEnvio);
            }
            /*Retornar el resultado*/
            return $transaccion;
        }

        /*
        Funcion para guardar la transaccion del videojuego
        */

        public function guardarTransaccionCarrito($factura, $idVideojuego, $idPago, $idEnvio){
            /*Llamar la funcion que trae la lista de los videojuegos del carrito*/
            $lista = $this -> listarCarritos();
            /*instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Crear el objeto*/
            $transaccion -> setNumeroFactura($factura + 1000);
            $transaccion -> setIdComprador($_SESSION['loginexitoso'] -> id);
            $transaccion -> setIdEstado(1);
            /*Recorrer la lista de videojuegos del carrito*/
            foreach($idVideojuego as $videojuego){
                /*Llamar la funcion que trae el dueño del videojuego*/
                $vendedor = $this -> traerDuenioDeVideojuego($videojuego);
                /*Crear el objeto*/
                $transaccion -> setIdVendedor($vendedor);
            }
            /*Obtener total de la transaccion*/
            $total = $lista['totalCarrito']['totalCarrito'];
            /*Crear el objeto*/
            $transaccion -> setTotal($total);
            $transaccion -> setIdPago($idPago);
            $transaccion -> setIdEnvio($idEnvio);
            $transaccion -> setFechaHora(date('Y-m-d H:i:s'));
            /*Guardar la transaccion en la base de datos*/
            $guardadoTransaccion = $transaccion -> guardar();
            /*Retornar el resultado*/
            return $guardadoTransaccion;
        }

        /*
        Funcion para guardar la transaccion del carrito
        */

        public function guardarTransaccionVideojuegoUnico($factura, $idVideojuego, $unidadesCompra, $idPago, $idEnvio){
            /*instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Crear el objeto*/
            $transaccion -> setNumeroFactura($factura + 1000);
            $transaccion -> setIdComprador($_SESSION['loginexitoso'] -> id);
            $transaccion -> setIdEstado(1);
            /*Llamar la funcion que obtiene un videojuego en concreto*/
            $videojuegoUnico = Ayudas::obtenerVideojuegoEnConcreto($idVideojuego);
            /*Llamar la funcion que obtiene un videojuego en concreto*/
            $vendedor = $this -> traerDuenioDeVideojuego($idVideojuego);
            /*Crear el objeto*/
            $transaccion -> setIdVendedor($vendedor);
            /*Obtener el precio del videojuego*/
            $precio = $videojuegoUnico['videojuego']['precioVideojuego'];
            /*Obtener el total de la transaccion*/
            $total = $unidadesCompra * $precio;
            /*Crear el objeto*/
            $transaccion -> setTotal($total);
            $transaccion -> setIdPago($idPago);
            $transaccion -> setIdEnvio($idEnvio);
            $transaccion -> setFechaHora(date('Y-m-d H:i:s'));
            /*Guardar la transaccion en la base de datos*/
            $guardadoTransaccion = $transaccion -> guardar();
            /*Retornar el resultado*/
            return $guardadoTransaccion;
        }

        /*
        Funcion para guardar la transaccion videojuego en la base de datos
        */

        public function guardarTransaccionVideojuego($id, $idVideojuego, $unidades){
            /*Instanciar el objeto*/
            $transaccionVideojuego = new TransaccionVideojuego();
            /*Crear el objeto*/
            $transaccionVideojuego -> setIdTransaccion($id);
            $transaccionVideojuego -> setIdVideojuego($idVideojuego);
            $transaccionVideojuego -> setUnidades($unidades);
            /*Guardar en la base de datos*/
            $guardadoTransaccionVideojuego = $transaccionVideojuego -> guardar();
            /*Retornar el resultado*/
            return $guardadoTransaccionVideojuego;
        }

        /*
        Funcion para traer un pago en concreto
        */

        public function traerPago($id){
            /*Instanciar el objeto*/
            $pago = new Pago();
            /*Crear el objeto*/
            $pago -> setId($id);
            /*Obtener el resultado*/
            $pagoUnico = $pago -> obtenerUno();
            /*Retornar el resultado*/
            return $pagoUnico;
        }

        /*
        Funcion para traer un envio en concreto
        */

        public function traerEnvio($id){
            /*Instanciar el objeto*/
            $envio = new Envio();
            /*Crear el objeto*/
            $envio -> setId($id);
            /*Obtener el resultado*/
            $envioUnico = $envio -> obtenerUno();
            /*Retornar el resultado*/
            return $envioUnico;
        }


        /*
        Funcion para guardar el pago en la base de datos
        */

        public function guardarPago($pagoUnico){
            /*Instanciar el objeto*/
            $pago = new Pago();
            /*Crear el objeto*/
            $pago -> setactivo(TRUE);
            $pago -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $pago -> setIdMedioPago($pagoUnico -> idMedioPago);
            $pago -> setNumero($pagoUnico -> numeroPago);
            /*Guardar en la base de datos*/
            $guardadoPago = $pago -> guardar();
            /*Retornar el resultado*/
            return $guardadoPago;
        }

        /*
        Funcion para guardar el envio en la base de datos
        */

        public function guardarEnvio($envioUnico){
            /*Instanciar el objeto*/
            $envio = new Envio();
            /*Crear el objeto*/
            $envio -> setactivo(TRUE);
            $envio -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $envio -> setDepartamento($envioUnico -> departamento);
            $envio -> setMunicipio($envioUnico -> municipio);
            $envio -> setCodigoPostal($envioUnico -> codigoPostal);
            $envio -> setBarrio($envioUnico -> barrio);
            $envio -> setDireccion($envioUnico -> direccion);
            /*Guardar en la base de datos*/
            $guardadoEnvio = $envio -> guardar();
            /*Retornar el resultado*/
            return $guardadoEnvio;
        }

        /*
        Funcion para guardar el chat en la base de datos
        */

        public function guardarChat(){
            /*Instanciar el objeto*/
            $chat = new Chat;
            /*Crear el objeto*/
            $chat -> setFechaCreacion(date('Y-m-d'));
            /*Guardar en la base de datos*/
            $guardado = $chat -> guardar();
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo chat guardado
        */

        public function obtenerUltimoChat(){
            /*Instanciar el objeto*/
            $chat = new Chat();
            /*Obtener id del ultimo videojuego registrado*/
            $id = $chat -> ultimo();
            /*Retornar EL resultado*/
            return $id;
        }

        /*
        Funcion para guardar el usuario chat en la base de datos
        */

        public function guardarUsuarioChat($destinatario){
            /*Instanciar el objeto*/
            $usuarioChat = new UsuarioChat;
            /*Crear el objeto*/
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($destinatario);
            $usuarioChat -> setIdChat($this -> obtenerUltimoChat());
            $usuarioChat -> setFechaHora(date('Y-m-d H:i:s'));
            /*Guardar en la base de datos*/
            $guardado = $usuarioChat -> guardar();
            /*Retonar el resultado*/
            return $guardado;
        }

        /*
        Funcion para guardar la transaccion en la base de datos
        */

        public function guardar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_POST) && isset($_GET)){
                /*Comprobar si cada dato existe*/
                $idVideojuego = isset($_POST['idVideojuego']) ? $_POST['idVideojuego'] : false;
                $unidades = isset($_POST['unidad']) ? $_POST['unidad'] : false;
                $pago = isset($_POST['idPago']) ? $_POST['idPago'] : false;
                $envio = isset($_POST['idEnvio']) ? $_POST['idEnvio'] : false;
                $opcionCarrito = isset($_GET['opcionCompra']) ? $_GET['opcionCompra'] : false;
                /*Si los datos existen*/
                if($pago && $envio && $idVideojuego && $unidades && $opcionCarrito){
                    /*Llamar funcion que trae la ultima factura*/
                    $factura = $this -> obtenerFactura();
                    /*Comprobar si la opcion de la transaccion es del carrito*/
                    if($opcionCarrito == 1){
                        /*Llamar la funcion que realiza la transaccion del carrito*/
                        $this -> realizarTransaccionCarrito($idVideojuego, $unidades, $opcionCarrito, $factura, $pago, $envio);
                    /*Comprobar si la opcion de la transaccion es del videojuego*/    
                    }elseif($opcionCarrito == 2){
                        /*Llamar la funcion que realiza la transaccion del videojuego*/
                        $this -> realizarTransaccionVideojuego($idVideojuego, $unidades, $opcionCarrito, $factura, $pago, $envio);
                    }
                /*De lo contrario*/    
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
                }
            /*De lo contrario*/  
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para eliminar el carrito
        */

        public function eliminarCarritoCompleto($idUsuario){
            /*Instanciar el objeto*/
            $carrito = new Carrito();
            /*Crear el objeto*/
            $carrito -> setIdUsuario($idUsuario);
            $carrito -> setActivo(FALSE);
            /*Ejecutar la consulta*/
            $eliminado = $carrito -> eliminarCarrito();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para realizar la transaccion del carrito
        */

        public function realizarTransaccionCarrito($idVideojuego, $unidades, $opcionCarrito, $factura, $pago, $envio){
            /*Obtener el id del usuario logueado*/
            $idUsuario = $_SESSION['loginexitoso'] -> id;
            /*Llamar la funcion que lista los videojuegos del carrito*/
            $lista = $this -> listarCarritos();
            /*Obtener la cantidad de videojuegos que hay en el carrito*/
            $listado = count($lista['carrito']['videojuegos']);
            /*Llamar la funcion que guarda la transaccion*/
            $guardadoTransaccion = $this -> guardarTransaccion($idVideojuego, $unidades, $opcionCarrito, $factura, $pago, $envio);
            /*Comprobar si la transaccion que guardo con exito*/
            if($guardadoTransaccion){
                /*Llamar la funcio para obtener id de la ultima transaccion*/
                $idTransaccion = $this -> obtenerUltimaTransaccion();
                /*Recorrer la lista de videojuegos del carrito*/
                for($i = 0; $i < $listado; $i++){
                    /*Llamar la funcion que obtiene la transaccion del videojuego*/
                    $guardadoTransaccionVideojuego = $this -> guardarTransaccionVideojuego($idTransaccion, $idVideojuego[$i], $unidades[$i]);
                    /*Comprobar si la transaccion videojueo se guardo con exito*/
                    if($guardadoTransaccionVideojuego){
                        /*Llamar la funcion que actualiza el stock del videojuego*/
                        $this -> actualizarStock($idVideojuego[$i], $unidades[$i]);
                        /*Llamar funcion que elimina el carrito*/
                        $this -> eliminarCarritoCompleto($idUsuario);
                        /*Llamar la funcion para guardar el chat*/
                        $guardadoChat = $this -> guardarChat();
                        /*Comprobar si el chat ha sido guardado con exito*/
                        if($guardadoChat){
                            /*Llamar la funcion para guardar el usuario del chat*/
                            $guardadoUsuarioChat = $this -> guardarUsuarioChat($this -> traerDuenioDeVideojuego($idVideojuego[$i]));
                        /*De lo contrario*/  
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                        }
                    /*De lo contrario*/      
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
                    }
                }
                /*Comprobar si el usuario chat ha sido guardado con exito*/
                if($guardadoUsuarioChat){
                    /*Redirigir al menu de direccion y pago*/
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=TransaccionController&action=exito"); 
                /*De lo contrario*/  
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                }
            /*De lo contrario*/  
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
            }
        }

        /*
        Funcion para realizar la transaccion del videojuego
        */

        public function realizarTransaccionVideojuego($idVideojuego, $unidades, $opcionCarrito, $factura, $pago, $envio){
            /*Llamar la funcion que guarda la transaccion*/
            $guardadoTransaccion = $this -> guardarTransaccion($idVideojuego, $unidades, $opcionCarrito, $factura, $pago, $envio);
            /*Comprobar si la transaccion que guardo con exito*/
            if($guardadoTransaccion){
                /*Llamar la funcio para obtener id de la ultima transaccion*/
                $idTransaccion = $this -> obtenerUltimaTransaccion();
                /*Llamar la funcion que obtiene la transaccion del videojuego*/
                $guardadoTransaccionVideojuego = $this -> guardarTransaccionVideojuego($idTransaccion, $idVideojuego, $unidades);
                /*Comprobar si la transaccion videojueo se guardo con exito*/
                if($guardadoTransaccionVideojuego){
                    /*Llamar la funcion para acutalizar el stock*/
                    $this -> actualizarStock($idVideojuego, $unidades);
                    /*Llamar la funcion para guardar el chat*/
                    $guardadoChat = $this -> guardarChat();
                    /*Comprobar si el chat ha sido guardado con exito*/
                    if($guardadoChat){
                        /*Llamar la funcion para guardar el usuario del chat*/
                        $guardadoUsuarioChat = $this -> guardarUsuarioChat($this -> traerDuenioDeVideojuego($idVideojuego));
                    /*De lo contrario*/  
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                    }
                /*De lo contrario*/      
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
                }
            }
            /*Comprobar si el usuario chat ha sido guardado con exito*/
            if($guardadoUsuarioChat){
                /*Redirigir al menu de direccion y pago*/
                header("Location:"."http://localhost/Mercado-Juegos/?controller=TransaccionController&action=exito"); 
            /*De lo contrario*/  
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("comprarvideojuegoerror", "Ha ocurrido un error al comprar el videojuego", "?controller=TransaccionController&action=direccionYPago&idVideojuego=$idVideojuego");
            }
        }

        /*
        Funcion para ver el mensaje de exito al comprar un videojuego de manera correcta
        */

        public function exito(){
            /*Incluir la vista*/
            require_once "Vistas/Transaccion/Exito.html";
        }

        /*
        Funcion para traer el detalle de la compra
        */

        public function traerDetalleCompra($factura){
            /*Instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Crear el objeto*/
            $transaccion -> setNumeroFactura($factura);
            /*Obtener detalle de la compra*/
            $detalle = $transaccion -> detalleCompra();
            /*Retornar el resultado*/
            return $detalle;
        }

        /*
        Funcion para ver el detalle de la compra realizada
        */

        public function verCompra(){
            /*Comprobar si el dato está llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $factura = isset($_GET['factura']) ? $_GET['factura'] : false;
                /*Si el dato existe*/
                if($factura){
                    /*Llamar la funcion que obtiene el detlle de la compra*/
                    $detalleCompra = $this -> traerDetalleCompra($factura);
                    /*Comprobar si el detalle ha llegado*/
                    if($detalleCompra){
                        /*Incluir la vista*/
                        require_once "Vistas/Compra/Factura.html";
                    /*De lo contrario*/  
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("verCompraError", "Ha ocurrido un error al ver el detalle de la compra", "?controller=UsuarioController&action=compras");
                    }
                /*De lo contrario*/  
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                }
            /*De lo contrario*/  
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("verCompraError", "Ha ocurrido un error al ver el detalle de la compra", "?controller=VideojuegoController&action=inicio");
            }
            /*Retornar el resultado*/
            return $detalleCompra;
        }

        /*
        Funcion para generar reporte de factura en formato PDF
        */

        public function generarPdf(){
            /*Llamar la funcion para obtener la compra*/
            $detalleCompra = $this -> verCompra();
            /*Llamar la funcion de ayuda que genera el archivo PDF*/
            Ayudas::pdf($detalleCompra);
        }

        /*
        Funcion para traer el detalle de la venta
        */

        public function traerDetalleVenta($factura){
            /*Instanciar el objeto*/
            $transaccion = new Transaccion();
            /*Crear el objeto*/
            $transaccion -> setNumeroFactura($factura);
            /*Obtener detalle de la compra*/
            $detalle = $transaccion -> detalleVenta();
            /*Retornar el resultado*/
            return $detalle;
        }

        /*
        Funcion para traer la lista de los estados
        */

        public function traerEstados(){
            /*Instanciar el objeto*/
            $estado = new Estado();
            /*Listar todos los estados*/
            $lista = $estado -> listar();
            /*Retornar el restultado*/
            return $lista;
        }

        /*
        Funcion para ver el detalle de la venta realizada
        */

        public function verVenta(){
            /*Comprobar si el dato está llegando*/
            if(isset($_GET['factura'])){
                /*Comprobar si el dato existe*/
                $factura = isset($_GET['factura']) ? $_GET['factura'] : false;
                /*Si el dato existe*/
                if($factura){
                    /*Llamar la funcion que trae el detalle de la venta*/
                    $detalle = $this -> traerDetalleVenta($factura);
                    /*Si se ha traido el detalle de la venta*/
                    if($detalle){
                        /*Llamar funcion que trae los estados*/
                        $listadoEstados = $this -> traerEstados();
                        /*Incluir la vista*/
                        require_once "Vistas/Venta/Detalle.html";
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("verVentaError", "Ha ocurrido un error al ver el detalle de la venta", "?controller=UsuarioController&action=ventas");
                    }
                /*De lo contrario*/      
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("verVentaError", "Ha ocurrido un error al ver el detalle de la venta", "?controller=VideojuegoController&action=inicio");
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("verVentaError", "Ha ocurrido un error al ver el detalle de la venta", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion par actualizar el stock del videojuego al realizar una transaccion
        */

        public function actualizarStock($id, $unidadesCompradas){
            /*Llamar la funcion que obtiene el videojuego en concreto*/
            $videojuegoUnico = Ayudas::obtenerVideojuegoEnConcreto($id);
            /*Obtener stock del videojuego*/
            $stockActual = $videojuegoUnico['videojuego']['stockVideojuego'];
            /*Instanciar el objeto*/
            $videojuego = new Videojuego();
            /*Crear el objeto*/
            $videojuego -> setId($id);
            $videojuego -> setStock($stockActual - $unidadesCompradas);
            /*Actualizar stock*/
            $stock = $videojuego -> actualizarStock();
            /*Comprobar si el stock no ha sido actualizado con exito*/
            if(!$stock){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

    }

?>