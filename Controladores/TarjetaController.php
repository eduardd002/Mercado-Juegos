<?php

    //Incluir el objeto de tarjeta
    require_once 'Modelos/Tarjeta.php';

    class TarjetaController{

        /*
        Funcion para crear una tarjeta
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Tarjeta/Crear.html";
        }

        /*
        Funcion para guardar una tarjeta en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombretar']) ? $_POST['nombretar'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $tarjeta = new Tarjeta();

                    //Crear el objeto
                    $tarjeta -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $tarjeta -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de tarjeta creada
                        $_SESSION['tarjetacreada'] = 'La tarjeta ha sido creada con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la tarjeta
                        $_SESSION['tarjetacreada'] = 'La tarjeta no ha sido creada con exito';
                        //Redirigir al registro de tarjeta
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearTarjeta");
                    }
                }
            }
        }

        /*
        Funcion para eliminar una tarjeta
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idTarjeta = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idTarjeta){

                    //Instanciar el objeto
                    $tarjeta = new Tarjeta();

                    //Crear objeto
                    $tarjeta -> setId($idTarjeta);

                    //Ejecutar la consulta
                    $eliminado = $tarjeta -> eliminar();

                    if($eliminado){
                        //Crear Sesion que indique que la tarjeta se ha eliminado con exito
                        $_SESSION['tarjetaeliminada'] = "La tarjeta ha sido eliminada exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que la tarjeta se ha eliminado con exito
                        $_SESSION['tarjetaeliminada'] = "La tarjeta no ha sido eliminado exitosamente";
                        //Redirigir a la gestion de tarjetas
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarTarjeta");
                    }
                }  
            }
        }

    }

?>