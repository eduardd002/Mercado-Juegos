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
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar el estado
                        $_SESSION['estadocreado'] = 'El estado no ha sido creado con exito';
                        //Redirigir al registro de estado
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearEstado");
                    }
                }
            }
        }

        /*
        Funcion para eliminar un estado
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idEstado = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idEstado){

                    //Instanciar el objeto
                    $estado = new Estado();

                    //Crear objeto
                    $estado -> setId($idEstado);

                    //Ejecutar la consulta
                    $eliminado = $estado -> eliminar();

                    //Comprobar si el estado se elimina el estado exitosamente
                    if($eliminado){
                        //Crear Sesion que indique que el estado se ha eliminado con exito
                        $_SESSION['estadoeliminado'] = "El estado ha sido eliminado exitosamente";
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que el estado se ha eliminado con exito
                        $_SESSION['estadoeliminado'] = "El estado no ha sido eliminado exitosamente";
                        //Redirigir a la gestion de estado
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarEstado");
                    }
                }  
            }
        }

        /*
        Funcion para editar un estado
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idEstado = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idEstado){

                    //Instanciar el objeto
                    $estado = new Estado();

                    //Creo el objeto
                    $estado -> setId($idEstado);

                    //Obtener estado
                    $estadoUnico = $estado -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Estado/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar un estado
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $idEstado = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombreestact']) ? $_POST['nombreestact'] : false;

                //Si el dato existe
                if($idEstado){

                    //Instanciar el objeto
                    $estado = new Estado();

                    //Crear objeto
                    $estado -> setId($idEstado);
                    $estado -> setNombre($nombre);

                    //Ejecutar la consulta
                    $actualizado = $estado -> actualizar();

                    //Comprobar si el estado se actualiza con exito
                    if($actualizado){
                        //Crear Sesion que indique que el estado se ha actualizado con exito
                        $_SESSION['estadoactualizado'] = "El estado ha sido actualizado exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que el estado se ha actualizado con exito
                        $_SESSION['estadoactualizado'] = "El estado no ha sido actualizada exitosamente";
                        //Redirigir a la gestion de estados
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarEstado");
                    }
                }  
            }
        }
    }

?>