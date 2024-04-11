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
        Funcion para guardar un mensaje en la base de datos
        */

        public function guardarMensajes(){

            //Instanciar mensaje
            $usuarioChat = new UsuarioChat();
            //Contruir objeto
            $usuarioChat -> setActivo(1);
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($_SESSION['mensajito']);
            $usuarioChat -> setIdChat($this -> obtenerIdChat());
            $usuarioChat -> setMensaje($_POST['mensaje']);
            $usuarioChat -> setFechaHora(date('Y-m-d H:i:s'));
            //Guardar mensaje en la base de datos
            $enviado = $usuarioChat -> guardar();
            //Retornar el resultado
            return $enviado;
        }

        /*
        Funcion para enviar un mensaje
        */

        public function enviarMensaje(){

            $chat = $_SESSION['mensajito'];

            //Traer la lista de mensajes enviados
            $listadoMensajesEnviados = $this -> mensajes();
            //Traer lista de chats
            $listadoChats = $this -> chats();
            //Guardar el mensaje en la base de datos
            $guardado = $this -> guardarMensajes();

            if($guardado){
                header("Location:"."http://localhost/Mercado-Juegos/?controller=ChatController&action=verMensajes&idContacto=$chat");
            }else{
                Ayudas::crearSesionYRedirigir("mensajeenviadoerror", "El mensaje no ha sido enviado con exito", '?controller=ChatController&action=verMensajes&idContacto=$chat');
            }
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
        Funcion para listar todos los mensajes recibidos
        */

        public function mensajes(){

            //Instanciar mensaje
            $usuarioChat = new UsuarioChat();
            $usuarioChat -> setIdRemitente($_SESSION['loginexitoso'] -> id);
            $usuarioChat -> setIdDestinatario($_SESSION['mensajito']);
            //Traer lista de mensajes
            $listadoMensajes = $usuarioChat -> obtenerMensajes();
            //Retornar lista
            return $listadoMensajes;
        }

        /*
        Funcion para ver los mensajes
        */

        public function verMensajes(){

            //Crear sesion del chat con el que se tienen mensajes
            $_SESSION['mensajito'] = $_GET['idContacto'];
            //Traer la lista de chats
            $listadoChats = $this -> chats();
            //Traer la lista de mensajes enviados
            $listadoMensajes = $this -> mensajes();
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