<?php

    //Incluir el objeto de videojuego
    require_once 'Modelos/Videojuego.php';

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    //Incluir el objeto de comentario
    require_once 'Modelos/Comentario.php';

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    //Incluir el objeto de uso
    require_once 'Modelos/Uso.php';

    //Incluir el objeto de videojuegocategoria
    require_once 'Modelos/VideojuegoCategoria.php';

    //Incluir el objeto de usuariovideojuego
    require_once 'Modelos/UsuarioVideojuego.php';

    //Incluir el objeto de comentariovideojuego
    require_once 'Modelos/ComentarioVideojuego.php';

    class VideojuegoController{

        /*
        Funcion para listar algunos videojuegos en la pantalla de inicio
        */

        public function inicio(){

            if(isset($_SESSION['loginexitosoa'])){
                require_once 'Vistas/Administrador/Inicio.html';
            }else{
                //Instanciar el objeto
                $videojuego = new Videojuego();
                //Traer el listado de algunos videojuegos
                $listadoAlgunos = $videojuego -> listarAlgunos();
                //Traer el listado de todos los videojuegos
                $listadoTodos = $videojuego -> listarTodos();
                //Incluir la vista
                require_once 'Vistas/Layout/Catalogo.html';
            }
        }

        /*
        Funcion para traer un videojuego en concreto
        */

        public function traerVideojuegoEspecifico($id){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Construir el objeto
            $videojuego -> setId($id);
            //Traer videojuego en concreto
            $videojuegoEspecifico = $videojuego -> traerUno();
            //Retornar resultado
            return $videojuegoEspecifico;
        }

        /*
        Funcion para obtener el usuario vendedor del videojuego
        */

        public function obtenerUsuarioVendedor($id){
            //Instanciar el objeto
            $usuarioVideojuego = new UsuarioVideojuego();
            //Construir el objeto
            $usuarioVideojuego -> setIdVideojuego($id);
            //Traer el resultado
            $datosVendedor = $usuarioVideojuego -> obtenerUsuarioVendedor();
            //Retornar el resultado
            return $datosVendedor;
        }

        /*
        Funcion para obtener los comentarios referentes a una publicacion
        */

        public function obtenerComentariosDeVideojuego($id){
            //Instanciar el objeto
            $comentarioVideojuego = new ComentarioVideojuego();
            //Construir el objeto
            $comentarioVideojuego -> setIdVideojuego($id);
            //Traer el resultado
            $listaComentarios = $comentarioVideojuego -> obtenerComentariosDeVideojuego();
            //Retornar el resultado
            return $listaComentarios;
        }

        /*
        Funcion para ver el detalle del videojuego
        */

        public function detalle(){

            //Comprobar si el dato está llegando
            if(isset($_GET)){
                //Comprobar si el dato existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;

                //Comprobar el dato exsiten
                if($id){
                
                    //Obtener resultado
                    $videojuegoEspecifico = $this -> traerVideojuegoEspecifico($id);

                    //Comprobar si el resultado ha llegado
                    if($videojuegoEspecifico){

                        //Obtener usuario vendedor del videojuego
                        $datosVendedor = $this -> obtenerUsuarioVendedor($id);
                        //Obtener lista de comentarios referentes a una publicacion
                        $listaComentarios = $this -> obtenerComentariosDeVideojuego($id);
                        //Incluir la vista
                        require_once 'Vistas/Videojuego/Detalle.html';

                    }else{
                        //Redirigir al catalogo
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                    }
                }
            }
        }

        /*
        Funcion para crear un videojuego
        */

        public function crear(){

            //Instanciar el objeto
            $categoria = new Categoria();
            //Listar todos los usuarios desde la base de datos
            $listadoCategorias = $categoria -> listar();

            //Instanciar el objeto
            $uso = new Uso();
            //Listar todos los usuarios desde la base de datos
            $listadoUsos = $uso -> listar();

            //Instanciar el objeto
            $consola = new Consola();
            //Listar todos los usuarios desde la base de datos
            $listadoConsolas = $consola -> listar();

            //Incluir la vista
            require_once 'Vistas/Videojuego/Crear.html';
        }

        /*
        Funcion para buscar un videojuego
        */

        public function buscarVideojuego($nombre){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear el objeto
            $videojuego -> setNombre($nombre);
            //Obtener videojuegos de la base de datos
            $listaVideojuegos = $videojuego -> buscar();
            //Retornar el resultado
            return $listaVideojuegos;
        }

        /*
        Funcion para buscar un videojuego en concreto
        */

        public function buscar(){

            //Comprobar si el dato está llegando
            if(isset($_POST)){

                //Comprobar si el dato existe
                $nombre = isset($_POST['nombrebus']) ? $_POST['nombrebus'] : false;

                //Comprobar el dato exsiten
                if($nombre){

                    //Obtener el resultado
                    $listaVideojuegos = $this -> buscarVideojuego($nombre);

                    //Comprobar si llegan videojuegos
                    if(mysqli_num_rows($listaVideojuegos) > 0){
                        //Incluir la vista de buscador
                        require_once 'Vistas/Videojuego/Buscar.html';
                    }else{
                        //Incluir la vista
                        require_once 'Vistas/Videojuego/NoEncontrado.html';
                    }
                }
            }
        }

        /*
        Funcion para guardar el videojuego en la base de datos
        */

        public function guardarVideojuego($nombre, $consola, $uso, $precio, $descripcion, $stock, $nombreArchivo){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear el objeto
            $videojuego -> setActivo(1);
            $videojuego -> setNombre($nombre);
            $videojuego -> setIdConsola($consola);
            $videojuego -> setIdUso($uso);
            $videojuego -> setPrecio($precio);
            $videojuego -> setDescripcion($descripcion);
            $videojuego -> setStock($stock);
            $videojuego -> setFechaCreacion(date('y-m-d'));
            $videojuego -> setFoto($nombreArchivo);
            //Guardar el videojuego en la base de datos
            $guardado = $videojuego -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo videojuego guardado
        */

        public function obtenerUltimoVideojuego(){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Obtener id del ultimo videojuego registrado
            $id = $videojuego -> ultimo();
            //Retornar resultado
            return $id;
        }

        /*
        Funcion para guardar el videojuego categoria en la base de datos
        */

        public function guardarVideojuegoCategoria($categorias){

            //Instanciar el objeto
            $videojuegoCategoria = new VideojuegoCategoria();
            //Crear el objeto
            $videojuegoCategoria -> setActivo(1);
            $videojuegoCategoria -> setIdVideojuego($this -> obtenerUltimoVideojuego());
            $videojuegoCategoria -> setIdCategoria($categorias);
            //Guardar en la base de datos
            $guardadoVideojuegoCategoria = $videojuegoCategoria -> guardar();
            //Retornar el resultado
            return $guardadoVideojuegoCategoria;
        }

        /*
        Funcion para guardar el videojuego usuario en la base de datos
        */

        public function guardarVideojuegoUsuario($usuarioId){

            //Instanciar el objeto
            $usuarioVideojuego = new UsuarioVideojuego();
            //Crear el objeto         
            $usuarioVideojuego -> setActivo(1); 
            $usuarioVideojuego -> setIdVideojuego($this -> obtenerUltimoVideojuego());
            $usuarioVideojuego -> setIdUsuario($usuarioId);
            //Guardar en la base de datos
            $guardadoUsuarioVideojuego = $usuarioVideojuego -> guardar();
            //Retornar el resultado
            return $guardadoUsuarioVideojuego;
        }

        /*
        Funcion para guardar el videojuego en la base de datos
        */

        public function guardar(){

            //Comprobar si existe la sesion de usuario logueado
            $usuarioId = isset($_SESSION['loginexitoso']) ? $_SESSION['loginexitoso'] -> id : false;

            //Comprobar si los datos están llegando
            if(isset($_POST) && $usuarioId){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombrevid']) ? $_POST['nombrevid'] : false;
                $consola = isset($_POST['consolavid']) ? $_POST['consolavid'] : false;
                $uso = isset($_POST['usovid']) ? $_POST['usovid'] : false;
                $precio = isset($_POST['preciovid']) ? $_POST['preciovid'] : false;
                $stock = isset($_POST['stockvid']) ? $_POST['stockvid'] : false;
                $descripcion = isset($_POST['descripcionvid']) ? $_POST['descripcionvid'] : false;
                $categorias = isset($_POST['categoriasvid']) ? $_POST['categoriasvid'] : false;
                $archivo = $_FILES['foto'];
                $foto = $archivo['name'];
            
                //Comprobar si todos los datos exsiten
                if($nombre && $consola && $uso && $precio && $descripcion && $stock){

                    //Comprobar si la foto es valida
                    $fotoGuardada = Ayudas::guardarImagen($archivo, "ImagenesVideojuegos");

                    //Comprobar si la foto ha sido guardada
                    if($fotoGuardada){

                        //Guardar en la base de datos
                        $guardado = $this -> guardarVideojuego($nombre, $consola, $uso, $precio, $descripcion, $stock, $foto);

                        //Comprobar si ha sido guardado el videojuego con exito
                        if($guardado){

                            //Guardar el videojuego cateogoria y videojuego usuario
                            $guardadoCategoriaVideojuego = $this -> guardarVideojuegoCategoria($categorias);
                            $guardadoUsuarioVideojuego = $this -> guardarVideojuegoUsuario($usuarioId);

                            //Comprobar si el videojuego cateogoria y videojuego usuario han sido guardados exitosamente
                            if($guardadoUsuarioVideojuego && $guardadoCategoriaVideojuego){
                                //Crear la sesion y redirigir a la ruta pertinente
                                Ayudas::crearSesionYRedirigir("guardarvideojuegoacierto", "El videojuego ha sido guardado con exito", "?controller=VideojuegoController&action=inicio");
                            }else{
                                //Crear la sesion y redirigir a la ruta pertinente
                                Ayudas::crearSesionYRedirigir("guardarvideojuegoerror", "Ha ocurrido un error al guardar el videojuego", "?controller=VideojuegoController&action=crear");
                            }
                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir("guardarvideojuegoerror", "Ha ocurrido un error al guardar el videojuego", "?controller=VideojuegoController&action=crear");
                        }
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("guardarvideojuegoerror", "La imagen debe ser formato imagen", "?controller=VideojuegoController&action=crear");
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("guardarvideojuegoerror", "Ha ocurrido un error al guardar el videojuego", "?controller=VideojuegoController&action=crear");
                }
            }
        }

        /*
        Funcion para editar una consola en la base de datos
        */

        public function editarVideojuego($idVideojuego){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Creo el objeto y retornar el resultado
            return $videojuego -> setId($idVideojuego);
        }

        /*
        Funcion para editar un videojuego
        */

        public function editar(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idVideojuego = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idVideojuego){

                    //Obtener el resultado
                    $videojuego = $this -> editarVideojuego($idVideojuego);

                    //Obtener consola
                    $videojuegoUnico = $videojuego -> traerUno();

                    //Incluir la vista
                    require_once "Vistas/Videojuego/Actualizar.html";

                }
            }
        }
            
        public function actualizarVideojuego($id, $precio, $stock){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear objeto
            $videojuego -> setId($id);
            $videojuego -> setPrecio($precio);
            $videojuego -> setStock($stock);
            //Ejecutar la consulta
            $actualizado = $videojuego -> actualizar();
            return $actualizado;
        }

        /*
        Funcion para actualizar un usuario
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
                $stock = isset($_POST['stock']) ? $_POST['stock'] : false;

                //Si el dato existe
                if($id && $precio && $stock){

                    //Llamar la funcion de actualizar
                    $actualizado = $this -> actualizarVideojuego($id, $precio, $stock);

                    if($actualizado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarvideojuegoacierto', "Videojuego actualizado con exito", '?controller=UsuarioController&action=videojuegos');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarvideojuegosugerencia', "Agrega nuevos datos", '?controller=VideojuegoController&action=editar&id='.$id);
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizarvideojuegoerror', "Ha ocurrido un error al actualizar el videojuego", '?controller=VideojuegoController&action=inicio');
                }
            }else{
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('actualizarvideojuegoerror', "Ha ocurrido un error al actualizar el videojuego", '?controller=VideojuegoController&action=inicio');
            }
        }

        /*
        Funcion para eliminar un usuario
        */

        public function eliminarVideojuego($idVideojuego){

            //Instanciar el objeto
            $videojuego = new Videojuego();
            //Crear objeto
            $videojuego -> setId($idVideojuego);
            //Ejecutar la consulta
            $eliminado = $videojuego -> eliminar();
            //Retornar el resultado
            return $eliminado;
        }

        /*
        Funcion para eliminar un usuario desde el administrador
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idVideojuego = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idVideojuego){

                    //Ejecutar la consulta
                    $eliminado = $this -> eliminarVideojuego($idVideojuego);

                    //Comprobar si el usuario ha sido eliminado
                    if($eliminado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminaradministradorusuarioacierto', "El usuario ha sido eliminado exitosamente", '?controller=VideojuegoController&action=videojuegos');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminaradministradorusuarioerror', "El usuario no ha sido eliminado exitosamente", '?controller=VideojuegoController&action=videojuegos');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminaradministradorusuarioerror', "Ha ocurrido un error al eliminar el usuario", '?controller=VideojuegoController&action=inicio');
                }
            }
        }

        /*
        Funcion para listar todos los videojuegos en la pantalla de inicio
        */

        public function todos(){

            //Instaciar el objeto
            $videojuego = new Videojuego();
            //Traer los datos de la consulta
            $listadoTodos = $videojuego -> listarTodos();
            //Incluir la vista
            require_once 'Vistas/Videojuego/Todos.html';
        }

        public function filtro(){

            //Comprobar si el dato está llegando
            if(isset($_POST)){

                //Comprobar si el dato existe
                $consola = isset($_POST['consolavid']) ? $_POST['consolavid'] : false;
                $uso = isset($_POST['usovid']) ? $_POST['usovid'] : false;
                $categoria = isset($_POST['categoriavid']) ? $_POST['categoriavid'] : false;
                $minimo = isset($_POST['minimo']) ? $_POST['minimo'] : false;
                $maximo = isset($_POST['maximo']) ? $_POST['maximo'] : false;

                //Comprobar el dato exsiten
                if($consola && $uso && $categoria){

                    //Instaciar el objeto
                    $videojuego = new Videojuego();
                    $videojuego -> setIdConsola($consola);
                    $videojuego -> setIdUso($uso);
                    //Traer los datos de la consulta

                    $listadoFiltro = $videojuego -> filtro($minimo, $maximo, $categoria);
                    
                    require_once 'Vistas/Videojuego/Filtro.html';
                    
                }
            }
        }
    }

?>