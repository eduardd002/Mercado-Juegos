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

        public function guardarEstado($nombre){

            //Instanciar el objeto
            $estado = new Estado();
            //Crear el objeto
            $estado -> setNombre($nombre);
            //Guardar en la base de datos
            $guardado = $estado -> guardar();
            //Retornar resultado
            return $guardado;
        }

        /*
        Funcion para guardar un estado
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreest']) ? $_POST['nombreest'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    
                    //Obtener el resultado
                    $guardado = $this -> guardarEstado($nombre);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarestadoacierto', "El estado ha sido creado con exito", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarestadoerror', "El estado no ha sido creado con exito", '?controller=AdministradorController&action=crearEstado');
                    }
                }
            }
        }

        /*
        Funcion para eliminar un estado en la base de datos
        */

        public function eliminarEstado($idEstado){

            //Instanciar el objeto
            $estado = new Estado();
            //Crear objeto
            $estado -> setId($idEstado);
            //Ejecutar la consulta
            $eliminado = $estado -> eliminar();
            //Retornar resultado
            return $eliminado;
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

                    //Obtener el resultado
                    $eliminado = $this -> eliminarEstado($idEstado);

                    //Comprobar si el estado ha sido eliminado con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarestadoacierto', "El estado ha sido eliminado exitosamente", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarestadoerror', "El estado no ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarEstado');
                    }
                }  
            }
        }

        /*
        Funcion para editar un estado en la base de datos
        */

        public function editarEstado($idEstado){

            //Instanciar el objeto
            $estado = new Estado();
            //Creo el objeto y retornar el resultado
            return $estado -> setId($idEstado);
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

                    //Obtener el resultado
                    $estado = $this -> editarEstado($idEstado);

                    //Obtener estado
                    $estadoUnico = $estado -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Estado/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar un estado en la base de datos
        */

        public function actualizarEstado($idEstado, $nombre){

            //Instanciar el objeto
            $estado = new Estado();
            //Crear objeto
            $estado -> setId($idEstado);
            $estado -> setNombre($nombre);
            //Ejecutar la consulta
            $actualizado = $estado -> actualizar();
            //Retornar el resultado
            return $actualizado;
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

                    //Obtener el resultado
                    $actualizado = $this -> actualizarEstado($idEstado, $nombre);

                    //Comprobar si el estado ha sido actualizado
                    if($actualizado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarestadoacierto', "El estado ha sido actualizado exitosamente", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarestadoerror', "El estado no ha sido actualizado exitosamente", '?controller=AdministradorController&action=gestionarEstado');
                    }
                }  
            }
        }
    }

?>