<?php

    /*Incluir el objeto de pago*/
    require_once 'Modelos/Pago.php';
    /*Incluir el objeto de medio de pago*/
    require_once 'Modelos/MedioPago.php';

    /*
    Clase controlador de pago
    */

    class PagoController{

        /*
        Funcion para crear un pago
        */

        public function crear(){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Listar todos los medios de pago desde la base de datos*/
            $listadoMediosPago = $medioPago -> listar();
            /*Incluir la vista*/
            require_once "Vistas/Pago/Crear.html";
        }

        /*
        Funcion para guardar un pago en la base de datos
        */

        public function guardarPago($medioPago, $numero){
            /*Instanciar el objeto*/
            $pago = new Pago();
            /*Crear el objeto*/
            $pago -> setActivo(1);
            $pago -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $pago -> setIdMedioPago($medioPago);
            $pago -> setNumero($numero);
            /*Intentar guardar el pago*/
            try{
                /*Ejecutar la consulta*/
                $guardado = $pago -> guardar();
            /*Capturar la excepcion*/        
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarpagoerror', "Este pago ya existe", '?controller=PagoController&action=crear');
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para guardar un pago
        */

        public function guardar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_POST)){
                /*Comprobar si cada dato existe*/
                $medioPago = isset($_POST['idMedioPago']) ? $_POST['idMedioPago'] : false;
                $numero = isset($_POST['numero']) ? $_POST['numero'] : false;
                /*Si los datos existen*/
                if($medioPago && $numero){
                    /*Llamar la funcion que guarda el pago*/
                    $guardado = $this -> guardarPago($medioPago, $numero);
                    /*Comprobar se ejecutó con exito la consulta*/
                    if($guardado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarpagoacierto', "El pago ha sido creado con exito", '?controller=UsuarioController&action=pagos');
                    /*De lo contrario*/      
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarpagoerror', "El pago no ha sido creado con exito", '?controller=PagoController&action=crear');
                    }
                /*De lo contrario*/  
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarpagoerror', "Ha ocurrido un error al guardar el pago", '?controller=PagoController&action=crear');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarpagoerror', "Ha ocurrido un error al guardar el pago", '?controller=PagoController&action=crear');
            }
        }

        /*
        Funcion para eliminar un pago en la base de datos
        */

        public function eliminarPago($idPago){
            /*Instanciar el objeto*/
            $pago = new Pago();
            /*Crear el objeto*/
            $pago -> setId($idPago);
            /*Ejecutar la consulta*/
            $eliminado = $pago -> eliminar();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar un pago
        */

        public function eliminar(){
            /*Comprobar si el dato está llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idPago = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idPago){
                    /*Llamar la funcion que elimina el pago*/
                    $eliminado = $this -> eliminarPago($idPago);
                    /*Comprobar si el pago ha sido eliminado con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarpagoacierto', "El pago ha sido eliminado exitosamente", '?controller=UsuarioController&action=pagos');
                    /*De lo contrario*/   
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarpagoerror', "El pago no ha sido eliminado exitosamente", '');
                    }
                /*De lo contrario*/       
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('eliminarpagoerror', "Ha ocurrido un error al eliminar el pago", '');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarpagoerror', "Ha ocurrido un error al guardar el pago", '?controller=PagoController&action=crear');
            }
        }

        /*
        Funcion para editar un pago en la base de datos
        */

        public function editarPago($id){
            /*Instanciar el objeto*/
            $pago = new Pago();
            /*Crear el objeto*/
            $idPago = $pago -> setId($id);
            /*Retornar el resultado*/
            return $idPago;
        }

        public function listarMediosPago(){
            /*Instanciar el objeto*/
            $medioPago = new MedioPago();
            /*Listar todas las categorias desde la base de datos*/
            $listadoMediosPago = $medioPago -> listar();
            /*Retornar el resultado*/
            return $listadoMediosPago;
        }

        /*
        Funcion para editar un pago
        */

        public function editar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idPago = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idPago){
                    /*Llamar la funcion que edita el pago*/
                    $pago = $this -> editarPago($idPago);
                    /*Comprobar si el pago ha sido editado*/
                    if($pago){
                        /*Obtener pago*/
                        $pagoUnico = $pago -> obtenerUno();
                        /*Comprobar si se ha obtenido el pago*/
                        if($pagoUnico){
                            /*Llamar funcion para listar los medios de pago*/
                            $listadoMediosPago = $this -> listarMediosPago();
                            /*Incluir la vista*/                       
                            require_once "Vistas/Pago/Actualizar.html";
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
        Funcion para actualizar un pago en la base de datos
        */

        public function actualizarPago($idPago, $medioPago, $numero){
            /*Instanciar el objeto*/
            $pago = new Pago();
            /*Crear objeto*/
            $pago -> setId($idPago);
            $pago -> setIdMedioPago($medioPago);
            $pago -> setNumero($numero);
            /*Intentar actualizar el pago*/
            try{
                /*Ejecutar la consulta*/
                $actualizado = $pago -> actualizar();
            /*Capturar la excepcion*/    
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('actualizarpagoerror', "Este pago ya existe", '?controller=PagoController&action=editar&id='.$idPago);
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para actualizar un pago
        */

        public function actualizar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $idPago = isset($_GET['id']) ? $_GET['id'] : false;
                $medioPago = isset($_POST['medioPago']) ? $_POST['medioPago'] : false;
                $numero = isset($_POST['numeroPago']) ? $_POST['numeroPago'] : false;
                /*Si los datos existen*/
                if($idPago && $medioPago && $numero){
                    /*Llamar la funcion para actualizar el pago*/
                    $actualizado = $this -> actualizarPago($idPago, $medioPago, $numero);
                    /*Comprobar si el pago ha sido actualizado*/
                    if($actualizado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarpagoacierto', "El pago ha sido actualizado exitosamente", '?controller=UsuarioController&action=pagos');
                    /*De lo contrario*/   
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarpagosugerencia', "Introduce nuevos datos", '?controller=PagoController&action=editar&id='.$idPago);
                    }
                /*De lo contrario*/       
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarpagoerror', "Ha ocurrido un error al actualizar el pago", '?controller=PagoController&action=editar&id='.$idPago);
                }  
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

    }

?>