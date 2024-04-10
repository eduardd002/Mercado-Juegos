<?php

    //Incluir el objeto de chat
    require_once 'Modelos/UsuarioChat.php';

    class ChatController{

        /*
        Funcion para listar todos los chats
        */

        public function chats(){

            //Instanciar objeto
            $usuarioChat = new UsuarioChat();
            //Crear objeto
            $usuarioChat -> setActivo(1);
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($_SESSION['loginexitoso'] -> id);
            //Traer lista de chats
            $listadoChats = $usuarioChat -> obtenerChats();
            //Retornar lista
            return $listadoChats;
        }

        /*
        Funcion para cargar la ventana del chat y sus respectivos chats
        */

        public function chatear(){

            //Traer la lista de chats
            $listadoChats = $this -> chats();
            //Incluir la vista
            require_once "Vistas/Chat/Chat.html";
        }

        /*
        Funcion para ver los mensajes
        */

        public function verMensajes(){

            //Crear sesion del chat con el que se tienen mensajes
            $_SESSION['mensajito'] = $_GET['idContacto'];
            //Traer la lista de chats
            $listadoChats = $this -> chats();
            //Incluir la vista
            require_once "Vistas/Chat/Chat.html";
        }

        public function obtenerIdChat(){
            
            //Instanciar objeto
            $usuarioChat = new UsuarioChat();
            //Crear objeto
            $usuarioChat -> setActivo(1);
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($_SESSION['mensajito']);
            $identificador = $usuarioChat -> obtenerIdentificadorPropioDeChat();
            return $identificador;
        }
    }

?>