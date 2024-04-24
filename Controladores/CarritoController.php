<?php

    /*Incluir el objeto de carrito*/
    require_once 'Modelos/Carrito.php';
    /*Incluir el objeto de videojuego*/
    require_once 'Modelos/Videojuego.php';
    /*Incluir el objeto de carrito videojuego*/
    require_once 'Modelos/CarritoVideojuego.php';

    /*
    Clase controlador de carrito
    */

    class CarritoController{

        /*
        Funcion para ver el carrito con los videojuegos
        */

        public function ver(){
            /*Instanciar el objeto*/
            $carrito = new Carrito();
            /*Construir el objeto*/
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            /*Obtener la lista de videojuegos del carrito*/
            $listadoCarritos = $carrito -> listar();
            /*Incluir la vista*/
            require_once "Vistas/Carrito/Carrito.html";
        }

        /*
        Funcion para eliminar un videojuego
        */

        public function eliminarVideojuego($idUsuario, $idVideojuego){
            /*Instanciar el objeto*/
            $carrito = new Carrito();
            /*Crear el objeto*/
            $carrito -> setIdUsuario($idUsuario);
            /*Ejecutar la consulta*/
            $eliminado = $carrito -> eliminarVideojuego($idVideojuego);
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar un usuario desde el administrador
        */

        public function eliminarVideojuegoCarrito(){
            /*Comprobar si los datos estan llegando*/
            if(isset($_GET)){
                /*Comprobar si los datos existen*/
                $idVideojuego = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
                $idUsuario = $_SESSION['loginexitoso'] -> id;
                /*Si los datos existen*/
                if($idVideojuego && $idUsuario){
                    /*Llamar la funcion que elimina el videojuego*/
                    $eliminado = $this -> eliminarVideojuego($idUsuario, $idVideojuego);
                    /*Comprobar si el videojuego ha sido eliminado*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarvideojuegoacierto', "El videojuego ha sido eliminado exitosamente", '?controller=CarritoController&action=ver');
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarvideojuegoerror', "El videojuego no ha sido eliminado exitosamente", '?controller=CarritoController&action=ver');
                    }
                /*De lo contrario*/     
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('eliminarvideojuegoerror', "Ha ocurrido un error al eliminar el videojuego", '?controller=CarritoController&action=ver');
                }
            /*De lo contrario*/       
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para guardar el carrito en la base de datos
        */

        public function guardarCarrito(){
            /*Instanciar el objeto*/
            $carrito = new Carrito();
            /*Crear el objeto*/
            $carrito -> setActivo(1);
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            /*Guardar en la base de datos*/
            $guardado = $carrito -> guardar();
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo videojuego guardado en el carrito
        */

        public function obtenerUltimoCarrito(){
            /*Instanciar el objeto*/
            $carrito = new Carrito();
            /*Obtener id del ultimo videojuego registrado*/
            $idCarrito = $carrito -> ultimo();
            /*Retornar el resultado*/
            return $idCarrito;
        }

        /*
        Funcion para traer un videojuego en concreto
        */

        public function traer($videojuegoId){
            /*Instanciar el objeto*/
            $videojuego = new Videojuego();
            /*Crear el objeto*/
            $videojuego -> setId($videojuegoId);
            /*Traer el videojuego*/
            $videojuegoActual = $videojuego -> traerUno();
            /*Retornar el resultado*/
            return $videojuegoActual;
        }

        /*
        Funcion para guardar el carrito videojuego en la base de datos
        */

        public function guardarCarritoVideojuego($videojuegoId, $idCarrito, $unidades){
            /*Llamar la funcion que trae un videojuego en concreto*/
            $videojuego = $this -> traer($videojuegoId);
            /*Instanciar el objeto*/
            $carritoVideojuego = new CarritoVideojuego();
            /*Crear el objeto*/
            $carritoVideojuego -> setActivo(1);
            $carritoVideojuego -> setIdCarrito($idCarrito);
            $carritoVideojuego -> setIdVideojuego($videojuegoId);
            $carritoVideojuego -> setUnidades($unidades);
            $carritoVideojuego -> setPrecio($videojuego['videojuego']['precioVideojuego']);
            /*Guardar en la base de datos*/
            $guardadoVideojuegoCarrito = $carritoVideojuego -> guardar();
            /*Retornar el resultado*/
            return $guardadoVideojuegoCarrito;
        }

        /*
        Funcion para guardar el carrito en la base de datos
        */

        public function guardar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET)){
                /*Comprobar si cada dato existe*/
                $videojuegoId = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
                $unidades = isset($_GET['unidades']) ? $_GET['unidades'] : false;
                /*Si los datos existen*/
                if($videojuegoId && $unidades){
                    /*Llamar la funcion que guarda el carrito*/
                    $guardado = $this -> guardarCarrito();
                    /*Comprobar si se guardo con exito el carrito*/
                    if($guardado){
                        /*Llamar la funcion que obtiene el id del ultimo carrito guardado*/
                        $ultimoCarrito = $this -> obtenerUltimoCarrito();
                        /*Llamar la funcion de guardar carrito videojuego*/
                        $guardadoVideojuegoCarrito = $this -> guardarCarritoVideojuego($videojuegoId, $ultimoCarrito, $unidades);
                        /*Comprobar si se guardo con exito el carrito videojuego*/
                        if($guardadoVideojuegoCarrito){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarcarritoacierto', "Videojuego agregado a la lista de carritos con exito", "?controller=CarritoController&action=ver");
                        /*De lo contrario*/ 
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Videojuego no agregado a la lista de carritos", "?controller=CarritoController&action=ver");
                        }
                    /*De lo contrario*/ 
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Videojuego no agregado a la lista de carritos", "?controller=CarritoController&action=ver");
                    }
                /*De lo contrario*/     
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Ha ocurrido un error al guardar el carrito", "?controller=CarritoController&action=ver");
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Ha ocurrido un error al guardar el carrito", "?controller=CarritoController&action=ver");
            }
        }

        public function eliminar(){
        }

    }

?>