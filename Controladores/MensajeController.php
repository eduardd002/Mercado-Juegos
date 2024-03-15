<?php

    //Incluir el objeto de mensaje
    require_once 'Modelos/Mensaje.php';

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    class MensajeController{

        /*
        Funcion para cargar la vista de enviar mensaje
        */

        public function enviar(){
            //Incluir la vista
            require_once "Vistas/Chat/Comprador.html";
        }

        /*
        Funcion para cargar los chats
        */

        public function chats(){
            
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
                    $mensaje = new Mensaje();

                    //Crear el objeto
                    $mensaje -> setIdRemitente($_SESSION['login_exitoso'] -> id);
                    $mensaje -> setContenido($contenido);
                    $mensaje -> setFechaEnvio(date("d-m-y"));
                    $mensaje -> setHoraEnvio(date("H:i:s"));

                    //Guardar en la base de datos
                    $guardado = $mensaje -> guardar();

                    //Obtener id del ultimo mensaje registrado
                    $ultimo = $mensaje -> ultimo();

                    //Instanciar el objeto
                    $chat = new Chat();

                    //Crear el objeto

                    //Registrar id de videojuego futuro o proximo a registrar
                    $chat -> setIdMensaje($ultimo);
                    $chat -> setIdDestinatario(2);

                    //Guardar en la base de datos
                    $guardado2 = $chat -> guardar();

                    //Comprobar se ejecutó con exito las consultas
                    if(!$guardado || !$guardado2){
                        //Crear Sesion que indique que no se ha podido enviar el mensaje con exito
                        $_SESSION['mensajenoenviado'] = "El mensaje no se ha podido enviar con exito";
                    }
                    //Redirigir al chat
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=MensajeController&action=enviar");
                }
            }
        }
    }

?>