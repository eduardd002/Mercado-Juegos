<?php

    /*Incluir el objeto de uso*/
    require_once 'Modelos/Uso.php';

    /*
    Clase controlador de uso
    */

    class UsoController{

        /*
        Funcion para crear un uso
        */

        public function crear(){
            /*Incluir la vista*/
            require_once "Vistas/Uso/Crear.html";
        }

        /*
        Funcion para guardar un uso en la base de datos
        */

        public function guardarUso($nombre){
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Crear el objeto*/
            $uso -> setactivo(TRUE);
            $uso -> setNombre($nombre);
            /*Intentar guardar el uso en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $guardado = $uso -> guardar();
            /*Capturar la excepcion*/                    
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarusoerror', "Este nombre de uso ya existe", '?controller=UsoController&action=crear');
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para comprobar si el uso ya ha sido creado previamente
        */

        public function comprobarUnicoUso($nombre){
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Crear el objeto*/
            $uso -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $uso -> comprobarUsoUnico();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para recuperar el uso eliminado
        */

        public function recuperarUso($nombre){
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Crear el objeto*/
            $uso -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $uso -> recuperarUso();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para guardar un uso
        */

        public function guardar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_POST)){
                /*Comprobar si el dato existe*/
                $nombre = isset($_POST['nombreuso']) ? $_POST['nombreuso'] : false;
                /*Si el dato existe*/
                if($nombre){
                    /*Llamar funcion que comprueba si el uso ya ha sido registrado*/
                    $unico = $this -> comprobarUnicoUso($nombre);
                    /*Comprobar si el nombre del uso no existe*/
                    if($unico == null){
                        /*Llamar la funcion de guardar uso*/
                        $guardado = $this -> guardarUso($nombre);
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        if($guardado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarusoacierto', "El uso ha sido creado con exito", '?controller=AdministradorController&action=gestionarUso');
                        /*De lo contrario*/    
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarusoerror', "El uso no ha sido creado con exito", '?controller=UsoController&action=crear');
                        }
                    /*Comprobar si el uso existe y esta activo*/    
                    }elseif($unico -> activo == 1){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarusoerror', "Este uso ya se encuentra registrado", '?controller=UsoController&action=crear');
                    /*Comprobar si el uso existe y no esta activo*/ 
                    }elseif($unico -> activo == 0){
                        /*Llamar funcion para recuperar el uso eliminado*/
                        $recuperado = $this -> recuperarUso($nombre);
                        /*Comprobar si el uso ha sido recuperado*/
                        if($recuperado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarusoacierto', "El uso ha sido recuperado", '?controller=AdministradorController&action=gestionarUso');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarusoerror', "El uso no ha sido recuperado con exito", '?controller=UsoController&action=crear');
                        }
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                    }
                /*De lo contrario*/    
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarusoerror', "Ha ocurrido un error al guardar el uso", '?controller=UsoController&action=crear');
                }
            /*De lo contrario*/      
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarusoerror', "Ha ocurrido un error al guardar el uso", '?controller=UsoController&action=crear');
            }
        }

        /*
        Funcion para eliminar un uso en la base de datos
        */

        public function eliminarUso($idUso){
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Crear el objeto*/
            $uso -> setId($idUso);
            /*Ejecutar la consulta*/
            $eliminado = $uso -> eliminar();
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
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idUso){
                    /*Llamar la funcion que elimina el uso*/
                    $eliminado = $this -> eliminarUso($idUso);
                    /*Comprobar si el uso ha sido eliminado con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarusoacierto', "El uso ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarUso');
                    /*De lo contrario*/
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarusoerror', "El uso no ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarUso');
                    }
                /*De lo contrario*/    
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('eliminarusoerror', "Ha ocurrido un error al eliminar el uso", '?controller=AdministradorController&action=gestionarUso');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para editar un uso en la base de datos
        */

        public function editarUso($id){
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Crear el objeto*/
            $idUso = $uso -> setId($id);
            /*Retornar el resultado*/
            return $idUso;
        }

        /*
        Funcion para editar un uso
        */

        public function editar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idUso){
                    /*Llamar la funcion de editar uso*/
                    $uso = $this -> editarUso($idUso);
                    /*Comprobar si el uso ha sido editado*/
                    if($uso){
                        /*Llamar la funcion para obtener un uso en concreto*/
                        $usoUnico = $uso -> obtenerUno();
                        /*Comprobar si el uso ha sido obtenido*/
                        if($usoUnico){
                            /*Incluir la vista*/
                            require_once "Vistas/Uso/Actualizar.html";
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
        Funcion para actualizar un uso en la base de datos
        */

        public function actualizarUso($idUso, $nombre){
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Crear el objeto*/
            $uso -> setId($idUso);
            $uso -> setNombre($nombre);
            /*Intentar actualizar el uso*/
            try{
                /*Ejecutar la consulta*/
                $actualizado = $uso -> actualizar();
            /*Capturar la excepcion*/  
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('actualizarusoerror', "Este nombre de uso ya existe", '?controller=UsoController&action=editar&id='.$idUso);
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para actualizar un uso
        */

        public function actualizar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombreusoact']) ? $_POST['nombreusoact'] : false;
                /*Si los datos existen*/
                if($idUso){
                    /*Llamar la funcion de actualizar uso*/
                    $actualizado = $this -> actualizarUso($idUso, $nombre);
                    /*Comprobar si la uso ha sido actualizada*/
                    if($actualizado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarusoacierto', "El uso ha sido actualizado exitosamente", '?controller=AdministradorController&action=gestionarUso');
                    /*De lo contrario*/ 
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarusosugerencia', "Introduce nuevos datos", '?controller=UsoController&action=editar&id='.$idUso);
                    }
                /*De lo contrario*/ 
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarusoerror', "Ha ocurrido un error al actualizar el uso", '?controller=UsoController&action=editar&id='.$idUso);
                }  
                /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

    }

?>