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

        public function guardarFavorito(){

            //Instanciar el objeto
            $favorito = new Favorito();
            //Crear el objeto
            $favorito -> setIdUsuario($_SESSION['loginexitoso'] -> id);
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
        Funcion para guardar el favorito videojuego en la base de datos
        */

        public function guardarFavoritoVideojuego($videojuegoId, $idFavorito){

            //Instanciar el objeto
            $favoritoVideojuego = new FavoritoVideojuego();
            //Crear el objeto
            $favoritoVideojuego -> setIdFavorito($idFavorito);
            $favoritoVideojuego -> setIdVideojuego($videojuegoId);
            $favoritoVideojuego -> setPrecio($this -> traer($videojuegoId) -> precio);
            //Guardar en la base de datos
            $guardadoVideojuegoFavorito = $favoritoVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoVideojuegoFavorito;
        }

        /*
        Funcion para guardar el favorito en la base de datos
        */

        public function guardar(){

            //Comprobar si llega el videojuego por el metodo get
            $videojuegoId = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;

            //Comprobar si los datos están llegando
            if($videojuegoId){

                //Comprobar si el usuario ya esta logueado
                if(!Ayudas::comprobarInicioDeSesionUsuario()){
                    //Crear sesion en caso de que la solicitud de videojuego favorito sea desde el catalogo y no desde el detalle del videojuego
                    isset($_GET['cat']) ? $_SESSION['catalogofavorito'] = true : $_SESSION['idvideojuegopendientefavorito'] = $videojuegoId;
                }

                //Llamar la funcion de ayuda en caso de que el usuario no este logueado
                Ayudas::restringirAUsuarioAlAgregarFavorito('?controller=UsuarioController&action=login', $videojuegoId);
                
                //Llamar la funcion de guardar favorito
                $guardado = $this -> guardarFavorito();

                //Comprobar si se guardo con exito el favorito
                if($guardado){

                    //Obtener el id del ultimo favorito guardado
                    $ultimoFavorito = $this -> obtenerUltimoFavorito();
                    //Llamar la funcion de guardar favorito videojuego
                    $guardadoVideojuegoFavorito = $this -> guardarFavoritoVideojuego($videojuegoId, $ultimoFavorito);

                    //Comprobar si se guardo con exito el favorito videojuego
                    if($guardadoVideojuegoFavorito){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarfavoritoacierto', "Videojuego agregado a la lista de favoritos con exito", "?controller=FavoritoController&action=ver");

                    }else{

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarfavoritoerror', "Videojuego no agregado a la lista de favoritos", "?controller=FavoritoController&action=ver");
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardarfavoritoerror', "Ha ocurrido un error al guardar el favorito", "?controller=FavoritoController&action=ver");
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarfavoritoerror', "Ha ocurrido un error al guardar el favorito", "?controller=FavoritoController&action=ver");
            }
        }
    }
?>