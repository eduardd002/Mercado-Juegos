<?php

    //Incluir el objeto de videojuego
    require_once 'Modelos/Videojuego.php';

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    //Incluir el objeto de uso
    require_once 'Modelos/Uso.php';

    //Incluir el objeto de videojuegocategoria
    require_once 'Modelos/VideojuegoCategoria.php';

    class VideojuegoController{

        /*
        Funcion para listar algunos videojuegos en la pantalla de inicio
        */

        public function inicio(){
            
            //Incluir la vista
            require_once 'Vistas/Layout/Catalogo.html';

        }

        /*
        Funcion para ver el detalle del videojuego
        */

        public function detalle(){

            //Incluir la vista
            require_once 'Vistas/Videojuego/Detalle.html';
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
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

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

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $consola = isset($_POST['consola']) ? $_POST['consola'] : false;
                $uso = isset($_POST['uso']) ? $_POST['uso'] : false;
                $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
                $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
                $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
                $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : false;

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

                    //Obtener id del ultimo videojuego registrado
                    $total = $videojuego -> proximoVideojuego();

                    //Instanciar el objeto
                    $videojuegoCategoria = new VideojuegoCategoria();

                    //Crear el objeto

                    //Registrar id de videojuego futuro o proximo a registrar
                    $videojuegoCategoria -> setIdVideojuego(($total -> id)+1);
                    $videojuegoCategoria -> setCategoriaId($categorias);

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

                        //Guardar en la base de datos
                        $guardadoVideojuegoCategoria = $videojuegoCategoria -> guardar();

                        //Comprobar se ejecutó con exito la consulta
                        if($guardado && $guardadoVideojuegoCategoria){
                                //Crear sesion de videojuego creado con exito
                                $_SESSION['RegistroVideojuego'] = "Videojuego creado con exito";
                                //Redirigir al menu principal
                                header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        }
                    }else{
                        //Crear sesion que indique que la imagen debe ser de formato imagen
                        $_SESSION['RegistroVideojuego'] = "El formato debe ser de una imagen";
                        //Redirigir al registro de usuario
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=crear");
                    }
                }else{
                    //Crear sesion que indique que ha ocurrido un error inesperado al hacer el registro
                    $_SESSION['RegistroVideojuego'] = "Ha ocurrido un error al realizar el registro";
                    //Redirigir al registro de usuario
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

            //Incluir la vista
            require_once 'Vistas/Videojuego/Todos.html';
        }
    }

?>