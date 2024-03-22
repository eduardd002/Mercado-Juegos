<?php

    //Incluir el objeto de videojuego
    require_once 'Modelos/Videojuego.php';

    //Incluir el objeto de favorito
    require_once 'Modelos/Favorito.php';

    //Incluir el objeto de videojuego favorito
    require_once 'Modelos/FavoritoVideojuego.php';

    class FavoritoController{

        /*
        Funcion para ver los favoritos
        */

        public function ver(){

            //Incluir la vista
            require_once "Vistas/Favorito/Favoritos.html";
        }

        /*
        Funcion para guardar el favorito en la base de datos
        */

        public function guardarFavorito($usuarioId){

            //Instanciar el objeto
            $favorito = new Favorito();
            //Crear el objeto
            $favorito -> setIdUsuario($usuarioId);
            //Guardar en la base de datos
            $guardado = $favorito -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo videojuego guardado
        */

        public function obtenerUltimoFavorito(){

            //Instanciar el objeto
            $favorito = new Favorito();
            //Obtener id del ultimo videojuego registrado
            $idFavorito = $favorito -> ultimo();
            //Retornar el resultado
            return $idFavorito;
        }

        /*
        Funcion para guardar el favorito videojuego en la base de datos
        */

        public function guardarFavoritoVideojuego($videojuegoId, $idFavorito){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear el objeto
            $videojuego -> setId($videojuegoId);
            //Obtener id del ultimo videojuego registrado
            $videojuegoActual = $videojuego -> traerUno();
            //Instanciar el objeto
            $favoritoVideojuego = new FavoritoVideojuego();
            //Crear el objeto
            $favoritoVideojuego -> setIdFavorito($idFavorito);
            $favoritoVideojuego -> setIdVideojuego($videojuegoId);
            $favoritoVideojuego -> setPrecio($videojuegoActual -> precio);
            //Guardar en la base de datos
            $guardadoVideojuegoFavorito = $favoritoVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoVideojuegoFavorito;
        }

        /*
        Funcion para guardar el favorito en la base de datos
        */

        public function guardar(){

            //Comprobar si existe la sesion de usuario logueado
            $usuarioId = isset($_SESSION['loginexitoso']) ? $_SESSION['loginexitoso'] -> id : false;
            //Comprobar si llega el videojuego por el metodo get
            $videojuegoId = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;

            //Comprobar si los datos están llegando
            if(isset($_POST) && $usuarioId && $videojuegoId){

                //Crear sesion en caso de que la solicitud de videojuego favorito sea desde el catalogo y no desde el detalle del videojuego
                isset($_GET['cat']) ? true : false;
                //Llamar la funcion de ayuda en caso de que el usuario no este logueado
                Ayudas::restringirAUsuarioAlAgregarFavorito('?controller=UsuarioController&action=login', $videojuegoId);
                //Llamar la funcion de guardar favorito
                $guardado = $this -> guardarFavorito($usuarioId);

                //Comprobar si se guardo con exito el favorito
                if($guardado){

                    //Obtener el id del ultimo favorito guardado
                    $ultimoFavorito = $this -> obtenerUltimoFavorito();
                    //Llamar la funcion de guardar favorito videojuego
                    $guardadoVideojuegoFavorito = $this -> guardarFavoritoVideojuego($videojuegoId, $ultimoFavorito);

                    //Comprobar si se guardo con exito el favorito videojuego
                    if($guardadoVideojuegoFavorito){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('videojuegofavorito', "Videojuego agregado a la lista de favoritos", "http://localhost/Mercado-Juegos/?controller=FavoritoController&action=ver");

                    }else{

                        if(isset($_GET['cat'])){
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('videojuegofavorito', "Videojuego agregado a la lista de favoritos", "http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('videojuegofavorito', "Videojuego agregado a la lista de favoritos", "http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=$videojuegoId");
                        }
                    }

                }else{

                    if(isset($_GET['cat'])){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('videojuegofavorito', "Videojuego agregado a la lista de favoritos", "http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('videojuegofavorito', "Videojuego agregado a la lista de favoritos", "http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=$videojuegoId");
                    }
                }
            }
        }
    }
?>