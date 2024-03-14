<?php

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    class CategoriaController{

        /*
        Funcion para crear una categoria
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Categoria/Crear.html";
        }

        /*
        Funcion para guardar una categoria en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombrecat']) ? $_POST['nombrecat'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $categoria = new Categoria();

                    //Crear el objeto
                    $categoria -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $categoria -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de categoria creada
                        $_SESSION['categoriacreada'] = 'La categoria ha sido creada con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la categoria
                        $_SESSION['categoriacreada'] = 'La categoria no ha sido creada con exito';
                        //Redirigir al registro de categoria
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearCategoria");
                    }
                }
            }
        }

        /*
        Funcion para eliminar una categoria
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idCategoria = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idCategoria){

                    //Instanciar el objeto
                    $categoria = new Categoria();

                    //Crear objeto
                    $categoria -> setId($idCategoria);

                    //Ejecutar la consulta
                    $eliminado = $categoria -> eliminar();

                    if($eliminado){
                        //Crear Sesion que indique que el categoria se ha eliminado con exito
                        $_SESSION['categoriaeliminada'] = "La categoria ha sido eliminada exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que la cateogoria se ha eliminado con exito
                        $_SESSION['categoriaeliminada'] = "La categoria no ha sido eliminada exitosamente";
                        //Redirigir a la gestion de categorias
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarCateogoria");
                    }
                }  
            }
        }
    }

?>