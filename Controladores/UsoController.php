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

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreuso']) ? $_POST['nombreuso'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $uso = new Uso();

                    //Crear el objeto
                    $uso -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $uso -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de uso creado
                        $_SESSION['usocreado'] = 'El uso ha sido creado con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar el uso
                        $_SESSION['usonocreado'] = 'El uso no ha sido creado con exito';
                        //Redirigir al registro de uso
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearUso");
                    }
                }
            }
        }

        /*
        Funcion para eliminar un uso
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idUso = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idUso){

                    //Instanciar el objeto
                    $uso = new Uso();

                    //Crear objeto
                    $uso -> setId($idUso);

                    //Ejecutar la consulta
                    $eliminado = $uso -> eliminar();

                    if($eliminado){
                        //Crear Sesion que indique que el uso se ha eliminado con exito
                        $_SESSION['usoeliminado'] = "El uso ha sido eliminado exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que el uso se ha eliminado con exito
                        $_SESSION['usoeliminado'] = "El uso no ha sido eliminado exitosamente";
                        //Redirigir a la gestión de uso
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarUso");
                    }
                }  
            }
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

                    //Instanciar el objeto
                    $uso = new Uso();

                    //Creo el objeto
                    $uso -> setId($idUso);

                    //Obtener uso
                    $usoUnico = $uso -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Uso/Actualizar.html";

                }
            }
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

                    //Instanciar el objeto
                    $uso = new Uso();

                    //Crear objeto
                    $uso -> setId($idUso);
                    $uso -> setNombre($nombre);

                    //Ejecutar la consulta
                    $actualizado = $uso -> actualizar();

                    if($actualizado){
                        //Crear Sesion que indique que el uso se ha actualizado con exito
                        $_SESSION['usoactualizado'] = "El uso ha sido actualizado exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que el uso  se ha actualizado con exito
                        $_SESSION['usoactualizado'] = "El uso no ha sido actualizada exitosamente";
                        //Redirigir a la gestion de usos
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarUso");
                    }
                }  
            }
        }
    }
?>