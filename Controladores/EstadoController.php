<?php

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

    class EstadoController{

        
        /*
        Funcion para crear un estado
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Estado/Crear.html";
        }

        /*
        Funcion para guardar un estado en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreest']) ? $_POST['nombreest'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $estado = new Estado();

                    //Crear el objeto
                    $estado -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $estado -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de estado creado
                        $_SESSION['estadocreado'] = 'El estado ha sido creado con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar el estado
                        $_SESSION['categorianocreada'] = 'El estado no ha sido creado con exito';
                        //Redirigir al registro de estado
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearEstado");
                    }
                }
            }
        }

    }

?>