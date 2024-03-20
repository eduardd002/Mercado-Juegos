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

        public function guardar(){

            //Comprobar si existe la sesion de usuario logueado
            $usuarioId = isset($_SESSION['login_exitoso']) ? $_SESSION['login_exitoso'] -> id : false;
            $videojuegoId = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;

            //Comprobar si los datos están llegando
            if(isset($_POST) && isset($_GET)){

                //Instanciar el objeto
                $favorito = new Favorito();

                //Crear el objeto
                $favorito -> setIdUsuario($usuarioId);

                //Guardar en la base de datos
                $guardado = $favorito -> guardar();

                //Comprobar se ejecutaron con exito las consultas
                if($guardado){

                    //Obtener id del ultimo videojuego registrado
                    $idFavorito = $favorito -> ultimo();

                    //Instanciar el objeto
                    $videojuego = new Videojuego();

                    $videojuego -> setId($videojuegoId);

                    //Obtener id del ultimo videojuego registrado
                    $videojuegoActual = $videojuego -> traerUno();

                    //Instanciar el objeto
                    $favoritoVideojuego = new FavoritoVideojuego();

                    //Crear el objeto

                    //Registrar id de videojuego futuro o proximo a registrar
                    $favoritoVideojuego -> setIdFavorito($idFavorito);
                    $favoritoVideojuego -> setIdVideojuego($videojuegoId);
                    $favoritoVideojuego -> setPrecio($videojuegoActual -> precio);

                    $guardadoVideojuegoFavorito = $favoritoVideojuego -> guardar();

                    if($guardadoVideojuegoFavorito){
                        //Crear sesion de videojuego creado con exito
                        $_SESSION['videojuegofavorito'] = "Videojuego agregado a la lista de favoritos";
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=$videojuegoId");
                    }else{
                        //Crear sesion que indique que la imagen debe ser de formato imagen
                        $_SESSION['videojuegofavorito'] = "El ideojuego no ha sido agregado a la lista de favoritos";
                        //Redirigir al registro de videojuego
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                    }
                }
            }
        }
    }

?>