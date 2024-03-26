<?php

    //Incluir el objeto de chat
    require_once 'Modelos/UsuarioChat.php';

    //Incluir el objeto de mensaje
    require_once 'Modelos/Mensaje.php';

    class ChatController{

        /*
        Funcion para cargar la ventana del chat y sus respectivos chats
        */

        public function chatear(){

            //Instanciar objeto
            $usuarioChat = new UsuarioChat();
            //Crear objeto
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            //Traer lista de chats
            $listadoChats = $usuarioChat -> obtenerChats();

            //Incluir la vista
            require_once "Vistas/Chat/Chat.html";
        }
    }

?>