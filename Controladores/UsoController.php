<?php

    //Incluir el objeto de uso
    require_once 'Modelos/Uso.php';

    class UsoController{

        /*
        Funcion para crear un uso
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Uso/Crear.html";
        }

        /*
        Funcion para guardar un uso en la base de datos
        */

        public function guardarUso($nombre){

            //Instanciar el objeto
            $uso = new Uso();
            //Crear el objeto
            $uso -> setNombre($nombre);
            //Guardar en la base de datos
            $guardado = $uso -> guardar();
            //Retornar resultado
            return $guardado;
        }

                /*
        Funcion para guardar un uso
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreuso']) ? $_POST['nombreuso'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    
                    //Obtener el resultado
                    $guardado = $this -> guardarUso($nombre);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarusoacierto', "El uso ha sido creado con exito", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarusoerror', "El uso no ha sido creado con exito", '?controller=AdministradorController&action=crearUso');
                    }
                }
            }
        }

        /*
        Funcion para eliminar un uso en la base de datos
        */

        public function eliminarUso($idUso){

            //Instanciar el objeto
            $uso = new Uso();
            //Crear objeto
            $uso -> setId($idUso);
            //Ejecutar la consulta
            $eliminado = $uso -> eliminar();
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
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idUso){

                    //Obtener el resultado
                    $eliminado = $this -> eliminarUso($idUso);

                    //Comprobar si el uso ha sido eliminado con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarusoacierto', "El uso ha sido eliminado exitosamente", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarusoerror', "El uso no ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarUso');
                    }
                }  
            }
        }

        /*
        Funcion para editar un uso en la base de datos
        */

        public function editarUso($idUso){

            //Instanciar el objeto
            $uso = new Uso();
            //Creo el objeto y retornar el resultado
            return $uso -> setId($idUso);
        }

        /*
        Funcion para editar un uso
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idUso){

                    //Obtener el resultado
                    $uso = $this -> editarUso($idUso);

                    //Obtener uso
                    $usoUnico = $uso -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Uso/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar un uso en la base de datos
        */

        public function actualizarUso($idUso, $nombre){

            //Instanciar el objeto
            $uso = new Uso();
            //Crear objeto
            $uso -> setId($idUso);
            $uso -> setNombre($nombre);
            //Ejecutar la consulta
            $actualizado = $uso -> actualizar();
            //Retornar el resultado
            return $actualizado;
        }

        /*
        Funcion para actualizar un uso
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombreusoact']) ? $_POST['nombreusoact'] : false;

                //Si el dato existe
                if($idUso){

                    //Obtener el resultado
                    $actualizado = $this -> actualizarUso($idUso, $nombre);

                    //Comprobar si el uso ha sido actualizado
                    if($actualizado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarusoacierto', "El uso ha sido actualizado exitosamente", '?controller=AdministradorController&action=administrar');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarusoerror', "El uso no ha sido actualizado exitosamente", '?controller=AdministradorController&action=gestionarUso');
                    }
                }  
            }
        }
    }
?>