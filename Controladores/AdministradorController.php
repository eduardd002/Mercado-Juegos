<?php

    //Incluir el objeto de uso
    require_once 'Modelos/Uso.php';

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    //Incluir el objeto de tarjeta
    require_once 'Modelos/Tarjeta.php';

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    class AdministradorController{

        /*
        Funcion para gestionar los usuarios
        */

        public function gestionarUsuario(){
            //Instanciar el objeto
            $usuario = new Usuario();
            //Listar todos los usuarios desde la base de datos
            $listadoUsuarios = $usuario -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionUsuarios.html";
        }

        /*
        Funcion para gestionar las categorias
        */

        public function gestionarCategoria(){

            //Incluir la vista
            require_once "Vistas/Administrador/GestionCategorias.html";
        }

        /*
        Funcion para gestionar las tarjetas
        */

        public function gestionarTarjeta(){

            //Incluir la vista
            require_once "Vistas/Administrador/GestionTarjetas.html";
        }

        /*
        Funcion para gestionar los usos
        */

        public function gestionarUso(){

            //Incluir la vista
            require_once "Vistas/Administrador/GestionUsos.html";
        }

        /*
        Funcion para gestionar las consolas
        */

        public function gestionarConsola(){

            //Incluir la vista
            require_once "Vistas/Administrador/GestionConsolas.html";
        }

        /*
        Funcion para crear un estado
        */

        public function gestionarEstado(){

            //Incluir la vista
            require_once "Vistas/Administrador/GestionEstados.html";
        }

        /*
        Funcion para crear una categoria
        */

        public function crearCategoria(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearCategorias.html";
        }

        /*
        Funcion para crear una tarjeta
        */

        public function crearTarjeta(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearTarjetas.html";
        }

        /*
        Funcion para crear un uso
        */

        public function crearUso(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearUsos.html";
        }

        /*
        Funcion para crear una consola
        */

        public function crearConsola(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearConsolas.html";
        }

        /*
        Funcion para crear un estado
        */

        public function crearEstado(){

            //Incluir la vista
            require_once "Vistas/Administrador/CrearEstados.html";
        }

        /*
        Funcion para guardar una categoria en la base de datos
        */

        public function guardarCategoria(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

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

        /*
        Funcion para guardar un uso en la base de datos
        */

        public function guardarUso(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

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
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
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
        Funcion para guardar una consola en la base de datos
        */

        public function guardarConsola(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $consola = new Consola();

                    //Crear el objeto
                    $consola -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $consola -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de consola creada
                        $_SESSION['consolacreada'] = 'La consola ha sido creada con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la consola
                        $_SESSION['consolanocreada'] = 'La consola no ha sido creada con exito';
                        //Redirigir al registro de consola
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearConsola");
                    }
                }
            }
        }

        /*
        Funcion para guardar un estado en la base de datos
        */

        public function guardarEstado(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $estado = new Estado();

                    //Crear el objeto
                    $estado -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $estado -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de estado creado
                        $_SESSION['estadocreado'] = 'El estado ha sido creado con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar el estado
                        $_SESSION['categorianocreada'] = 'El estado no ha sido creado con exito';
                        //Redirigir al registro de estado
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearEstado");
                    }
                }
            }
        }

        /*
        Funcion para guardar una tarjeta en la base de datos
        */

        public function guardarTarjeta(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre){
                    //Instanciar el objeto
                    $tarjeta = new Tarjeta();

                    //Crear el objeto
                    $tarjeta -> setNombre($nombre);

                    //Guardar en la base de datos
                    $guardado = $tarjeta -> guardar();

                    //Comprobar se ejecutó con exito la consulta
                    if($guardado){
                        //Crear sesion de tarjeta creada
                        $_SESSION['tarjetacreada'] = 'La tarjeta ha sido creada con exito';
                        //Redirigir al menu principal
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                    }else{
                        //Crear sesion que indique que ha habido un error al guardar la tarjeta
                        $_SESSION['tarjetanocreada'] = 'La tarjeta no ha sido creada con exito';
                        //Redirigir al registro de tarjeta
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=crearTarjeta");
                    }
                }
            }
        }
    }
?>