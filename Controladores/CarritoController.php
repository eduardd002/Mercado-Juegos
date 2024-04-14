<?php

    require_once 'Modelos/Carrito.php';

    require_once 'Modelos/Videojuego.php';

    require_once 'Modelos/CarritoVideojuego.php';

    class CarritoController{

        /*
        Funcion para ver los carritos
        */

        public function ver(){

            //Instaciar el objeto
            $carrito = new Carrito();
            //Traer los datos de la consulta
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $listadoCarritos = $carrito -> listar();
            //Incluir la vista
            require_once "Vistas/Carrito/Carritos.html";
        }

        /*
        Funcion para guardar el carrito en la base de datos
        */

        public function guardarCarrito(){

            //Instanciar el objeto
            $carrito = new Carrito();
            //Crear el objeto
            $carrito -> setActivo(1);
            $carrito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            //Guardar en la base de datos
            $guardado = $carrito -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo videojuego guardado
        */

        public function obtenerUltimoCarrito(){

            //Instanciar el objeto
            $carrito = new Carrito();
            //Obtener id del ultimo videojuego registrado
            $idCarrito = $carrito -> ultimo();
            //Retornar el resultado
            return $idCarrito;
        }

        /*
        Funcion para traer un videojuego en concreto
        */

        public function traer($videojuegoId){
            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear el objeto
            $videojuego -> setId($videojuegoId);
            //Obtener id del ultimo videojuego registrado
            $videojuegoActual = $videojuego -> traerUno();
            //Retornar el resultado
            return $videojuegoActual;
        }

        /*
        Funcion para guardar el carrito videojuego en la base de datos
        */

        public function guardarCarritoVideojuego($videojuegoId, $idCarrito, $unidades){

            $videojuego = $this -> traer($videojuegoId);

            //Instanciar el objeto
            $carritoVideojuego = new CarritoVideojuego();
            //Crear el objeto
            $carritoVideojuego -> setActivo(1);
            $carritoVideojuego -> setIdCarrito($idCarrito);
            $carritoVideojuego -> setIdVideojuego($videojuegoId);
            $carritoVideojuego -> setUnidades($unidades);
            $carritoVideojuego -> setPrecio($videojuego['videojuego']['precioVideojuego']);
            //Guardar en la base de datos
            $guardadoVideojuegoCarrito = $carritoVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoVideojuegoCarrito;
        }

        /*
        Funcion para guardar el carrito en la base de datos
        */

        public function guardar(){

            //Comprobar si llega el videojuego por el metodo get
            $videojuegoId = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;
            $unidades = isset($_GET['unidades']) ? $_GET['unidades'] : false;

            //Comprobar si los datos están llegando
            if($videojuegoId && $unidades){
                
                //Llamar la funcion de guardar carrito
                $guardado = $this -> guardarCarrito();

                //Comprobar si se guardo con exito el carrito
                if($guardado){

                    //Obtener el id del ultimo carrito guardado
                    $ultimoCarrito = $this -> obtenerUltimoCarrito();
                    //Llamar la funcion de guardar carrito videojuego
                    $guardadoVideojuegoCarrito = $this -> guardarCarritoVideojuego($videojuegoId, $ultimoCarrito, $unidades);

                    //Comprobar si se guardo con exito el carrito videojuego
                    if($guardadoVideojuegoCarrito){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarcarritoacierto', "Videojuego agregado a la lista de carritos con exito", "?controller=CarritoController&action=ver");

                    }else{

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Videojuego no agregado a la lista de carritos", "?controller=CarritoController&action=ver");
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Ha ocurrido un error al guardar el carrito", "?controller=CarritoController&action=ver");
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarcarritoerror', "Ha ocurrido un error al guardar el carrito", "?controller=CarritoController&action=ver");
            }
        }
    }

?>