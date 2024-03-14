<?php

    //Incluir el objeto de comentario
    require_once 'Modelos/Comentario.php';

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

                    //Instanciar el objeto
                    $comentario = new Comentario();

                    //Crear el objeto
                    $comentario -> setIdUsuario($_SESSION['login_exitoso'] -> id);
                    $comentario -> setIdVideojuego($videojuego);
                    $comentario -> setContenido($contenido);
                    $comentario -> setFechaCreacion(date('y-m-d'));
                    $comentario -> setHoraCreacion(date("H:i:s"));

                    //Guardar en la base de datos
                    $guardado = $comentario -> guardar();

                    if($guardado){
                        //Crear sesion que indique que el comentario se ha hecho exitosamente
                        $_SESSION['comentariocreado'] = "El comentario se ha hecho con exito";
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