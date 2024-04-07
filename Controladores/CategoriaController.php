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

        public function guardarCategoria($nombre){

            //Instanciar el objeto
            $categoria = new Categoria();
            //Crear el objeto
            $categoria -> setActivo(1);
            $categoria -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $guardado = $categoria -> guardar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Este nombre de categoria ya existe", '?controller=CategoriaController&action=crear');
                die();
            }
            return $guardado;
        }

        /*
        Funcion para guardar una categoria
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombrecat']) ? $_POST['nombrecat'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    
                    //Obtener el resultado
                    $guardado = $this -> guardarCategoria($nombre);
                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarcategoriaacierto', "La categoria ha sido creada con exito", '?controller=AdministradorController&action=gestionarCategoria');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "La categoria no ha sido creada con exito", '?controller=CategoriaController&action=crear');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Ha ocurrido un error al guardar la categoria", '?controller=CategoriaController&action=crear');
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Ha ocurrido un error al guardar la categoria", '?controller=CategoriaController&action=crear');
            }
        }

        /*
        Funcion para eliminar una categoria en la base de datos
        */

        public function eliminarCategoria($idCategoria){

            //Instanciar el objeto
            $categoria = new Categoria();
            //Crear objeto
            $categoria -> setId($idCategoria);
            //Ejecutar la consulta
            $eliminado = $categoria -> eliminar();
            //Retornar resultado
            return $eliminado;
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

                    //Obtener el resultado
                    $eliminado = $this -> eliminarCategoria($idCategoria);

                    //Comprobar si la categoria ha sido eliminada con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarcategoriaacierto', "La categoria ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarCategoria');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminarcategoriaerror', "La categoria no ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarCategoria');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminarcategoriaerror', "Ha ocurrido un error al eliminar la categoria", '?controller=AdministradorController&action=gestionarCategoria');
                }
            }
        }

        /*
        Funcion para editar una categoria en la base de datos
        */

        public function editarCategoria($idCategoria){

            //Instanciar el objeto
            $categoria = new Categoria();
            //Creo el objeto y retornar el resultado
            return $categoria -> setId($idCategoria);
        }

        /*
        Funcion para editar una categoria
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idCategoria = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idCategoria){

                    //Obtener el resultado
                    $categoria = $this -> editarCategoria($idCategoria);

                    //Obtener categoria
                    $categoriaUnica = $categoria -> obtenerUna();

                    //Incluir la vista
                    require_once "Vistas/Categoria/Actualizar.html";

                }
            }
        }

        /*
        Funcion para actualizar una categoria en la base de datos
        */

        public function actualizarCategoria($idCategoria, $nombre){

            //Instanciar el objeto
            $categoria = new Categoria();
            //Crear objeto
            $categoria -> setId($idCategoria);
            $categoria -> setNombre($nombre);
            try{
                //Ejecutar la consulta
                $actualizado = $categoria -> actualizar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('actualizarcategoriaerror', "Este nombre de categoria ya existe", '?controller=CategoriaController&action=editar&id='.$idCategoria);
                die();
            }
            return $actualizado;
        }

        /*
        Funcion para actualizar una categoria
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $idCategoria = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombrecatact']) ? $_POST['nombrecatact'] : false;

                //Si el dato existe
                if($idCategoria){

                    //Obtener el resultado
                    $actualizado = $this -> actualizarCategoria($idCategoria, $nombre);

                    //Comprobar si la categoria ha sido actualizada
                    if($actualizado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarcategoriaacierto', "La categoria ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarCategoria');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarcategoriasugerencia', "Introduce nuevos datos", '?controller=CategoriaController&action=editar&id='.$idCategoria);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizarcategoriaerror', "Ha ocurrido un error al actualizar la cateogoria", '?controller=CategoriaController&action=editar&id='.$idCategoria);
                }  
            }
        }
    }
?>