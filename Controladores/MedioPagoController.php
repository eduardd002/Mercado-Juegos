<?php

    /*Incluir el objeto de medio de pago*/
    require_once 'Modelos/MedioPago.php';

    /*
    Clase controlador de medio de pago
    */

    class MedioPagoController{

        /*
        Funcion para crear un medio de pago
        */

        public function crear(){
            /*Incluir la vista*/
            require_once "Vistas/MedioPago/Crear.html";
        }

        /*
        Funcion para ver los medios de pago eliminados
        */

        public function verMediosPagoEliminados(){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Listar todas las consolas desde la base de datos*/
            $listadoMediosPago = $medioPago -> listarInactivos();
            /*Incluir la vista*/
            require_once "Vistas/MedioPago/Inactivos.html";
        }

        /*
        Funcion para obtener el nombre del medio de pago
        */

        public function obtenerNombre($id){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setId($id);
            /*Ejecutar la consulta*/
            $medioPagoUnico = $medioPago -> obtenerUno();
            /*Obtener el resultado*/
            $resultado = $medioPagoUnico -> nombre;
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para guardar un medio de pago en la base de datos
        */

        public function guardarMedioPago($nombre){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setactivo(TRUE);
            $medioPago -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $guardado = $medioPago -> guardar();
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para comprobar si el medio de pago ya ha sido creado previamente
        */

        public function comprobarUnicoMedioPago($id, $nombre){
            /*Comprobar si el id es nulo*/
            if($id != null){
                /*Llamar la funcion que obtiene el nombre del medio de pago en concreto*/
                $nombreActual = $this -> obtenerNombre($id);
            }
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $medioPago -> comprobarMedioPagoUnico($nombreActual);
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para recuperar el medio de pago eliminado
        */

        public function recuperarMedioPago($nombre){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $medioPago -> recuperarMedioPago();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para guardar un medio de pago
        */

        public function guardar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_POST)){
                /*Comprobar si el dato existe*/
                $nombre = isset($_POST['nombretar']) ? $_POST['nombretar'] : false;
                /*Si el dato existe*/
                if($nombre){
                    /*Llamar funcion que comprueba si el medio de pago ya ha sido registrado*/
                    $unico = $this -> comprobarUnicoMedioPago(null, $nombre);
                    /*Comprobar si el nombre de la consola no existe*/
                    if($unico == null){
                        /*Llamar la funcion de guardar medio de pago*/
                        $guardado = $this -> guardarMedioPago($nombre);
                        /*Comprobar se ejecutó con exito la consulta*/
                        if($guardado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarmediopagoacierto', "El medio de pago ha sido creado con exito", '?controller=AdministradorController&action=gestionarMedioPago');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "El medio de pago no ha sido creado con exito", '?controller=MedioPagoController&action=crear');
                        }
                    /*Comprobar si el medio de pago existe y esta activo*/    
                    }elseif($unico -> activo == TRUE){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "Este medio de pago ya se encuentra registrado", '?controller=MedioPagoController&action=crear');
                    /*Comprobar si el medio de pago existe y no esta activo*/ 
                    }elseif($unico -> activo == FALSE){
                        /*Llamar funcion para recuperar el medio de pago eliminado*/
                        $recuperado = $this -> recuperarMedioPago($nombre);
                        /*Comprobar si el medio de pago ha sido recuperado*/
                        if($recuperado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarmediopagoacierto', "El medio de pago ha sido recuperado", '?controller=AdministradorController&action=gestionarMedioPago');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "El medio de pago no ha sido recuperado con exito", '?controller=MedioPagoController&action=crear');
                        }
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                    }
                /*De lo contrario*/
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "Ha ocurrido un error al guardar el medio de pago", '?controller=MedioPagoController&action=crear');
                }
            /*De lo contrario*/
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "Ha ocurrido un error al guardar el medio de pago", '?controller=MedioPagoController&action=crear');
            }
        }

        /*
        Funcion para buscar un medio de pago
        */

        public function buscarMedioPago($nombre){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setNombre($nombre);
            /*Obtener medios de pago de la base de datos*/
            $listadoEstados = $medioPago -> buscar();
            /*Retornar el resultado*/
            return $listadoEstados;
        }

        /*
        Funcion para buscar un medio de pago en concreto
        */

        public function buscar(){
            /*Comprobar si el dato está llegando*/
            if(isset($_POST)){
                /*Comprobar si el dato existe*/
                $nombre = isset($_POST['mediopagob']) ? $_POST['mediopagob'] : false;
                /*Si el dato existe*/
                if($nombre){
                    /*Llamar la funcion que busca un medio de pago*/
                    $listadoMediosPago = $this -> buscarMedioPago($nombre);
                    /*Comprobar si hay medios de pago encontrados*/
                    if(mysqli_num_rows($listadoMediosPago) > 0){
                        /*Incluir la vista*/
                        require_once 'Vistas/MedioPago/Buscar.html';
                    /*De lo contrario*/    
                    }else{
                        /*Incluir la vista*/
                        require_once 'Vistas/MedioPago/NoEncontrado.html';
                    }
                /*De lo contrario*/       
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=AdministradorController&action=gestionarMedioPago");
                }
            /*De lo contrario*/       
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=AdministradorController&action=gestionarMedioPago");
            }
        }

        /*
        Funcion para eliminar un medio de pago en la base de datos
        */

        public function eliminarMedioPago($idMedioPago){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setId($idMedioPago);
            $medioPago -> setActivo(FALSE);
            /*Ejecutar la consulta*/
            $eliminado = $medioPago -> eliminar();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar un medio de pago
        */

        public function eliminar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idMedioPago){
                    /*Llamar la funcion que elimina el medio de pago*/
                    $eliminado = $this -> eliminarMedioPago($idMedioPago);
                    /*Comprobar si el medio de pago ha sido eliminado con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarmediopagoacierto', "El medio de pago ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                    /*De lo contrario*/
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarmediopagoerror', "El medio de pago no ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                    }
                /*De lo contrario*/
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('eliminarmediopagoerror', "Ha ocurrido un error al eliminar el medio de pago", '?controller=AdministradorController&action=gestionarMedioPago'); 
                } 
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para editar un medio de pago en la base de datos
        */

        public function editarMedioPago($id){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $idMedioPago = $medioPago -> setId($id);
            /*Retornar el resultado*/
            return $idMedioPago;
        }

        /*
        Funcion para editar un medio de pago
        */

        public function editar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idMedioPago){
                    /*Llamar la funcion de editar medio de pago*/
                    $medioPago = $this -> editarMedioPago($idMedioPago);
                    /*Comprobar si el medio de pago ha sido editado*/
                    if($medioPago){
                        /*Llamar la funcion para obtener un medio de pago en concreto*/
                        $medioPagoUnico = $medioPago -> obtenerUno();
                        /*Comprobar si el medio de pago ha sido obtenido*/
                        if($medioPago){
                            /*Incluir la vista*/
                            require_once "Vistas/MedioPago/Actualizar.html";
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
        Funcion para actualizar un medio de pago en la base de datos
        */

        public function actualizarMedioPago($idMedioPago, $nombre){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setId($idMedioPago);
            $medioPago -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $actualizado = $medioPago -> actualizar();
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para actualizar un medio de pago
        */

        public function actualizar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombretaract']) ? $_POST['nombretaract'] : false;
                /*Si los datos existen*/           
                if($idMedioPago){
                    /*Llamar funcion que comprueba si el medio de pago ya ha sido registrado*/
                    $unico = $this -> comprobarUnicoMedioPago($idMedioPago, $nombre);
                    /*Comprobar si el nombre del medio de pago no existe*/
                    if($unico == null){
                        /*Llamar la funcion de actualizar el medio de pago*/
                        $actualizado = $this -> actualizarMedioPago($idMedioPago, $nombre);
                        /*Comprobar si el medio de pago ha sido actualizado*/
                        if($actualizado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('actualizarmediopagoacierto', "el medio de pago ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('actualizarmediopagosugerencia', "Introduce nuevos datos", '?controller=MedioPagoController&action=editar&id='.$idMedioPago);
                        } 
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarmediopagoerror', "Este nombre ya se encuentra asociado a un medio de pago", '?controller=MedioPagoController&action=editar&id='.$idMedioPago);
                    } 
                /*De lo contrario*/
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarmediopagoerror', "Ha ocurrido un error al actualizar el medio de pago", '?controller=MedioPagoController&action=editar&id='.$idMedioPago);
                }  
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para recuperar un medio de pago en la base de datos
        */

        public function restaurarMedioPago($idMedioPago){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Crear el objeto*/
            $medioPago -> setId($idMedioPago);
            $medioPago -> setActivo(TRUE);
            /*Ejecutar la consulta*/
            $eliminado = $medioPago -> recuperarMedioPago();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar un medio de pago
        */

        public function restaurar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idMedioPago){
                    /*Llamar la funcion que elimina el medio de pago*/
                    $eliminado = $this -> restaurarMedioPago($idMedioPago);
                    /*Comprobar si el medio de pago ha sido eliminado con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('restaurarmediopagoacierto', "El medio de pago ha sido restaurado exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                    /*De lo contrario*/   
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('restaurarmediopagoerror', "El medio de pago no ha sido restaurado exitosamente", '?controller=MedioPagoController&action=verMediosPagoEliminados');
                    }
                /*De lo contrario*/   
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('restaurarmediopagoerror', "Ha ocurrido un error al restaurar el medio de pago", '?controller=MedioPagoController&action=verMediosPagoEliminados');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

    }

?>