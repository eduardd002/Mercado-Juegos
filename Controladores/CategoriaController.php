<?php

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    class CategoriaController{

        /*
        Funcion para crear una categoria
        */

        public function crear(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearCategorias.html";
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
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la categoria
                        $_SESSION['categorianocreada'] = 'La categoria no ha sido creada con exito';
                        //Redirigir al registro de categoria
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearCategoria");
                    }
                }
            }
        }

    }

?>