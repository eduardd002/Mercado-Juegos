<?php

    /*Incluir el objeto de consola*/
    require_once 'Modelos/Consola.php';

    /*
    Clase controlador de consola
    */

    class ConsolaController{

        /*
        Funcion para crear una consola
        */

        public function crear(){
            /*Incluir la vista*/
            require_once "Vistas/Consola/Crear.html";
        }

        /*
        Funcion para guardar una consola en la base de datos
        */

        public function guardarConsola($nombre){
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Crear el objeto*/
            $consola -> setactivo(TRUE);
            $consola -> setNombre($nombre);
            /*Intentar guardar la consola en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $guardado = $consola -> guardar();
            /*Capturar la excepcion*/  
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Este nombre de consola ya existe", '?controller=ConsolaController&action=crear');
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para comprobar si la consola ya ha sido creada previamente
        */

        public function comprobarUnicaConsola($nombre){
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Crear el objeto*/
            $consola -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $consola -> comprobarConsolaUnica();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para recuperar la consola eliminada
        */

        public function recuperarConsola($nombre){
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Crear el objeto*/
            $consola -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $consola -> recuperarConsola();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para guardar una consola
        */

        public function guardar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_POST)){
                /*Comprobar si el dato existe*/
                $nombre = isset($_POST['nombrecon']) ? $_POST['nombrecon'] : false;
                /*Si el dato existe*/
                if($nombre){
                    /*Llamar funcion que comprueba si la consola ya ha sido registrada*/
                    $unico = $this -> comprobarUnicaConsola($nombre);
                    /*Comprobar si el nombre de la consola no existe*/
                    if($unico == null){
                        /*Llamar la funcion de guardar consola*/
                        $guardado = $this -> guardarConsola($nombre);
                        /*Comprobar se ejecutó con exito la consulta*/
                        if($guardado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarconsolaacierto', "La consola ha sido creada con exito", '?controller=AdministradorController&action=gestionarConsola');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarconsolaerror', "La consola no ha sido creada con exito", '?controller=AdministradorController&action=crearConsola');
                        } 
                    /*Comprobar si la consola existe y esta activa*/    
                    }elseif($unico -> activo == TRUE){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Esta consola ya se encuentra registrada", '?controller=ConsolaController&action=crear');
                    /*Comprobar si la consola existe y no esta activa*/ 
                    }elseif($unico -> activo == FALSE){
                        /*Llamar funcion para recuperar la consola eliminada*/
                        $recuperada = $this -> recuperarConsola($nombre);
                        /*Comprobar si la consola ha sido recuperada*/
                        if($recuperada){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarconsolaacierto', "La consola ha sido recuperada", '?controller=AdministradorController&action=gestionarConsola');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarconsolaerror', "La consola no ha sido recuperada con exito", '?controller=ConsolaController&action=crear');
                        }
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                    }
                /*De lo contrario*/
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Ha ocurrido un error al guardar la consola", '?controller=ConsolaController&action=crear');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Ha ocurrido un error al guardar la consola", '?controller=ConsolaController&action=crear');
            }
        }

        /*
        Funcion para eliminar una consola en la base de datos
        */

        public function eliminarConsola($idConsola){
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Crear el objeto*/
            $consola -> setId($idConsola);
            $consola -> setActivo(FALSE);
            /*Ejecutar la consulta*/
            $eliminado = $consola -> eliminar();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar una consola
        */

        public function eliminar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idConsola = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idConsola){
                    /*Llamar la funcion que elimina la consola*/
                    $eliminado = $this -> eliminarConsola($idConsola);
                    /*Comprobar si la consola ha sido eliminada con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarconsolaacierto', "La consola ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarConsola');
                    /*De lo contrario*/
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarconsolaerror', "La consola no ha sido creado con exito", '?controller=ConsolaController&action=gestionarConsola');
                    }
                /*De lo contrario*/    
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarconsolaerror', "Ha ocurrido un error al eliminar la consola", '?controller=ConsolaController&action=gestionarConsola');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para editar una consola en la base de datos
        */

        public function editarConsola($id){
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Crear el objeto*/
            $idConsola = $consola -> setId($id);
            /*Retornar el resultado*/
            return $idConsola;
        }

        /*
        Funcion para editar una consola
        */

        public function editar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idConsola = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idConsola){
                    /*Llamar la funcion de editar consola*/
                    $consola = $this -> editarConsola($idConsola);
                    /*Comprobar si la consola ha sido editada*/
                    if($consola){
                        /*Comprobar si la consola ha sido editada*/
                        $consolaUnica = $consola -> obtenerUna();
                        /*Comprobar si la consola ha sido obtenida*/
                        if($consolaUnica){
                            /*Incluir la vista*/
                            require_once "Vistas/Consola/Actualizar.html";
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
        Funcion para actualizar una consola en la base de datos
        */

        public function actualizarConsola($idConsola, $nombre){
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Crear el objeto*/
            $consola -> setId($idConsola);
            $consola -> setNombre($nombre);
            /*Intentar actualizar la consola en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $actualizado = $consola -> actualizar();
            /*Capturar la excepcion*/ 
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('actualizarconsolaerror', "Este nombre de consola ya existe", '?controller=ConsolaController&action=editar&id='.$idConsola);
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para actualizar una consola
        */

        public function actualizar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $idConsola = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombreconsact']) ? $_POST['nombreconsact'] : false;
                /*Si los datos existen*/
                if($idConsola){
                    /*Llamar la funcion de actualizar consola*/
                    $actualizado = $this -> actualizarConsola($idConsola, $nombre);
                    /*Comprobar si la consola ha sido actualizada*/
                    if($actualizado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarconsolaacierto', "La consola ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarConsola');
                    /*De lo contrario*/   
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarconsolasugerencia', "Introduce nuevos datos", '?controller=ConsolaController&action=editar&id='.$idConsola);
                    }
                /*De lo contrario*/       
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarconsolaerror', "Ha ocurrido un error al actualizar la consola", '?controller=ConsolaController&action=editar&id='.$idConsola);
                }  
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }
        
    }

?>