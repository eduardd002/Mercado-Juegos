<?php

    //Incluir el objeto de mensaje
    require_once 'Modelos/Mensaje.php';

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    class MensajeController{

        public function enviar(){
            //Incluir la vista
            require_once "Vistas/Chat/Comprador.html";
        }

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

                    //Guardar en la base de datos
                    $guardado = $mensaje -> guardar();

                    //Obtener id del ultimo mensaje registrado
                    $resultado = $mensaje -> ultimoMensaje();
                    $ultimo = $resultado -> id;

                    //Instanciar el objeto
                    $chat = new Chat();

                    //Crear el objeto

                    //Registrar id de videojuego futuro o proximo a registrar
                    $chat -> setIdMensaje($ultimo);
                    $chat -> setIdDestinatario(2);

                    //Guardar en la base de datos
                    $guardado2 = $chat -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Redirigir al registro de Administrador
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=MensajeController&action=enviar");
                    }else{
                        
                    }
                }
            }
        }
    }

?>