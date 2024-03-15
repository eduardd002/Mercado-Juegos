<?php

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    //Incluir el objeto de administrador
    require_once 'Modelos/Administrador.php';

    class UsuarioController{

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
                $nombre = isset($_POST['nombreusu']) ? $_POST['nombreusu'] : false;
                $apellidos = isset($_POST['apellidosusu']) ? $_POST['apellidosusu'] : false;
                $fechaNacimiento = isset($_POST['fechaNacimientousu']) ? $_POST['fechaNacimientousu'] : false;
                $telefono = isset($_POST['telefonousu']) ? $_POST['telefonousu'] : false;
                $email = isset($_POST['emailusu']) ? $_POST['emailusu'] : false;
                $clave = isset($_POST['passwordusu']) ? $_POST['passwordusu'] : false;
                $departamento = isset($_POST['departamentousu']) ? $_POST['departamentousu'] : false;
                $municipio = isset($_POST['municipiousu']) ? $_POST['municipiousu'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre && $apellidos && $fechaNacimiento && $telefono && $clave && $email && $departamento && $municipio){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Crear el objeto
                    $usuario -> setNombre($nombre);
                    $usuario -> setApellido($apellidos);
                    $usuario -> setFechanacimiento($fechaNacimiento);
                    $usuario -> setNumerotelefono($telefono);
                    $usuario -> setCorreo($email);
                    $usuario -> setClave($clave);
                    $usuario -> setDepartamento($departamento);
                    $usuario -> setMunicipio($municipio);
                    $usuario -> setFecharegistro(date('y-m-d'));

                    $claveSegura = Ayudas::comprobarContrasenia($clave);
                    
                    //Comprobar si la clave cumple con las condiciones para que sea segura
                    if($claveSegura){
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
                                $_SESSION['login_exitosoinfo'] = "Bienvenido Usuario";
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
                        //Crear Sesion que indique la seguridad y el tamaño que debe tener la contraseña que registra el usuario
                        $_SESSION['ClavePocoSegura'] = "La clave debe contener una minuscula, una mayuscula, un caracterer especial, un numero y minimo 8 caracteres de longitud";
                        //Redirigir al formulario de registro
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

                    //Instanciar el objeto
                    $administrador = new Administrador();

                    //Crear el objeto
                    $administrador -> setCorreo($email);
                    $administrador -> setClave($clave);
                    
                    //Obtener objeto de la base de datos
                    $ingresoa = $administrador->login();

                    //Comprobar se ejecutó con exito la consulta
                    if($ingreso && is_object($ingreso)){
                        //Crear la sesion con el objeto completo del usuario
                        $_SESSION['login_exitoso'] = $ingreso;
                        $_SESSION['login_exitosoinfo'] = "Bienvenido Usuario";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                    }else if($ingresoa && is_object($ingresoa)){
                        //Crear la sesion con el objeto completo del administrador
                        $_SESSION['login_exitosoa'] = $ingresoa;
                        $_SESSION['login_exitosoinfoa'] = "Bienvenido administrador";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
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
        Funcion para eliminar la cuenta del usuario de la base de datos
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idUsuario = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idUsuario){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Crear objeto
                    $usuario -> setId($idUsuario);

                    //Ejecutar la consulta
                    $eliminado = $usuario -> eliminar();

                    if($eliminado){
                        //Crear Sesion que indique que el usuario se ha eliminado con exito
                        $_SESSION['usuarioeliminado'] = "El usuario ha sido eliminado exitosamente";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        //Eliminar el inicio de sesion
                        Ayudas::eliminarSesion('login_exitoso');
                    }else{
                        //Crear Sesion que indique que el usuario se ha eliminado con exito
                        $_SESSION['usuarioeliminado'] = "El usuario no ha sido eliminado exitosamente";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=miPerfil");
                    }
                }  
            }
        }

        /*
        Funcion para actualizar un usuario
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $clave = isset($_POST['password']) ? $_POST['password'] : false;
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;

                //Si el dato existe
                if($id && $nombre && $apellidos && $telefono && $email && $clave && $departamento && $municipio){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Crear objeto
                    $usuario -> setId($id);
                    $usuario -> setNombre($nombre);
                    $usuario -> setApellido($apellidos);
                    $usuario -> setNumerotelefono($telefono);
                    $usuario -> setCorreo($email);
                    $usuario -> setClave($clave);
                    $usuario -> setDepartamento($departamento);
                    $usuario -> setMunicipio($municipio);

                    //Ejecutar la consulta
                    $actualizado = $usuario -> actualizar();

                    if($actualizado){
                        //Crear Sesion que indique que el usuario se ha actualizado con exito
                        $_SESSION['usuarioactualizado'] = "El usuario ha sido actualizado exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                    }else{
                        //Crear Sesion que indique que el usuario no se ha actualizado con exito
                        $_SESSION['usuarioactualizado'] = "Proporciona nuevos datos";
                        //Redirigir a la gestion de categorias
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=miPerfil");
                    }
                }else{
                    //Crear Sesion que indique que el usuario no se ha actualizado con exito
                    $_SESSION['usuarioactualizado'] = "Ha ocurrido un error al actualizar el usuario";
                    //Redirigir a la gestion de categorias
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=miPerfil");
                } 
            }
        }

        /*
        Funcion para cerrar la sesión
        */

        public function cerrarSesion(){

            //Lamar funciones para eliminar las sesiones
            Ayudas::eliminarSesion('login_exitoso');
            Ayudas::eliminarSesion('login_exitosoa');
            
            //Crear sesion de sesion creada con exito
            $_SESSION['logincerrado'] = "Sesion cerrada con exito";

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

            //Llamar la funcion auxiliar para redirigir en caso de que no haya inicio de sesion
            Ayudas::restringirAUsuario();

            //Comprobar si el dato está llegando
            if(isset($_GET)){

                //Comprobar si la sesion de inicio de sesion existe
                $id = isset($_SESSION['login_exitoso']) ? $_SESSION['login_exitoso'] -> id : false;

                //Si el dato existe
                if($id){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Creo el objeto
                    $usuario -> setId($id);

                    //Obtener categoria
                    $usuarioUnico = $usuario -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Usuario/miPerfil.html";
                }
            }
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