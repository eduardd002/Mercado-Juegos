<?php

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    class ConsolaController{

        /*
        Funcion para crear una consola
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearConsolas.html";
        }

        /*
        Funcion para guardar una consola en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombrecon']) ? $_POST['nombrecon'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $consola = new Consola();

                    //Crear el objeto
                    $consola -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $consola -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de consola creada
                        $_SESSION['consolacreada'] = 'La consola ha sido creada con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la consola
                        $_SESSION['consolanocreada'] = 'La consola no ha sido creada con exito';
                        //Redirigir al registro de consola
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearConsola");
                    }
                }
            }
        }

    }

?>