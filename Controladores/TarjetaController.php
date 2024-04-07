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

        public function guardarTarjeta($nombre){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Crear el objeto
            $tarjeta -> setActivo(1);
            $tarjeta -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $guardado = $tarjeta -> guardar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardartarjetaerror', "Este nombre de tarjeta ya existe", '?controller=TarjetaController&action=crear');
                die();
            }
            return $guardado;
        }

        /*
        Funcion para guardar una tarjeta
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombretar']) ? $_POST['nombretar'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    
                    //Obtener el resultado
                    $guardado = $this -> guardarTarjeta($nombre);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardartarjetaacierto', "La tarjeta ha sido creada con exito", '?controller=AdministradorController&action=gestionarTarjeta');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardartarjetaerror', "La tarjeta no ha sido creada con exito", '?controller=CategoriaController&action=crear');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardartarjetaerror', "Ha ocurrido un error al guardar la tarjeta", '?controller=CategoriaController&action=crear');
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardartarjetaerror', "Ha ocurrido un error al guardar la tarjeta", '?controller=CategoriaController&action=crear');
            }
        }

        /*
        Funcion para eliminar una tarjeta en la base de datos
        */

        public function eliminarTarjeta($idTarjeta){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Crear objeto
            $tarjeta -> setId($idTarjeta);
            //Ejecutar la consulta
            $eliminado = $tarjeta -> eliminar();
            //Retornar resultado
            return $eliminado;
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

                    //Obtener el resultado
                    $eliminado = $this -> eliminarTarjeta($idTarjeta);

                    //Comprobar si la tarjeta ha sido eliminada con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminartarjetaacierto', "La tarjeta ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarTarjeta');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminartarjetaerror', "La tarjeta no ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarTarjeta');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminartarjetaerror', "Ha ocurrido un error al eliminar la tarjeta", '?controller=AdministradorController&action=gestionarTarjeta'); 
                } 
            }
        }

        /*
        Funcion para editar una tarjeta en la base de datos
        */

        public function editarTarjeta($idTarjeta){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Creo el objeto y retornar el resultado
            return $tarjeta -> setId($idTarjeta);
        }

        /*
        Funcion para editar una tarjeta
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idTarjeta = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idTarjeta){

                    //Obtener el resultado
                    $tarjeta = $this -> editarTarjeta($idTarjeta);

                    //Obtener tarjeta
                    $tarjetaUnica = $tarjeta -> obtenerUna();

                    //Incluir la vista
                    require_once "Vistas/Tarjeta/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar una tarjeta en la base de datos
        */

        public function actualizarTarjeta($idTarjeta, $nombre){

            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Crear objeto
            $tarjeta -> setId($idTarjeta);
            $tarjeta -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $actualizado = $tarjeta -> actualizar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('actualizartarjetaerror', "Este nombre de tarjeta ya existe", '?controller=TarjetaController&action=editar&id='.$idTarjeta);
                die();
            }
            return $actualizado;
        }

        /*
        Funcion para actualizar una tarjeta
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $idTarjeta = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombretaract']) ? $_POST['nombretaract'] : false;

                //Si el dato existe
                if($idTarjeta){

                    //Obtener el resultado
                    $actualizado = $this -> actualizarTarjeta($idTarjeta, $nombre);

                    //Comprobar si la tarjeta ha sido actualizada
                    if($actualizado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizartarjetaacierto', "La tarjeta ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarTarjeta');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizartarjetasugerencia', "Introduce nuevos datos", '?controller=TarjetaController&action=editar&id='.$idTarjeta);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizartarjetaerror', "Ha ocurrido un error al actualizar la tarjeta", '?controller=TarjetaController&action=editar&id='.$idTarjeta);
                }  
            }
        }
    }

?>