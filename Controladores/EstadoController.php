<?php

    /*Incluir el objeto de estado*/
    require_once 'Modelos/Estado.php';

    /*
    Clase controlador de estado
    */

    class EstadoController{
        
        /*
        Funcion para crear un estado
        */

        public function crear(){
            /*Incluir la vista*/
            require_once "Vistas/Estado/Crear.html";
        }

        /*
        Funcion para guardar un estado en la base de datos
        */

        public function guardarEstado($nombre){
            /*Instanciar el objeto*/
            $estado = new Estado();
            /*Crear el objeto*/
            $estado -> setActivo(1);
            $estado -> setNombre($nombre);
            /*Intentar guardar el estado en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $guardado = $estado -> guardar();
            /*Capturar la excepcion*/ 
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarestadoerror', "Este nombre de estado ya existe", '?controller=EstadoController&action=crear');
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para guardar un estado
        */

        public function guardar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_POST)){
                /*Comprobar si el dato existe*/
                $nombre = isset($_POST['nombreest']) ? $_POST['nombreest'] : false;
                /*Si el dato existe*/
                if($nombre){
                    /*Llamar la funcion de guardar estado*/
                    $guardado = $this -> guardarEstado($nombre);
                    /*Comprobar se ejecutó con exito la consulta*/
                    if($guardado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarestadoacierto', "El estado ha sido creado con exito", '?controller=AdministradorController&action=gestionarEstado');
                    /*De lo contrario*/  
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarestadoerror', "La consola no ha sido creado con exito", '?controller=EstadoController&action=crear');
                    }
                /*De lo contrario*/  
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarestadoerror', "Ha ocurrido un error al guardar el estado", '?controller=EstadoController&action=crear');
                }
            /*De lo contrario*/  
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarestadoerror', "Ha ocurrido un error al guardar el estado", '?controller=EstadoController&action=crear');
            }
        }

        /*
        Funcion para eliminar un estado en la base de datos
        */

        public function eliminarEstado($idEstado){
            /*Instanciar el objeto*/
            $estado = new Estado();
            /*Crear el objeto*/
            $estado -> setId($idEstado);
            /*Ejecutar la consulta*/
            $eliminado = $estado -> eliminar();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar un estado
        */

        public function eliminar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idEstado = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idEstado){
                    /*Llamar la funcion que elimina el estado*/
                    $eliminado = $this -> eliminarEstado($idEstado);
                    /*Comprobar si el estado ha sido eliminado con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarestadoacierto', "El estado ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarEstado');
                    /*De lo contrario*/ 
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarestadoerror', "El estado no ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarEstado');
                    }
                /*De lo contrario*/ 
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('eliminarestadoerror', "Ha ocurrido un error al eliminar el estado", '?controller=AdministradorController&action=gestionarEstado');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para editar un estado en la base de datos
        */

        public function editarEstado($id){
            /*Instanciar el objeto*/
            $estado = new Estado();
            /*Crear el objeto*/
            $idEstado = $estado -> setId($id);
            /*Retornar el resultado*/
            return $idEstado;
        }

        /*
        Funcion para editar un estado
        */

        public function editar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idEstado = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idEstado){
                    /*Llamar la funcion de editar estado*/
                    $estado = $this -> editarEstado($idEstado);
                    /*Comprobar si el estado ha sido editado*/
                    if($estado){
                        /*Llamar la funcion para obtener un estado en concreto*/
                        $estadoUnico = $estado -> obtenerUno();
                        /*Comprobar si el estado ha sido obtenido*/
                        if($estadoUnico){
                            /*Incluir la vista*/
                            require_once "Vistas/Estado/Actualizar.html";
                        /*De lo contrario*/    
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                        }
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                    }
                /*De lo contrario*/    
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para actualizar un estado en la base de datos
        */

        public function actualizarEstado($idEstado, $nombre){
            /*Instanciar el objeto*/
            $estado = new Estado();
            /*Crear el objeto*/
            $estado -> setId($idEstado);
            $estado -> setNombre($nombre);
            /*Intentar actualizar el estado en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $actualizado = $estado -> actualizar();
            /*Capturar la excepcion*/  
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('actualizarestadoerror', "Este nombre de estado ya existe", '?controller=EstadoController&action=editar&id='.$idEstado);
                /*Cortar la ejecucion*/                
                die();
            }
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para actualizar un estado
        */

        public function actualizar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $idEstado = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombreestact']) ? $_POST['nombreestact'] : false;
                /*Si los datos existen*/
                if($idEstado){
                    /*Llamar la funcion de actualizar el estado*/
                    $actualizado = $this -> actualizarEstado($idEstado, $nombre);
                    /*Comprobar si el estado ha sido actualizado*/
                    if($actualizado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarestadoacierto', "El estado ha sido actualizado exitosamente", '?controller=AdministradorController&action=gestionarEstado');
                    /*De lo contrario*/
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarestadosugerencia', "Introduce nuevos datos", '?controller=EstadoController&action=editar&id='.$idEstado);
                    }
                /*De lo contrario*/
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarestadoerror', "Ha ocurrido un error al actualizar el estado", '?controller=EstadoController&action=editar&id='.$idEstado);
                }  
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

    }

?>