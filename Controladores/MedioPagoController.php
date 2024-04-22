<?php

    //Incluir el objeto de medio de pago
    require_once 'Modelos/MedioPago.php';

    class MedioPagoController{

        /*
        Funcion para crear un medio de pago
        */

        public function crear(){
            //Incluir la vista
            require_once "Vistas/MedioPago/Crear.html";
        }

        /*
        Funcion para guardar un medio de pago en la base de datos
        */

        public function guardarMedioPago($nombre){
            //Instanciar el objeto
            $medioPago = new MedioPago();
            //Crear el objeto
            $medioPago -> setActivo(1);
            $medioPago -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $guardado = $medioPago -> guardar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "Este nombre de medio de pago ya existe", '?controller=MedioPagoController&action=crear');
                die();
            }
            return $guardado;
        }

        /*
        Funcion para guardar un medio de pago
        */

        public function guardar(){
            //Comprobar si los datos están llegando
            if(isset($_POST)){
                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombretar']) ? $_POST['nombretar'] : false;
                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Obtener el resultado
                    $guardado = $this -> guardarMedioPago($nombre);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarmediopagoacierto', "El medio de pago ha sido creado con exito", '?controller=AdministradorController&action=gestionarMedioPago');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "El medio de pago no ha sido creado con exito", '?controller=CategoriaController&action=crear');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "Ha ocurrido un error al guardar el medio de pago", '?controller=CategoriaController&action=crear');
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarmediopagoerror', "Ha ocurrido un error al guardar el medio de pago", '?controller=CategoriaController&action=crear');
            }
        }

        /*
        Funcion para eliminar un medio de pago en la base de datos
        */

        public function eliminarMedioPago($idMedioPago){
            //Instanciar el objeto
            $medioPago = new MedioPago();
            //Crear objeto
            $medioPago -> setId($idMedioPago);
            //Ejecutar la consulta
            $eliminado = $medioPago -> eliminar();
            //Retornar resultado
            return $eliminado;
        }

        /*
        Funcion para eliminar un medio de pago
        */

        public function eliminar(){
            //Comprobar si los datos están llegando
            if(isset($_GET)){
                //Comprobar si el dato existe
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                //Si el dato existe
                if($idMedioPago){
                    //Obtener el resultado
                    $eliminado = $this -> eliminarMedioPago($idMedioPago);
                    //Comprobar si el medio de pago ha sido eliminada con exito
                    if($eliminado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarmediopagoacierto', "el medio de pago ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarmediopagoerror', "el medio de pago no ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminarmediopagoerror', "Ha ocurrido un error al eliminar el medio de pago", '?controller=AdministradorController&action=gestionarMedioPago'); 
                } 
            }
        }

        /*
        Funcion para editar un medio de pago en la base de datos
        */

        public function editarMedioPago($idMedioPago){
            //Instanciar el objeto
            $medioPago = new MedioPago();
            //Creo el objeto y retornar el resultado
            return $medioPago -> setId($idMedioPago);
        }

        /*
        Funcion para editar un medio de pago
        */

        public function editar(){
            //Comprobar si los datos están llegando
            if(isset($_GET)){
                //Comprobar si el dato existe
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                //Si el dato existe
                if($idMedioPago){
                    //Obtener el resultado
                    $medioPago = $this -> editarMedioPago($idMedioPago);
                    //Obtener medio de pago
                    $medioPagoUnico = $medioPago -> obtenerUna();
                    //Incluir la vista
                    require_once "Vistas/MedioPago/Actualizar.html";
                }
            }
        }

        /*
        Funcion para actualizar un medio de pago en la base de datos
        */

        public function actualizarMedioPago($idMedioPago, $nombre){
            //Instanciar el objeto
            $medioPago = new MedioPago();
            //Crear objeto
            $medioPago -> setId($idMedioPago);
            $medioPago -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $actualizado = $medioPago -> actualizar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('actualizarmediopagoerror', "Este nombre de medio de pago ya existe", '?controller=MedioPagoController&action=editar&id='.$idMedioPago);
                die();
            }
            return $actualizado;
        }

        /*
        Funcion para actualizar un medio de pago
        */

        public function actualizar(){
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){
                //Comprobar si los datos existe
                $idMedioPago = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombretaract']) ? $_POST['nombretaract'] : false;
                //Si el dato existe
                if($idMedioPago){
                    //Obtener el resultado
                    $actualizado = $this -> actualizarMedioPago($idMedioPago, $nombre);
                    //Comprobar si el medio de pago ha sido actualizada
                    if($actualizado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarmediopagoacierto', "el medio de pago ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarMedioPago');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarmediopagosugerencia', "Introduce nuevos datos", '?controller=MedioPagoController&action=editar&id='.$idMedioPago);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizarmediopagoerror', "Ha ocurrido un error al actualizar el medio de pago", '?controller=MedioPagoController&action=editar&id='.$idMedioPago);
                }  
            }
        }
        
    }

?>