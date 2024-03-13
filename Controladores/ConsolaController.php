<?php

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    class ConsolaController{

        /*
        Funcion para crear una consola
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Consola/Crear.html";
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
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la consola
                        $_SESSION['consolanocreada'] = 'La consola no ha sido creada con exito';
                        //Redirigir al registro de consola
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearConsola");
                    }
                }
            }
        }

        /*
        Funcion para eliminar una consola
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idConsola = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idConsola){

                    //Instanciar el objeto
                    $consola = new Consola();

                    //Crear objeto
                    $consola -> setId($idConsola);

                    //Ejecutar la consulta
                    $eliminado = $consola -> eliminar();

                    if($eliminado){
                        //Crear Sesion que indique que el consola se ha eliminado con exito
                        $_SESSION['consolaeliminada'] = "La consola ha sido eliminada exitosamente";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que la consola se ha eliminado con exito
                        $_SESSION['consolaeliminada'] = "La consola no ha sido eliminada exitosamente";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarConsola");
                    }
                }  
            }
        }

    }

?>