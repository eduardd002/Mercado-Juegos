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

    //Incluir el objeto de administrador
    require_once 'Modelos/Administrador.php';

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    class AdministradorController{

        /*
        Funcion para realizar el registro del administrador
        */

        public function registro(){

            //Incluir la vista
            require_once "Vistas/Administrador/Registro.html";
        }

        /*
        Funcion para entrar a las funciones de administrador
        */

        public function administrar(){

            //Incluir la vista
            require_once "Vistas/Administrador/Inicio.html";
        }

        /*
        Funcion para ver el perfil del administrador indentificado
        */

        public function miPerfil(){

            //Llamar la funcion auxiliar para redirigir en caso de que no haya inicio de sesion
            Ayudas::restringirAAdministrador();

            //Comprobar si el dato está llegando
            if(isset($_GET)){

                //Comprobar si la sesion de inicio de sesion existe
                $id = isset($_SESSION['login_exitosoa']) ? $_SESSION['login_exitosoa'] -> id : false;

                //Si el dato existe
                if($id){

                    //Instanciar el objeto
                    $administrador = new Administrador();

                    //Creo el objeto
                    $administrador -> setId($id);

                    //Obtener categoria
                    $adminUnico = $administrador -> obtenerUno();

                    //Incluir la vista
                    require_once "Vistas/Administrador/miPerfil.html";
                }
            }
        }

        /*
        Funcion para guardar el administrador en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreadmin']) ? $_POST['nombreadmin'] : false;
                $apellidos = isset($_POST['apellidosadmin']) ? $_POST['apellidosadmin'] : false;
                $fechaNacimiento = isset($_POST['fechaNacimientoadmin']) ? $_POST['fechaNacimientoadmin'] : false;
                $telefono = isset($_POST['telefonoadmin']) ? $_POST['telefonoadmin'] : false;
                $email = isset($_POST['emailadmin']) ? $_POST['emailadmin'] : false;
                $clave = isset($_POST['passwordadmin']) ? $_POST['passwordadmin'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre && $apellidos && $fechaNacimiento && $telefono && $clave && $email){

                    //Instanciar el objeto
                    $administrador = new Administrador();

                    //Crear el objeto
                    $administrador -> setNombre($nombre);
                    $administrador -> setApellido($apellidos);
                    $administrador -> setFechanacimiento($fechaNacimiento);
                    $administrador -> setNumerotelefono($telefono);
                    $administrador -> setCorreo($email);
                    $administrador -> setClave($clave);
                    $administrador -> setFecharegistro(date('y-m-d'));

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
                            if(!is_dir('Recursos/ImagenesAdministradores')){

                                //Crear el directorio
                                mkdir('Recursos/ImagenesAdministradores', 0777, true);
                            }

                            //Crear el objeto
                            $administrador -> setFoto($nombreArchivo);
                            //Mover la foto subida a la ruta temporal del servidor y luego a la de la carpeta de las imagenes
                            move_uploaded_file($archivo['tmp_name'], 'Recursos/ImagenesAdministradores/'.$nombreArchivo);

                            //Guardar en la base de datos
                            $guardado = $administrador -> guardar();

                            //Comprobar se ejecutó con exito la consulta
                            if($guardado){
                                $ingreso = $administrador->login();
                                //Crear sesion de inicio de sesion
                                $_SESSION['login_exitosoa'] = $ingreso;
                                $_SESSION['login_exitosoinfoa'] = "Bienvenido administrador";
                                //Redirigir al menu principal
                                header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                            }else{
                                //Crear sesion que indique que la ruta de correo ya esta en uso
                                $_SESSION['RegistroAdministrador'] = "Ya hay una ruta de correo en uso";
                                //Redirigir al registro de Administrador
                                header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=registroAdmin");
                            }
                        }else{
                            //Crear sesion que indique que la imagen debe ser de formato imagen
                            $_SESSION['RegistroAdministrador'] = "El formato debe ser de una imagen";
                            //Redirigir al registro de Administrador
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=registroAdmin");
                        }
                    }else{
                        //Crear Sesion que indique la seguridad y el tamaño que debe tener la contraseña que registra el Administrador
                        $_SESSION['ClavePocoSegura'] = "La clave debe contener una minuscula, una mayuscula, un caracterer especial, un numero y minimo 8 caracteres de longitud";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=registroAdmin");
                    }   
                }else{
                    //Crear sesion que indique que ha ocurrido un error inesperado al hacer el registro
                    $_SESSION['RegistroAdministrador'] = "Ha ocurrido un error al realizar el registro";
                    //Redirigir al registro de Administrador
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=registroAdmin");
                }
            }
        }

        /*
        Funcion para eliminar la cuenta del administrador de la base de datos
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idAdmin = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idAdmin){

                    //Instanciar el objeto
                    $administrador = new Administrador();

                    //Crear objeto
                    $administrador -> setId($idAdmin);

                    //Ejecutar la consulta
                    $eliminado = $administrador -> eliminar();

                    //Comprobar si el administrador ha sido eliminado exitosamente
                    if($eliminado){
                        //Crear Sesion que indique que el administrador se ha eliminado con exito
                        $_SESSION['admineliminado'] = "El administrador ha sido eliminado exitosamente";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        //Eliminar el inicio de sesion
                        Ayudas::eliminarSesion('login_exitosoa');
                    }else{
                        //Crear Sesion que indique que el administrador no se ha eliminado con exito
                        $_SESSION['admineliminado'] = "El administrador no ha sido eliminado exitosamente";
                        //Redirigir al formulario de registro
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=miPerfil");
                    }
                }  
            }
        }

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
            //Instanciar el objeto
            $categoria = new Categoria();
            //Listar todas las categorias desde la base de datos
            $listadoCategorias = $categoria -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionCategorias.html";
        }

        /*
        Funcion para gestionar las tarjetas
        */

        public function gestionarTarjeta(){
            //Instanciar el objeto
            $tarjeta = new Tarjeta();
            //Listar todas las tarjetas desde la base de datos
            $listadoTarjetas = $tarjeta -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionTarjetas.html";
        }

        /*
        Funcion para gestionar los usos
        */

        public function gestionarUso(){
            //Instanciar el objeto
            $uso = new Uso();
            //Listar todos los usos desde la base de datos
            $listadoUsos = $uso -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionUsos.html";
        }

        /*
        Funcion para gestionar las consolas
        */

        public function gestionarConsola(){
            //Instanciar el objeto
            $consola = new Consola();
            //Listar todas las consolas desde la base de datos
            $listadoConsolas = $consola -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionConsolas.html";
        }

        /*
        Funcion para crear un estado
        */

        public function gestionarEstado(){
            //Instanciar el objeto
            $estado = new Estado();
            //Listar todos los estados desde la base de datos
            $listadoEstados = $estado -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionEstados.html";
        }

        /*
        Funcion para eliminar un usuario desde el administrador
        */

        public function eliminarUsuario(){
            
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
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que el usuario no se ha eliminado con exito
                        $_SESSION['usuarioeliminado'] = "El usuario no ha sido eliminado exitosamente";
                        //Redirigir a la gestion de usuarios
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=gestionarUsuario");
                    }
                }  
            }
        }

        /*
        Funcion para actualizar un administrador
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $clave = isset($_POST['password']) ? $_POST['password'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;

                //Si el dato existe
                if($id && $nombre && $apellidos && $email && $clave && $telefono){

                    //Instanciar el objeto
                    $administrador = new Administrador();

                    //Crear objeto
                    $administrador -> setId($id);
                    $administrador -> setNombre($nombre);
                    $administrador -> setApellido($apellidos);
                    $administrador -> setCorreo($email);
                    $administrador -> setClave($clave);
                    $administrador -> setNumerotelefono($telefono);

                    //Ejecutar la consulta
                    $actualizado = $administrador -> actualizar();

                    //Comprobar si el administrador ha sido actualizado
                    if($actualizado){
                        //Crear Sesion que indique que el administrador se ha actualizado con exito
                        $_SESSION['adminactualizado'] = "El administrador ha sido actualizado exitosamente";
                        //Redirigir al inicio
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
                    }else{
                        //Crear Sesion que indique que el administrador no se ha actualizado con exito
                        $_SESSION['adminactualizado'] = "Proporciona nuevos datos";
                        //Redirigir a la gestion de categorias
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=miPerfil");
                    }
                }else{
                    //Crear Sesion que indique que el administrador no se ha actualizado con exito
                    $_SESSION['adminactualizado'] = "Ha ocurrido un error al actualizar el administrador";
                    //Redirigir a la gestion de categorias
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=miPerfil");
                } 
            }
        }
    }
?>