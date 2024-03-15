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

            $videojuego = new Videojuego();
            $listadoAlgunos = $videojuego -> listarAlgunos();
            
            //Incluir la vista
            require_once 'Vistas/Layout/Catalogo.html';
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
                
                    //Instanciar el objeto
                    $videojuego = new Videojuego();

                    //Construir el objeto
                    $videojuego -> setId($id);

                    //Traer videojuego en concreto
                    $videojuegoEspecifico = $videojuego -> traerUno();

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
        Funcion para buscar un videojuego en concreto
        */

        public function buscar(){

            //Comprobar si el dato está llegando
            if(isset($_POST)){

                //Comprobar si el dato existe
                $nombre = isset($_POST['nombrebus']) ? $_POST['nombrebus'] : false;

                //Comprobar el dato exsiten
                if($nombre){

                    //Instanciar el objeto
                    $videojuego = new Videojuego();
                    //Crear el objeto
                    $videojuego -> setNombre($nombre);

                    //Obtener videojuegos de la base de datos
                    $listaVideojuegos = $videojuego -> buscar();

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

        public function guardar(){

            //Comprobar si existe la sesion de usuario logueado
            $usuarioId = isset($_SESSION['login_exitoso']) ? $_SESSION['login_exitoso'] -> id : false;

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
            
                //Comprobar si todos los datos exsiten
                if($nombre && $consola && $uso && $precio && $descripcion && $stock){

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

                    //Guardar la imagen

                    //Guardar toda la informacion referente a la imagen
                    $archivo = $_FILES['foto'];
                    //Extraer nombre del archivo de imagen
                    $nombreArchivo = $archivo['name'];
                    //Extraer el tipo de archivo de la imagen
                    $tipoArchivo = $archivo['type'];

                    //Comprobar si el archivo tiene la extensión de una imagen
                    if($tipoArchivo == "image/jpg" || $tipoArchivo == "image/jpeg" || $tipoArchivo == "image/png" || $tipoArchivo == "image/gif"){

                        //Comprobar si no existe un directorio para las imagenes a subir
                        if(!is_dir('Recursos/ImagenesVideojuegos')){

                            //Crear el directorio
                            mkdir('Recursos/ImagenesVideojuegos', 0777, true);
                        }

                        //Crear el objeto
                        $videojuego -> setFoto($nombreArchivo);
                        //Mover la foto subida a la ruta temporal del servidor y luego a la de la carpeta de las imagenes
                        move_uploaded_file($archivo['tmp_name'], 'Recursos/ImagenesVideojuegos/'.$nombreArchivo);

                        //Guardar en la base de datos
                        $guardado = $videojuego -> guardar();

                        //Comprobar se ejecutaron con exito las consultas
                        if($guardado){

                            //Obtener id del ultimo videojuego registrado
                            $id = $videojuego -> ultimo();

                            //Instanciar el objeto
                            $videojuegoCategoria = new VideojuegoCategoria();

                            //Crear el objeto

                            //Registrar id de videojuego futuro o proximo a registrar
                            $videojuegoCategoria -> setIdVideojuego($id);
                            $videojuegoCategoria -> setCategoriaId($categorias);

                            //Instanciar el objeto
                            $usuarioVideojuego = new UsuarioVideojuego();

                            //Crear el objeto
                                
                            //Registrar id de videojuego futuro o proximo a registrar
                            $usuarioVideojuego -> setIdVideojuego($id);
                            $usuarioVideojuego -> setIdUsuario($usuarioId);

                            //Guardar en la base de datos
                            $guardadoVideojuegoCategoria = $videojuegoCategoria -> guardar();

                            //Guardar en la base de datos
                            $guardadoUsuarioVideojuego = $usuarioVideojuego -> guardar();

                            if($guardadoUsuarioVideojuego && $guardadoVideojuegoCategoria){
                                //Crear sesion de videojuego creado con exito
                                $_SESSION['RegistroVideojuego'] = "Videojuego creado con exito";
                                //Redirigir al menu principal
                                header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                            }
                        }
                    }else{
                        //Crear sesion que indique que la imagen debe ser de formato imagen
                        $_SESSION['RegistroVideojuego'] = "El formato debe ser de una imagen";
                        //Redirigir al registro de videojuego
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=crear");
                    }
                }else{
                    //Crear sesion que indique que ha ocurrido un error inesperado al hacer el registro
                    $_SESSION['RegistroVideojuego'] = "Ha ocurrido un error al realizar el registro";
                    //Redirigir al registro de videojuego
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=crear");
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