<?php

    /*Incluir el objeto de categoria*/
    require_once 'Modelos/Categoria.php';

    /*
    Clase controlador de categoria
    */

    class CategoriaController{

        /*
        Funcion para crear una categoria
        */

        public function crear(){
            /*Incluir la vista*/
            require_once "Vistas/Categoria/Crear.html";
        }

        /*
        Funcion para guardar una categoria en la base de datos
        */

        public function guardarCategoria($nombre){
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Crear el objeto*/
            $categoria -> setActivo(1);
            $categoria -> setNombre($nombre);
            /*Intentar guardar la categoria en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $guardado = $categoria -> guardar();
            /*Capturar la excepcion*/    
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Este nombre de categoria ya existe", '?controller=CategoriaController&action=crear');
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $guardado;
        }

        /*
        Funcion para comprobar si la categoria ya ha sido creada previamente
        */

        public function comprobarUnicaCategoria($nombre){
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Crear el objeto*/
            $categoria -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $categoria -> comprobarCategoriaUnica();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para recuperar la categoria eliminada
        */

        public function recuperarCategoria($nombre){
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Crear el objeto*/
            $categoria -> setNombre($nombre);
            /*Ejecutar la consulta*/
            $resultado = $categoria -> recuperarCategoria();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para guardar una categoria
        */

        public function guardar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_POST)){
                /*Comprobar si el dato existe*/
                $nombre = isset($_POST['nombrecat']) ? $_POST['nombrecat'] : false;
                /*Si el dato existe*/
                if($nombre){
                    /*Llamar funcion que comprueba si la categoria ya ha sido registrada*/
                    $unico = $this -> comprobarUnicaCategoria($nombre);
                    /*Comprobar si el nombre de la categoria no existe*/
                    var_dump($unico);
                    die();  
                    if($unico == null){
                        /*Llamar la funcion de guardar categoria*/
                        $guardado = $this -> guardarCategoria($nombre);
                        /*Comprobar se ejecutó con exito la consulta*/
                        if($guardado){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarcategoriaacierto', "La categoria ha sido creada con exito", '?controller=AdministradorController&action=gestionarCategoria');
                        /*De lo contrario*/    
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "La categoria no ha sido creada con exito", '?controller=CategoriaController&action=crear');
                        }  
                    /*Comprobar si la categoria existe y esta activa*/    
                    }elseif($unico == 1){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Esta categoria ya se encuentra registrada", '?controller=CategoriaController&action=crear');
                    /*Comprobar si la categoria existe y no esta activa*/ 
                    }elseif($unico == 0){
                        /*Llamar funcion para recuperar la categoria eliminada*/
                        $recuperada = $this -> recuperarCategoria($nombre);
                        /*Comprobar si la categoria ha sido recuperada*/
                        if($recuperada){
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarcategoriaacierto', "La categoria ha sido recuperada", '?controller=AdministradorController&action=gestionarCategoria');
                        /*De lo contrario*/
                        }else{
                            /*Crear la sesion y redirigir a la ruta pertinente*/
                            Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "La categoria no ha sido recuperada con exito", '?controller=CategoriaController&action=crear');
                        }
                    /*De lo contrario*/    
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
                    }
                /*De lo contrario*/     
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Ha ocurrido un error al guardar la categoria", '?controller=CategoriaController&action=crear');
                }
            /*De lo contrario*/     
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('guardarcategoriaerror', "Ha ocurrido un error al guardar la categoria", '?controller=CategoriaController&action=crear');
            }
        }

        /*
        Funcion para eliminar una categoria en la base de datos
        */

        public function eliminarCategoria($idCategoria){
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Crear el objeto*/
            $categoria -> setId($idCategoria);
            /*Ejecutar la consulta*/
            $eliminado = $categoria -> eliminar();
            /*Retornar el resultado*/
            return $eliminado;
        }

        /*
        Funcion para eliminar una categoria
        */

        public function eliminar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idCategoria = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idCategoria){
                    /*Llamar la funcion que elimina la categoria*/
                    $eliminado = $this -> eliminarCategoria($idCategoria);
                    /*Comprobar si la categoria ha sido eliminada con exito*/
                    if($eliminado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarcategoriaacierto', "La categoria ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarCategoria');
                    /*De lo contrario*/   
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('eliminarcategoriaerror', "La categoria no ha sido eliminada exitosamente", '?controller=AdministradorController&action=gestionarCategoria');
                    }
                /*De lo contrario*/   
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('eliminarcategoriaerror', "Ha ocurrido un error al eliminar la categoria", '?controller=AdministradorController&action=gestionarCategoria');
                }
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para editar una categoria en la base de datos
        */

        public function editarCategoria($id){
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Crear el objeto*/
            $idCategoria = $categoria -> setId($id);
            /*Retornar el resultado*/
            return $idCategoria;
        }

        /*
        Funcion para editar una categoria
        */

        public function editar(){
            /*Comprobar si el dato esta llegando*/
            if(isset($_GET)){
                /*Comprobar si el dato existe*/
                $idCategoria = isset($_GET['id']) ? $_GET['id'] : false;
                /*Si el dato existe*/
                if($idCategoria){
                    /*Llamar la funcion de editar categoria*/
                    $categoria = $this -> editarCategoria($idCategoria);
                    /*Comprobar si la categoria ha sido editada*/
                    if($categoria){
                        /*Llamar la funcion para obtener una categoria en concreto*/
                        $categoriaUnica = $categoria -> obtenerUna();
                        /*Comprobar si la cateogoria ha sido obtenida*/
                        if($categoriaUnica){
                            /*Incluir la vista*/
                            require_once "Vistas/Categoria/Actualizar.html";
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
        Funcion para actualizar una categoria en la base de datos
        */

        public function actualizarCategoria($idCategoria, $nombre){
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Crear el objeto*/
            $categoria -> setId($idCategoria);
            $categoria -> setNombre($nombre);
            /*Intentar actualizar la categoria en la base de datos*/
            try{
                /*Ejecutar la consulta*/
                $actualizado = $categoria -> actualizar();
            /*Capturar la excepcion*/    
            }catch(mysqli_sql_exception $excepcion){
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir('actualizarcategoriaerror', "Este nombre de categoria ya existe", '?controller=CategoriaController&action=editar&id='.$idCategoria);
                /*Cortar la ejecucion*/
                die();
            }
            /*Retornar el resultado*/
            return $actualizado;
        }

        /*
        Funcion para actualizar una categoria
        */

        public function actualizar(){
            /*Comprobar si los datos están llegando*/
            if(isset($_GET) && isset($_POST)){
                /*Comprobar si los datos existen*/
                $idCategoria = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombrecatact']) ? $_POST['nombrecatact'] : false;
                /*Si los datos existen*/
                if($idCategoria){
                    /*Llamar la funcion de actualizar categoria*/
                    $actualizado = $this -> actualizarCategoria($idCategoria, $nombre);
                    /*Comprobar si la categoria ha sido actualizada*/
                    if($actualizado){
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarcategoriaacierto', "La categoria ha sido actualizada exitosamente", '?controller=AdministradorController&action=gestionarCategoria');
                    /*De lo contrario*/ 
                    }else{
                        /*Crear la sesion y redirigir a la ruta pertinente*/
                        Ayudas::crearSesionYRedirigir('actualizarcategoriasugerencia', "Introduce nuevos datos", '?controller=CategoriaController&action=editar&id='.$idCategoria);
                    }
                /*De lo contrario*/     
                }else{
                    /*Crear la sesion y redirigir a la ruta pertinente*/
                    Ayudas::crearSesionYRedirigir('actualizarcategoriaerror', "Ha ocurrido un error al actualizar la cateogoria", '?controller=CategoriaController&action=editar&id='.$idCategoria);
                }  
            /*De lo contrario*/    
            }else{
                /*Crear la sesion y redirigir a la ruta pertinente*/
                Ayudas::crearSesionYRedirigir("errorinesperado", "Ha ocurrido un error inesperado", "?controller=VideojuegoController&action=inicio");
            }
        }

    }

?>