<?php

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    //Incluir el objeto de mensaje
    require_once 'Modelos/Mensaje.php';

    class ChatController{

        /*
        Funcion para cargar la ventana del chat
        */

        public function chatear(){

            $chat = new Chat();
            $chat -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $listadoChats = $chat -> obtenerChats();

            //Incluir la vista
            require_once "Vistas/Chat/Chat.html";
        }

        public function verMensajes(){

            $chat = new Chat();
            $chat -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $listadoChats = $chat -> obtenerChats();

            $idContacto = $_GET['idContacto'];

            $mensaje = new Mensaje();
            $listadoMensajes = $mensaje -> obtenerMensajes();

            //Incluir la vista
            require_once "Vistas/Chat/Chat.html";

        }

        public function enviarMensaje(){

            $mensaje = new Mensaje();

            $mensaje -> setContenido($_POST['mensaje']);
            $mensaje -> setFechaEnvio(date('Y-m-d'));
            $mensaje -> setHoraEnvio(date("H:i:s"));
            $mensaje -> guardar();

        }
        
    }

?>