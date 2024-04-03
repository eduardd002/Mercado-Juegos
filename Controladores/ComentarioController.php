<?php

    //Incluir el objeto de comentario
    require_once 'Modelos/Comentario.php';

    //Incluir el objeto de videojuegocomentario
    require_once 'Modelos/ComentarioVideojuego.php';

    class ComentarioController{

        /*
        Funcion para guardar el comentario en la base de datos
        */

        public function guardarComentario($contenido){

            //Instanciar el objeto
            $comentario = new Comentario();
            //Crear el objeto
            $comentario -> setActivo(1);
            $comentario -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $comentario -> setContenido($contenido);
            $comentario -> setFechaCreacion(date('y-m-d'));
            $comentario -> setHoraCreacion(date("H:i:s"));
            //Guardar en la base de datos
            $guardado = $comentario -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo comentario guardado
        */

        public function obtenerUltimo(){

            //Instanciar el objeto
            $comentario = new Comentario();
            //Obtener id del ultimo videojuego registrado
            $id = $comentario -> ultimo();
            //Retornar el resultado
            return $id;
        }

        /*
        Funcion para guardar el comentario videojuego en la base de datos
        */

        public function guardarComentarioVideojuego($videojuego, $id){

            //Instanciar el objeto
            $comentarioVideojuego = new ComentarioVideojuego();
            //Crear el objeto
            $comentarioVideojuego -> setActivo(1);
            $comentarioVideojuego -> setIdVideojuego($videojuego);
            $comentarioVideojuego -> setIdComentario($id);
            //Guardar en la base de datos
            $guardadoComentarioVideojuego = $comentarioVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoComentarioVideojuego;
        }

        /*
        Funcion para guardar un comentario en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST) && (isset($_GET))){

                //Comprobar si los datos existen
                $contenido = isset($_POST['comentario']) ? $_POST['comentario'] : false;
                $videojuego = isset($_GET['id']) ? $_GET['id'] : false;

                //Comprobar si todos los datos exsiten
                if($contenido && $videojuego){

                    //Llamar la funcion de restringir al usuario en caso de que no este logueado y quiera comentar
                    Ayudas::restringirAUsuarioAlComentar('?controller=UsuarioController&action=login', $videojuego);

                    //Obtener resultado
                    $guardado = $this -> guardarComentario($contenido);

                    //Comprobar si el comentario ha sido guardado
                    if($guardado){

                        //Obtener resultado
                        $id = $this -> obtenerUltimo();
                        //Obtener resultado
                        $guardadoComentarioVideojuego = $this -> guardarComentarioVideojuego($videojuego, $id);

                        //Comprobar si el comentario relacionado al videojuego se ha guardado
                        if($guardadoComentarioVideojuego){

                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('guardarcomentarioacierto', "El comentario se ha hecho con exito", "?controller=VideojuegoController&action=detalle&id=$videojuego");
                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('guardarcomentarioerror', "El comentario no se ha hecho con exito", "?controller=VideojuegoController&action=detalle&id=$videojuego");
                        }
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarcomentarioerror', "El comentario no se ha hecho con exito", "?controller=VideojuegoController&action=detalle&id=$videojuego");
                    }
                }
            }
        }
    }

?>