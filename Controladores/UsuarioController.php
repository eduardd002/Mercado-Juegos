<?php

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    class UsuarioController{

        /*
        Funcion para entrar a las funciones de administrador
        */

        public function administrar(){

            //Incluir la vista
            require_once "Vistas/Usuario/Administrador.html";
        }

        /*
        Funcion para realizar el inicio de sesion del usuario
        */

        public function login(){

            //Incluir la vista
            require_once "Vistas/Usuario/Login.html";
        }

        /*
        Funcion para realizar el registro del usuario
        */

        public function registro(){

            //Incluir la vista
            require_once "Vistas/Usuario/Registro.html";
        }

        /*
        Funcion para guardar el usuario en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $fechaNacimiento = isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $clave = isset($_POST['password']) ? $_POST['password'] : false;
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre && $apellidos && $fechaNacimiento && $telefono && $clave && $email && $departamento && $municipio){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Crear el objeto
                    $usuario -> setNombre($nombre);
                    $usuario -> setRol('Usuario');
                    $usuario -> setApellido($apellidos);
                    $usuario -> setFechanacimiento($fechaNacimiento);
                    $usuario -> setNumerotelefono($telefono);
                    $usuario -> setCorreo($email);
                    $usuario -> setClave($clave);
                    $usuario -> setDepartamento($departamento);
                    $usuario -> setMunicipio($municipio);
                    $usuario -> setFecharegistro(date('d-m-y'));

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
                        if(!is_dir('Recursos/ImagenesUsuarios')){

                            //Crear el directorio
                            mkdir('Recursos/ImagenesUsuarios', 0777, true);
                        }

                        //Crear el objeto
                        $usuario -> setFoto($nombreArchivo);
                        //Mover la foto subida a la ruta temporal del servidor y luego a la de la carpeta de las imagenes
                        move_uploaded_file($archivo['tmp_name'], 'Recursos/ImagenesUsuarios/'.$nombreArchivo);

                        //Guardar en la base de datos
                        $guardado = $usuario -> guardar();

                        //Comprobar se ejecutó con exito la consulta
                        if($guardado){
                            $ingreso = $usuario->login();
                            //Crear sesion de inicio de sesion
                            $_SESSION['login_exitoso'] = $ingreso;
                            //Redirigir al menu principal
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        }else{
                            //Crear sesion que indique que la ruta de correo ya esta en uso
                            $_SESSION['RegistroUsuario'] = "Ya hay una ruta de correo en uso";
                            //Redirigir al registro de usuario
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=registro");
                        }
                    }else{
                        //Crear sesion que indique que la imagen debe ser de formato imagen
                        $_SESSION['RegistroUsuario'] = "El formato debe ser de una imagen";
                        //Redirigir al registro de usuario
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=registro");
                    }
                }else{
                    //Crear sesion que indique que ha ocurrido un error inesperado al hacer el registro
                    $_SESSION['RegistroUsuario'] = "Ha ocurrido un error al realizar el registro";
                    //Redirigir al registro de usuario
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=registro");
                }
            }
        }

        /*
        Funcion para realizar el inicio de sesion
        */

        public function inicioDeSesion(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $clave = isset($_POST['password']) ? $_POST['password'] : false;

                //Comprobar si todos los datos exsiten
                if($email && $clave){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Crear el objeto
                    $usuario -> setCorreo($email);
                    $usuario -> setClave($clave);

                    //Obtener objeto de la base de datos
                    $ingreso = $usuario->login();

                    //Comprobar se ejecutó con exito la consulta
                    if($ingreso && is_object($ingreso)){
                        if($ingreso -> rol == 'Administrador'){
                            //Crear la sesion con el objeto completo del usuario
                            $_SESSION['administrar'] = true;
                            //Redirigir al inicio
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=administrar");
                        }else{
                            //Crear la sesion con el objeto completo del usuario
                            $_SESSION['login_exitoso'] = $ingreso;
                            //Redirigir al inicio
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        }
                    }else{
                        //Crear la sesion de error al realizar el login
                        $_SESSION['error_login'] = 'Este usuario no se encuentra registrado';
                        //Redirigir al login
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=login");
                    }
                }
            }
        }

        /*
        Funcion para cerrar la sesión
        */

        public function cerrarSesion(){
            //Comprobar si existe la sesion y si esta sesion contiene la informacion adecuada
            if(isset($_SESSION['login_exitoso'])){
                //Eliminar la sesión
                unset($_SESSION['login_exitoso']);
            }

            if(isset($_SESSION['administrar'])){
                //Eliminar la sesión
                unset($_SESSION['administrar']);
            }
            
            //Redirigir al menu principal
            header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
        }

        /*
        Funcion para ver el perfil de un usuario
        */

        public function perfil(){

            //Incluir la vista
            require_once "Vistas/Usuario/Perfil.html";
        }

        /*
        Funcion para ver el perfil del usuario indentificado
        */

        public function miPerfil(){

            //Incluir la vista
            require_once "Vistas/Usuario/miPerfil.html";
        }

        /*
        Funcion para ver el listado de compras realizadas por el usuario
        */

        public function compras(){

            //Incluir la vista
            require_once "Vistas/Usuario/Compras.html";
        }

        /*
        Funcion para ver el listado de ventas realizadas por el usuario
        */

        public function ventas(){

            //Incluir la vista
            require_once "Vistas/Usuario/Ventas.html";
        }

        /*
        Funcion para ver los videojuegos creados por el usuario indentificado
        */

        public function videojuegos(){

            //Incluir la vista
            require_once "Vistas/Usuario/Videojuegos.html";
        }

    }

?>