<?php

    //Incluir el autoload y tener acceso a los objetos
    require 'vendor/autoload.php';

    //Utilzar la libreria para importar los archivos en formato PDF
    use Spipu\Html2Pdf\Html2Pdf;

    class Ayudas{

        /*
        Funcion para generar archivo en formato PDF
        */

        public static function pdf(){

            /*Crear instancia del objeto*/
            $html2pdf = new Html2Pdf();

            /*OBS_START(); para */
            ob_start();
            /*OBS_START(); para */
            ob_end_clean();
            /*Incluir la vista que contiene la informacion que se quiere pasar a formato PDF*/
            require_once 'Vistas/Compra/Factura.html';
            //Conseguir todo el codigo html que hay dentro de un archivo de PHP
            $html = ob_get_clean();

            //Escribir el HTML
            $html2pdf->writeHTML($html);

            /*OBS_START(); para */
            ob_clean();
            //Exportar el HTML a un PDF, OUTPUT('nombre que se quiere sacar.pdf');
            $html2pdf->output('Compra.pdf');
        }

        /*
        Funcion para listar todas las categorias en la pantalla principal de inicio
        */

        public static function mostrarCategorias(){

            //Incluir el objeto de categoria
            require_once 'Modelos/Categoria.php';
            //Instanciar el objeto
            $categoria = new Categoria();
            //Listar todos los usuarios desde la base de datos
            $listadoCategorias = $categoria -> listar();
            //Retornar el resultado
            return $listadoCategorias;
        }

        /*
        Funcion para listar los datos del usuario
        */

        public static function mostrarDatosUsuario(){
            if(isset($_SESSION['loginexitoso'])){
                //Incluir el objeto de categoria
                require_once 'Modelos/Usuario.php';
                //Instanciar el objeto
                $usuario = new Usuario();
                //Crear objeto
                $usuario -> setId($_SESSION['loginexitoso'] -> id);
                //Listar todos los usuarios desde la base de datos
                $datos = $usuario -> obtenerUno();
                //Retornar el resultado
                return $datos;
            }
        }

        /*
        Funcion para listar los datos del administrador
        */

        public static function mostrarDatosAdministrador(){
            if(isset($_SESSION['loginexitosoa'])){
                //Incluir el objeto de categoria
                require_once 'Modelos/Administrador.php';
                //Instanciar el objeto
                $administrador = new Administrador();
                //Crear objeto
                $administrador -> setId($_SESSION['loginexitosoa'] -> id);
                //Listar todos los usuarios desde la base de datos
                $datos = $administrador -> obtenerUno();
                //Retornar el resultado
                return $datos;
            }
        }

        /*
        Funcion para eliminar sesiones
        */

        public static function eliminarSesion($nombreSesion){
            //Comprobar si la sesion existe
            if(isset($_SESSION[$nombreSesion])){
                //Eliminar sesion
                unset($_SESSION[$nombreSesion]);
            }
        }
        
        /*
        Funcion para comprobar que la contraseña sea segura, cumpliendo ciertos parametros establecidos
        */

        public static function comprobarContrasenia($clave){

            //Verificar que se cumplan todas las funciones
            if (strlen($clave) >= 8 && preg_match("/[a-z]/", $clave) && preg_match("/[A-Z]/", $clave) && preg_match("/[0-9]/", $clave)) {
                return true;
            }else{
                return false;
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran acceder a funciones
        de usuario logueado
        */

        public static function restringirAUsuario($seccion){
            //Verificar que el inicio de sesion no exista
            if(!isset($_SESSION['loginexitoso'])){
                //Redirigir
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                //Crear sesion con contenido informativo al usuario
                $_SESSION['iniciodesesion'] = "Debes iniciar sesion primero";
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran comentar un
        videojuego en particular
        */

        public static function restringirAUsuarioAlComentar($seccion, $idVideojuego){
            //Verificar que el inicio de sesion no exista
            if(!isset($_SESSION['loginexitoso'])){
                //Redirigir
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                //Crear sesion con contenido informativo al usuario
                $_SESSION['comentariopendiente'] = "Por favor inicia sesion antes de comentar";
                //Crear sesion con id de videojuego que se quiere comentar
                $_SESSION['idvideojuegopendientecomentario'] = $idVideojuego;
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran agregar un
        videojuego a favoritos
        */

        public static function restringirAUsuarioAlAgregarFavorito($seccion, $idVideojuego){
            //Verificar que el inicio de sesion no exista
            if(!isset($_SESSION['loginexitoso'])){
                //Redirigir
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                //Crear sesion con contenido informativo al usuario
                $_SESSION['favoritopendiente'] = "Por favor inicia sesion antes de agregar a favoritos";
                //Crear sesion con id de videojuego que se quiere comentar
                $_SESSION['idvideojuegopendientefavorito'] = $idVideojuego;
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran acceder a funciones
        de adminstrador logueado
        */

        public static function restringirAAdministrador(){
            //Verificar que el inicio de sesion no exista
            if(!isset($_SESSION['loginexitosoa'])){
                //Redirigir al inicio
                header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=login");
            }
        }

        /*
        Funcion para crear sesiones y redigirir a paginas
        */

        public static function crearSesionYRedirigir($nombreSesion, $contenidoSesion, $ruta){
            //Crear sesion
            $_SESSION[$nombreSesion] = $contenidoSesion;
            //Redirigir
            header("Location:"."http://localhost/Mercado-Juegos/".$ruta);
        }

        /*
        Funcion para comprobar el tipo de un archivo
        */

        public static function comprobarImagen($archivo){
            if($archivo == "image/jpg" || $archivo == "image/jpeg" || $archivo == "image/png" || $archivo == "image/gif"){
                return 1;
            }else if($archivo == ''){
                return 2;
            }else{
                return 3;
            }
        }

        /*
        Funcion para guardar la imagen del administrador en los archivos
        */

        public static function guardarImagen($archivo, $carpetaGuardada){

            $nombreArchivo = null;

            if(isset($archivo)){

                //Extraer el tipo de archivo de la imagen
                $tipoArchivo = $archivo['type'];

                //Comprobar si el archivo tiene la extensión de una imagen
                if(Ayudas::comprobarImagen($tipoArchivo) == 1){
                    //Extraer nombre del archivo de imagen
                    $nombreArchivo = $archivo['name'];

                    //Comprobar si no existe un directorio para las imagenes a subir
                    if(!is_dir('Recursos/'.$carpetaGuardada)){

                        //Crear el directorio
                        mkdir('Recursos/'.$carpetaGuardada, 0777, true);
                    }

                    //Mover la foto subida a la ruta temporal del servidor y luego a la de la carpeta de las imagenes
                    move_uploaded_file($archivo['tmp_name'], 'Recursos/'.$carpetaGuardada.'/'.$nombreArchivo);
                }
            }
            return $nombreArchivo;
        }
    }
?>