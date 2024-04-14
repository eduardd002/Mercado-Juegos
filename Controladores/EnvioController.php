<?php

    //Incluir el objeto de envio
    require_once 'Modelos/Envio.php';

    class EnvioController{

        /*
        Funcion para crear un envio
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Envio/Crear.html";
        }

        /*
        Funcion para guardar un envio en la base de datos
        */

        public function guardarEnvio($departamento, $municipio, $codigoPostal, $barrio, $direccion){

            //Instanciar el objeto
            $envio = new Envio();
            //Crear el objeto
            $envio -> setActivo(1);
            $envio -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $envio -> setDepartamento($departamento);
            $envio -> setMunicipio($municipio);
            $envio -> setCodigoPostal($codigoPostal);
            $envio -> setBarrio($barrio);
            $envio -> setDireccion($direccion);
            try{
                //Ejecutar la consulta
                $guardado = $envio -> guardar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarenvioerror', "Este envio ya existe", '?controller=EnvioController&action=crear');
                die();
            }
            return $guardado;
        }

                /*
        Funcion para guardar un envio
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;
                $codigoPostal = isset($_POST['codigoPostal']) ? $_POST['codigoPostal'] : false;
                $barrio = isset($_POST['barrio']) ? $_POST['barrio'] : false;
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;

                //Comprobar si todos los datos exsiten
                if($departamento && $municipio && $codigoPostal && $barrio && $direccion){
                    
                    //Obtener el resultado
                    $guardado = $this -> guardarEnvio($departamento, $municipio, $codigoPostal, $barrio, $direccion);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarenvioacierto', "El envio ha sido creado con exito", '?controller=UsuarioController&action=envios');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarenvioerror', "El envio no ha sido creado con exito", '?controller=EnvioController&action=crear');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardarenvioerror', "Ha ocurrido un error al guardar el envio", '?controller=EnvioController&action=crear');
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarenvioerror', "Ha ocurrido un error al guardar el envio", '?controller=EnvioController&action=crear');
            }
        }

        /*
        Funcion para eliminar un envio en la base de datos
        */

        public function eliminarEnvio($idEnvio){

            //Instanciar el objeto
            $envio = new Envio();
            //Crear objeto
            $envio -> setId($idEnvio);
            //Ejecutar la consulta
            $eliminado = $envio -> eliminar();
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
                $idEnvio = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idEnvio){

                    //Obtener el resultado
                    $eliminado = $this -> eliminarEnvio($idEnvio);

                    //Comprobar si el envio ha sido eliminado con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarenvioacierto', "El envio ha sido eliminado exitosamente", '?controller=UsuarioController&action=envios');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarenvioerror', "El envio no ha sido eliminado exitosamente", '');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminarenvioerror', "Ha ocurrido un error al eliminar el envio", '');
                }
            }
        }

        /*
        Funcion para editar un envio en la base de datos
        */

        public function editarEnvio($idEnvio){

            //Instanciar el objeto
            $envio = new Envio();
            //Creo el objeto y retornar el resultado
            return $envio -> setId($idEnvio);
        }

        /*
        Funcion para editar un envio
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idEnvio = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idEnvio){

                    //Obtener el resultado
                    $envio = $this -> editarEnvio($idEnvio);

                    //Obtener envio
                    $envioUnico = $envio -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Envio/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar un envio en la base de datos
        */

        public function actualizarEnvio($idEnvio, $departamento, $municipio, $codigoPostal, $barrio, $direccion){

            //Instanciar el objeto
            $envio = new Envio();
            //Crear objeto
            $envio -> setId($idEnvio);
            $envio -> setDepartamento($departamento);
            $envio -> setMunicipio($municipio);
            $envio -> setCodigoPostal($codigoPostal);
            $envio -> setBarrio($barrio);
            $envio -> setDireccion($direccion);
            try{
                //Ejecutar la consulta
                $actualizado = $envio -> actualizar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('actualizarenvioerror', "Este envio ya existe", '?controller=EnvioController&action=editar&id='.$idEnvio);
                die();
            }
            return $actualizado;
        }

        /*
        Funcion para actualizar un envio
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $idEnvio = isset($_GET['id']) ? $_GET['id'] : false;
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;
                $codigoPostal = isset($_POST['codigoPostal']) ? $_POST['codigoPostal'] : false;
                $barrio = isset($_POST['barrio']) ? $_POST['barrio'] : false;
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;

                //Si el dato existe
                if($idEnvio && $departamento && $municipio && $codigoPostal && $barrio && $direccion){

                    //Obtener el resultado
                    $actualizado = $this -> actualizarEnvio($idEnvio, $departamento, $municipio, $codigoPostal, $barrio, $direccion);

                    //Comprobar si el envio ha sido actualizado
                    if($actualizado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarenvioacierto', "El envio ha sido actualizado exitosamente", '?controller=UsuarioController&action=envios');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarenviosugerencia', "Introduce nuevos datos", '?controller=EnvioController&action=editar&id='.$idEnvio);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizarenvioerror', "Ha ocurrido un error al actualizar el envio", '?controller=EnvioController&action=editar&id='.$idEnvio);
                }  
            }
        }
    }
?>