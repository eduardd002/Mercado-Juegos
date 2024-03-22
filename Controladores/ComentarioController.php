<?php

    //Incluir el objeto de comentario
    require_once 'Modelos/Comentario.php';

    //Incluir el objeto de videojuegocomentario
    require_once 'Modelos/ComentarioVideojuego.php';

    class ComentarioController{

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

                    //Instanciar el objeto
                    $comentario = new Comentario();

                    //Crear el objeto
                    $comentario -> setIdUsuario($_SESSION['loginexitoso'] -> id);
                    $comentario -> setContenido($contenido);
                    $comentario -> setFechaCreacion(date('y-m-d'));
                    $comentario -> setHoraCreacion(date("H:i:s"));

                    //Guardar en la base de datos
                    $guardado = $comentario -> guardar();

                    //Comprobar si el comentario ha sido guardado
                    if($guardado){

                        //Obtener id del ultimo videojuego registrado
                        $id = $comentario -> ultimo();

                        //Instanciar el objeto
                        $comentarioVideojuego = new ComentarioVideojuego();

                        //Crear el objeto
                        $comentarioVideojuego -> setIdVideojuego($videojuego);
                        $comentarioVideojuego -> setIdComentario($id);

                        //Guardar en la base de datos
                        $guardadoComentarioVideojuego = $comentarioVideojuego -> guardar();

                        //Comprobar si el comentario relacionado al videojuego se ha guardado
                        if($guardadoComentarioVideojuego){
                            //Crear sesion que indique que el comentario se ha hecho exitosamente
                            $_SESSION['comentariocreado'] = "El comentario se ha hecho con exito";
                        }
                    }else{
                        //Crear sesion que indique que el comentario no se ha hecho exitosamente
                        $_SESSION['comentariocreado'] = "El comentario no se ha hecho con exito";
                    }
                    //Redirigir al detalle del videojuego
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=$videojuego");
                }
            }
        }
    }

?>