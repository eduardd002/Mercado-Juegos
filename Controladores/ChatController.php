<?php

    //Incluir el objeto de chat
    require_once 'Modelos/Chat.php';

    class ChatController{

        public function enviar(){
            //Incluir la vista
            require_once "Vistas/Chat/Comprador.html";
        }

        public function guardar(){
            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $mensaje = isset($_POST['mensajec']) ? $_POST['mensajec'] : false;

                //Comprobar si todos los datos exsiten
                if($mensaje){
                    //Instanciar el objeto
                    $chat = new Chat();

                    //Crear el objeto
                    $chat -> setMensaje($mensaje);
                    $chat -> setIdComprador(1);
                    $chat -> setIdVendedor(1);

                    //Guardar en la base de datos
                    $guardado = $chat -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Redirigir al registro de Administrador
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=ChatController&action=enviar");
                    }else{
                        
                    }
                }
            }
        }
    }

?>