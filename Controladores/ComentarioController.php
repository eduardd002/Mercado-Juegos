<?php

    //Incluir el objeto de videojuegocomentario
    require_once 'Modelos/ComentarioUsuarioVideojuego.php';

    class ComentarioController{

        /*
        Funcion para guardar el comentario en la base de datos
        */

        public function guardarComentario($contenido, $videojuego){

            //Instanciar el objeto
            $comentarioUsuarioVideojuego = new ComentarioUsuarioVideojuego();
            //Crear el objeto
            $comentarioUsuarioVideojuego -> setActivo(1);
            $comentarioUsuarioVideojuego -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $comentarioUsuarioVideojuego -> setContenido($contenido);
            $comentarioUsuarioVideojuego -> setIdVideojuego($videojuego);
            $comentarioUsuarioVideojuego -> setFechaHora(date('Y-m-d H:i:s'));
            //Guardar en la base de datos
            $guardado = $comentarioUsuarioVideojuego -> guardar();
            //Retornar el resultado
            return $guardado;
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
                    $guardado = $this -> guardarComentario($contenido, $videojuego);

                    //Comprobar si el comentario ha sido guardado
                    if($guardado){


                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('guardarcomentarioacierto', "El comentario se ha hecho con exito", "?controller=VideojuegoController&action=detalle&id=$videojuego");
                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('guardarcomentarioerror', "El comentario no se ha hecho con exito", "?controller=VideojuegoController&action=detalle&id=$videojuego");
                        }
                }
            }
        }

        /*
        Funcion para eliminar un usuario
        */

        public function eliminarComentario($idComentario){

            //Instanciar el objeto
            $comentarioUsuarioVideojuego = new ComentarioUsuarioVideojuego();
            //Crear objeto
            $comentarioUsuarioVideojuego -> setId($idComentario);
            //Ejecutar la consulta
            $eliminado = $comentarioUsuarioVideojuego -> eliminar();
            //Retornar el resultado
            return $eliminado;
        }

        /*
        Funcion para eliminar un usuario desde el administrador
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idComentario = isset($_GET['idComentario']) ? $_GET['idComentario'] : false;
                $idVideojuego = isset($_GET['idVideojuego']) ? $_GET['idVideojuego'] : false;

                //Si el dato existe
                if($idComentario && $idVideojuego){

                    //Ejecutar la consulta
                    $eliminado = $this -> eliminarComentario($idComentario);

                    //Comprobar si el usuario ha sido eliminado
                    if($eliminado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarcomentarioacierto', "El comentario ha sido eliminado exitosamente", '?controller=VideojuegoController&action=detalle&id='.$idVideojuego);
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarcomentarioerror', "El comentario no ha sido eliminado exitosamente", '?controller=VideojuegoController&action=detalle&id='.$idVideojuego);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminarcomentarioerror', "Ha ocurrido un error al eliminar el comentario", '?controller=VideojuegoController&action=detalle&id='.$idVideojuego);
                }
            }
        }
    }

?>