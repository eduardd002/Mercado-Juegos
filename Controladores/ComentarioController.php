<?php

    require_once 'Modelos/Comentario.php';

    class ComentarioController{

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST) && (isset($_GET))){

                //Comprobar si el dato existe
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
                        //Redirigir al registro de usuario
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=$videojuego");
                    }

                }

            }

        }
        
        public function listar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                $videojuego = isset($_GET['id']) ? $_GET['id'] : false;



       

                //Incluir la vista
                require_once 'Vistas/Videojuego/Detalle.html';

            }

            
        }

    }

?>