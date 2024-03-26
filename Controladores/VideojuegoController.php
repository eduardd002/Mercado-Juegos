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

    class VideojuegoController{

        /*
        Funcion para listar algunos videojuegos en la pantalla de inicio
        */

        public function inicio(){

            //Instanciar el objeto
            $videojuego = new Videojuego();

            //Traer el listado de algunos videojuegos
            $listadoAlgunos = $videojuego -> listarAlgunos();

            //Traer el listado de todos los videojuegos
            $listadoTodos = $videojuego -> listarTodos();
            
            //Incluir la vista
            require_once 'Vistas/Layout/Catalogo.html';
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
            if(isset($_POST)){

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
        Funcion para actualizar un videojuego
        */

        public function actualizar(){

            //Incluir la vista
            require_once 'Vistas/Videojuego/Actualizar.html';
        }

        /*
        Funcion para eliminar un videojuego
        */

        public function eliminar(){
            
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
    }

?>