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

        public function guardarConsola($nombre){

            //Instanciar el objeto
            $consola = new Consola();
            //Crear el objeto
            $consola -> setActivo(1);
            $consola -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $guardado = $consola -> guardar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Este nombre de consola ya existe", '?controller=ConsolaController&action=crear');
                die();
            }
            return $guardado;
        }

        /*
        Funcion para guardar una consola
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombrecon']) ? $_POST['nombrecon'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    
                    //Obtener el resultado
                    $guardado = $this -> guardarConsola($nombre);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarconsolaacierto', "La consola ha sido creada con exito", '?controller=AdministradorController&action=gestionarConsola');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarconsolaerror', "La consola no ha sido creada con exito", '?controller=AdministradorController&action=crearConsola');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Ha ocurrido un error al guardar la consola", '?controller=ConsolaController&action=crear');
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Ha ocurrido un error al guardar la consola", '?controller=ConsolaController&action=crear');
            }
        }

        /*
        Funcion para eliminar una consola en la base de datos
        */

        public function eliminarConsola($idConsola){

            //Instanciar el objeto
            $consola = new Consola();
            //Crear objeto
            $consola -> setId($idConsola);
            //Ejecutar la consulta
            $eliminado = $consola -> eliminar();
            //Retornar resultado
            return $eliminado;
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

                    //Obtener el resultado
                    $eliminado = $this -> eliminarConsola($idConsola);

                    //Comprobar si la consola ha sido eliminada con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarconsolaacierto', "La consola ha sido eliminada exitosamente", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarconsolaerror', "La consola no ha sido creado con exito", '?controller=ConsolaController&action=crear');
                    }
                }
            }
        }

        /*
        Funcion para editar una consola en la base de datos
        */

        public function editarConsola($idConsola){

            //Instanciar el objeto
            $consola = new Consola();
            //Creo el objeto y retornar el resultado
            return $consola -> setId($idConsola);
        }

        /*
        Funcion para editar una consola
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idConsola = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idConsola){

                    //Obtener el resultado
                    $consola = $this -> editarConsola($idConsola);

                    //Obtener consola
                    $consolaUnica = $consola -> obtenerUna();

                    //Incluir la vista
                    require_once "Vistas/Consola/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar una consola en la base de datos
        */

        public function actualizarConsola($idConsola, $nombre){

            //Instanciar el objeto
            $consola = new Consola();
            //Crear objeto
            $consola -> setId($idConsola);
            $consola -> setNombre($nombre);
            //Ejecutar la consulta
            $actualizado = $consola -> actualizar();
            //Retornar el resultado
            return $actualizado;
        }

        /*
        Funcion para actualizar una consola
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $idConsola = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombreconsact']) ? $_POST['nombreconsact'] : false;

                //Si el dato existe
                if($idConsola){

                    //Obtener el resultado
                    $actualizado = $this -> actualizarConsola($idConsola, $nombre);

                    //Comprobar si la consola ha sido actualizada
                    if($actualizado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarconsolaacierto', "La consola ha sido actualizada exitosamente", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarconsolaerror', "La consola no ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarConsola');
                    }
                }  
            }
        }
    }

?>