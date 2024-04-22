<?php

    /*
    Clase de archivo de ayudas
    */

    /*Incluir el autoload y tener acceso a los objetos*/
    require 'vendor/autoload.php';

    /*Utilzar la libreria para importar los archivos en formato PDF*/
    use Spipu\Html2Pdf\Html2Pdf;

    class Ayudas{

        /*
        Funcion para encriptar datos
        */

        public static function encriptarContenido($contenido){
            /*Encriptar el mensaje*/
            $mensajeEncriptado = openssl_encrypt($contenido, 'aes-256-cbc', claveEncriptacion, 0, '1234567890123456');
            /*Retornar el resultado*/
            return $mensajeEncriptado;
        }

        /*
        Funcion para desencriptar datos
        */

        public static function desencriptarContenido($contenido){
            /*Encriptar el mensaje*/
            $mensajeDesencriptado = openssl_decrypt($contenido, 'aes-256-cbc', claveEncriptacion, 0, '1234567890123456');
            /*Retornar el resultado*/
            return $mensajeDesencriptado;
        }

        /*
        Funcion para generar archivo en formato PDF
        */

        public static function pdf($detalle){
            /*Crear instancia del objeto*/
            $html2pdf = new Html2Pdf();
            /*Capturar la salida del buffer de salida*/
            ob_start();
            /*Descartar el contenido del buffer de salida*/
            ob_end_clean();
            /*Incluir la vista que contiene la informacion que se quiere pasar a formato PDF*/
            require_once 'Vistas/Compra/Factura.html';
            /*Conseguir todo el codigo html que hay dentro de un archivo de PHP*/
            $html = ob_get_clean();
            /*Escribir el HTML*/
            $html2pdf->writeHTML($html);
            /*Limpiar el contenido del buffer de salida*/
            ob_clean();
            /*Exportar el HTML a un PDF*/
            $html2pdf->output('Compra.pdf');
        }

        /*
        Funcion para comprobar si existe un inicio de sesion de usuario
        */

        public static function comprobarInicioDeSesionUsuario(){
            /*Comprobar si hay un inicio de sesion de usuario*/
            if(isset($_SESSION['loginexitoso'])){
                /*Retornar el resultado*/
                return true;
            }
        }

        /*
        Funcion para listar todas las categorias en el apartado de filtro
        */

        public static function mostrarCategorias(){
            /*Incluir el objeto de categoria*/
            require_once 'Modelos/Categoria.php';
            /*Instanciar el objeto*/
            $categoria = new Categoria();
            /*Listar todos los usuarios desde la base de datos*/
            $listadoCategorias = $categoria -> listar();
            /*Retornar el resultado*/
            return $listadoCategorias;
        }

        /*
        Funcion para listar todos los usos en el apartado de filtro
        */

        public static function mostrarUsos(){
            /*Incluir el objeto de categoria*/
            require_once 'Modelos/Uso.php';
            /*Instanciar el objeto*/
            $uso = new Uso();
            /*Listar todos los usuarios desde la base de datos*/
            $listadoUsos = $uso -> listar();
            /*Retornar el resultado*/
            return $listadoUsos;
        }

        /*
        Funcion para listar todas las consolas en el apartado de filtro
        */

        public static function mostrarConsolas(){
            /*Incluir el objeto de categoria*/
            require_once 'Modelos/Consola.php';
            /*Instanciar el objeto*/
            $consola = new Consola();
            /*Listar todos los usuarios desde la base de datos*/
            $listadoConsolas = $consola -> listar();
            /*Retornar el resultado*/
            return $listadoConsolas;
        }

        /*
        Funcion para listar los datos del usuario
        */

        public static function mostrarDatosUsuario(){
            /*Comprobar si hay un inicio de sesion de usuario*/
            if(isset($_SESSION['loginexitoso'])){
                /*Incluir el objeto de categoria*/
                require_once 'Modelos/Usuario.php';
                /*Instanciar el objeto*/
                $usuario = new Usuario();
                /*Crear el objeto*/
                $usuario -> setId($_SESSION['loginexitoso'] -> id);
                /*Listar todos los usuarios desde la base de datos*/
                $datos = $usuario -> obtenerUno();
                /*Retornar el resultado*/
                return $datos;
            }
        }

        /*
        Funcion para listar los datos del administrador
        */

        public static function mostrarDatosAdministrador(){
            /*Comprobar si hay un inicio de sesion de administrador*/
            if(isset($_SESSION['loginexitosoa'])){
                /*Incluir el objeto de categoria*/
                require_once 'Modelos/Administrador.php';
                /*Instanciar el objeto*/
                $administrador = new Administrador();
                /*Crear el objeto*/
                $administrador -> setId($_SESSION['loginexitosoa'] -> id);
                /*Listar todos los usuarios desde la base de datos*/
                $datos = $administrador -> obtenerUno();
                /*Retornar el resultado*/
                return $datos;
            }
        }

        /*
        Funcion para eliminar sesiones
        */

        public static function eliminarSesion($nombreSesion){
            /*Comprobar si la sesion existe*/
            if(isset($_SESSION[$nombreSesion])){
                /*Eliminar sesion*/
                unset($_SESSION[$nombreSesion]);
            }
        }
        
        /*
        Funcion para comprobar que la contraseña sea segura, cumpliendo ciertos parametros establecidos
        */

        public static function comprobarContrasenia($clave){
            /*Verificar que se cumplan todas las funciones de clave*/
            if (strlen($clave) >= 8 && preg_match("/[a-z]/", $clave) && preg_match("/[A-Z]/", $clave) && preg_match("/[0-9]/", $clave)) {
                /*Retornar el resultado*/
                return true;
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran acceder a funciones
        de usuario logueado
        */

        public static function restringirAUsuario($seccion){
            /*Verificar que el inicio de sesion de usuario no exista*/
            if(!isset($_SESSION['loginexitoso'])){
                /*Redirigir*/
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                /*Crear sesion con contenido informativo al usuario*/
                $_SESSION['iniciodesesion'] = "Debes iniciar sesion primero";
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran comentar un
        videojuego en particular
        */

        public static function restringirAUsuarioAlComentar($seccion, $idVideojuego){
            /*Verificar que el inicio de sesion de usuario no exista*/
            if(!isset($_SESSION['loginexitoso'])){
                /*Redirigir*/
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                /*Crear sesion con contenido informativo al usuario*/
                $_SESSION['comentariopendiente'] = "Por favor inicia sesion antes de comentar";
                /*Crear sesion con id de videojuego que se quiere comentar*/
                $_SESSION['idvideojuegopendientecomentario'] = $idVideojuego;
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran agregar un
        videojuego a favoritos
        */

        public static function restringirAUsuarioAlAgregarFavorito($seccion){
            /*Verificar que el inicio de sesion de usuario no exista*/
            if(!isset($_SESSION['loginexitoso'])){
                /*Redirigir*/
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                /*Crear sesion con contenido informativo al usuario*/
                $_SESSION['favoritopendiente'] = "Por favor inicia sesion antes de agregar a favoritos";
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran acceder a funciones
        de adminstrador logueado
        */

        public static function restringirAAdministrador(){
            /*Verificar que el inicio de sesion de administrador no exista*/
            if(!isset($_SESSION['loginexitosoa'])){
                /*Redirigir al inicio*/
                header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=login");
            }
        }

        /*
        Funcion para crear sesiones y redigirir a paginas
        */

        public static function crearSesionYRedirigir($nombreSesion, $contenidoSesion, $ruta){
            /*Crear sesion*/
            $_SESSION[$nombreSesion] = $contenidoSesion;
            /*Redirigir*/
            header("Location:"."http://localhost/Mercado-Juegos/".$ruta);
        }

        /*
        Funcion para comprobar el tipo de un archivo
        */

        public static function comprobarImagen($archivo){
            /*Comprobar si el archivo cumple las condiciones de formato de imagen*/
            if($archivo == "image/jpg" || $archivo == "image/jpeg" || $archivo == "image/png" || $archivo == "image/gif"){
                /*Retornar el resultado*/
                return 1;
            /*Comprobar si el archivo esta vacio*/
            }else if($archivo == ''){
                /*Retornar el resultado*/
                return 2;
            /*De lo contrario*/
            }else{
                /*Retornar el resultado*/
                return 3;
            }
        }

        /*
        Funcion para guardar la imagen del administrador en los archivos
        */

        public static function guardarImagen($archivo, $carpetaGuardada){
            /*Comprobar si existe el archivo o este llega*/
            if(isset($archivo)){
                /*Extraer el tipo de archivo de la imagen*/
                $tipoArchivo = $archivo['type'];
                /*Comprobar si el archivo tiene la extensión de una imagen*/
                if(Ayudas::comprobarImagen($tipoArchivo) == 1){
                    /*Extraer nombre del archivo de imagen*/
                    $nombreArchivo = $archivo['name'];
                    /*Comprobar si no existe un directorio para las imagenes a subir*/
                    if(!is_dir('Recursos/'.$carpetaGuardada)){
                        /*Crear el directorio*/
                        mkdir('Recursos/'.$carpetaGuardada, 0777, true);
                    }
                    /*Mover la foto subida a la ruta temporal del servidor y luego a la de la carpeta de las imagenes*/
                    move_uploaded_file($archivo['tmp_name'], 'Recursos/'.$carpetaGuardada.'/'.$nombreArchivo);
                }
            }
            /*Retornar el resultado*/
            return $nombreArchivo;
        }

        /*
        Funcion para establecer el login de usuario
        */

        public static function loginUsuario($correo, $clave){
            /*Instanciar el objeto*/
            $usuario = new Usuario();
            /*Crear el objeto*/
            $usuario -> setCorreo($correo);
            $usuario -> setClave($clave);
            /*Obtener el resultado*/
            $ingreso = $usuario->login();
            /*Retornar el resultado*/
            return $ingreso;
        }

        /*
        Funcion para establecer el login de administrador
        */

        public static function loginAdministrador($correo, $clave){
            /*Instanciar el objeto*/
            $administrador = new Administrador();
            /*Crear el objeto*/
            $administrador -> setCorreo($correo);
            $administrador -> setClave($clave);
            /*Obtener el resultado*/
            $ingreso = $administrador->login();
            /*Retornar el resultado*/
            return $ingreso;
        }

        /*
        Funcion para iniciar sesion con el usuario guardado
        */

        public static function iniciarSesionUsuario($correo, $clave){
            /*Lamar la funcion que contiene la informacion del login del usuario*/
            $ingreso = Ayudas::loginUsuario($correo, $clave);
            /*Comprobar si el ingreso es exitoso*/
            if($ingreso){
                /*Crear la sesion con el perfil del usuario*/
                $_SESSION['loginexitoso'] = $ingreso;
                /*Crear la sesion y redirigir*/
                Ayudas::crearSesionYRedirigir('loginexitosoinfo', "Bienvenido usuario", "?controller=VideojuegoController&action=inicio");
            }
        }

        /*
        Funcion para iniciar sesion con el administrador guardado
        */

        public static function iniciarSesionAdmnistrador($correo, $clave){
            /*Lamar la funcion que contiene la informacion del login del administrador*/
            $ingreso = Ayudas::loginAdministrador($correo, $clave);
            /*Comprobar si el ingreso es exitos*/
            if($ingreso){
                /*Crear la sesion con el perfil del administrador*/
                $_SESSION['loginexitosoa'] = $ingreso;
                /*Crear la sesion y redirigir*/
                Ayudas::crearSesionYRedirigir('loginexitosoinfoa', "Bienvenido administrador", "?controller=AdministradorController&action=administrar");
            }
        }

        /*
        Funcion para iniciar sesion
        */

        public static function iniciarSesion($email, $clave){
            /*Lamar las funciones que contiene la informacion del login del usuario y administrador*/
            $ingresoa = Ayudas::loginAdministrador($email, $clave);
            $ingreso = Ayudas::loginUsuario($email, $clave);
            /*Comprobar si el ingreso del usuario es exitoso*/
            if($ingreso && is_object($ingreso)){
                /*Crear la sesiones con el objeto completo del usuario e informacion referente*/
                $_SESSION['loginexitoso'] = $ingreso;
                $_SESSION['loginexitosoinfo'] = "Bienvenido Usuario";
                /*Comprobar si se quiere hacer un comentario sin estar previemente logueado*/
                if(isset($_SESSION['comentariopendiente'])){
                   /*Redirigir al comentario pendiente*/
                   header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=".$_SESSION['idvideojuegopendientecomentario']);
                   /*Eliminar las sesiones una vez se haya informado y hecho los procesos correspondientes*/
                   Ayudas::eliminarSesion('comentariopendiente');
                   Ayudas::eliminarSesion('idvideojuegopendientecomentario');
                /*Comprobar si se quiere agregar un videojuego a favoritos sin estar previemente logueado*/
                }else if(isset($_SESSION['favoritopendiente'])){
                    /*Comprobar si la solicitud viene desde el catalogo*/
                    if(isset($_SESSION['catalogofavorito'])){    
                        /*Redirigir al lugar requerido*/
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio"); 
                        /*Eliminar las sesiones una vez se haya informado y hecho los procesos correspondientes*/
                        Ayudas::eliminarSesion('catalogofavorito');
                        /*Comprobar si existe la sesion de catalogo favorito*/
                    }else if(isset($_SESSION['catalogofavoritot'])){
                        /*Redirigir al lugar requerido*/
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=todos"); 
                        /*Eliminar las sesiones una vez se haya informado y hecho los procesos correspondientes*/
                        Ayudas::eliminarSesion('catalogofavoritot');
                    }
                    /*Comprobar si la solicitud viene desde el detalle del videojuego*/
                    else{
                        /*Redirigir al lugar requerido*/
                        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=detalle&id=".$_SESSION['idvideojuegopendientefavorito']);
                        /*Eliminar las sesiones una vez se haya informado y hecho los procesos correspondientes*/
                        Ayudas::eliminarSesion('idvideojuegopendientefavorito');
                    }
                    /*Eliminar las sesiones una vez se haya informado y hecho los procesos correspondientes*/
                    Ayudas::eliminarSesion('favoritopendiente');
                /*De lo contrario*/    
                }else{
                    /*Redirigir al inicio*/
                    header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                }
            /*Comprobar si el ingreso del administrador es exitoso*/
            }else if($ingresoa && is_object($ingresoa)){
                /*Crear la sesion con el objeto completo del administrador*/
                $_SESSION['loginexitosoa'] = $ingresoa;
                $_SESSION['loginexitosoinfoa'] = "Bienvenido administrador";
                /*Redirigir al inicio*/
                header("Location:"."http://localhost/Mercado-Juegos/?controller=AdministradorController&action=administrar");
            /*De lo contrario*/    
            }else{
                /*Crear la sesion de error al realizar el login*/
                $_SESSION['error_login'] = 'Este usuario no se encuentra registrado';
                /*Redirigir al login*/
                header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=login");
            }
        }

        /*
        Funcion para traer un usuario en concreto
        */

        public static function obtenerUsuarioEnConcreto($id){
            /*Incluir el objeto de chat*/
            require_once 'Modelos/Usuario.php';
            /*instanciar el objeto*/
            $usuario = new Usuario();
            /*Construir objeto*/
            $usuario -> setId($id);
            /*Obtener resultado*/
            $usuarioObtenido = $usuario -> obtenerUno();
            /*Retornar resultado*/
            return $usuarioObtenido;
        }

        /*
        Funcion para traer un videojuego en concreto
        */

        public static function obtenerVideojuegoEnConcreto($id){
            /*Incluir el objeto de chat*/
            require_once 'Modelos/Videojuego.php';
            /*instanciar el objeto*/
            $videojuego = new Videojuego();
            /*Construir objeto*/
            $videojuego -> setId($id);
            /*Obtener resultado*/
            $videojuegoObtenido = $videojuego -> traerUno();
            /*Retornar resultado*/
            return $videojuegoObtenido;
        }
        
    }

?>