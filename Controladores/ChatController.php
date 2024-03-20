<?php

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    class ChatController{

        /*
        Funcion para cargar la vista de chats de comprador
        */

        public function chatsComprador(){

            //Instanciar el objeto
            $chat = new Chat();
            $chat -> setIdRemitente($_SESSION['login_exitoso'] -> id);
            //Listar todas las categorias desde la base de datos
            $listadoChatsComprador = $chat -> listarMensajesEnviados();
            $listadoChatsVendedor = $chat -> listarMensajesRecibidos();

            //Incluir la vista
            require_once "Vistas/Chat/Comprador.html";
        }

        /*
        Funcion para cargar los chats
        */

        public function chatsVendedor(){
            
            //Instanciar el objeto
            $chat = new Chat();
            $chat -> setIdRemitente($_SESSION['login_exitoso'] -> id);
            //Listar todas las categorias desde la base de datos
            $listadoChatsComprador = $chat -> listarMensajesEnviados();
            $listadoChatsVendedor = $chat -> listarMensajesRecibidos();

            //Incluir la vista
            require_once "Vistas/Chat/Vendedor.html";
        }

        /*
        Funcion para guardar el chat en la base de datos
        */

        public function guardar(){
            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $contenido = isset($_POST['mensajec']) ? $_POST['mensajec'] : false;

                //Comprobar si todos los datos exsiten
                if($contenido){
                    //Instanciar el objeto
                    $chat = new Chat();

                    //Crear el objeto
                    $chat -> setIdDestinatario(1);
                    $chat -> setIdRemitente($_SESSION['login_exitoso'] -> id);
                    $chat -> setContenido($contenido);
                    $chat -> setFechaEnvio(date("d-m-y"));
                    $chat -> setHoraEnvio(date("H:i:s"));

                    //Guardar en la base de datos
                    $guardado = $chat -> guardar();

                    //Comprobar se ejecutó con exito las consultas
                    if(!$guardado){
                        //Crear Sesion que indique que no se ha podido enviar el mensaje con exito
                        $_SESSION['mensajenoenviado'] = "El mensaje no se ha podido enviar con exito";
                    }
                    //Redirigir al chat
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=ChatController&action=chatsComprador");
                }
            }
        }
    }

?>