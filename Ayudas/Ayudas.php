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
            if(isset($_SESSION['login_exitoso'])){
                //Incluir el objeto de categoria
                require_once 'Modelos/Usuario.php';
                //Instanciar el objeto
                $usuario = new Usuario();
                //Crear objeto
                $usuario -> setId($_SESSION['login_exitoso'] -> id);
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
            if(isset($_SESSION['login_exitosoa'])){
                //Incluir el objeto de categoria
                require_once 'Modelos/Administrador.php';
                //Instanciar el objeto
                $administrador = new Administrador();
                //Crear objeto
                $administrador -> setId($_SESSION['login_exitosoa'] -> id);
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
            if(isset($_SESSION[$nombreSesion])){
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
            if(!isset($_SESSION['login_exitoso'])){
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
            if(!isset($_SESSION['login_exitoso'])){
                //Redirigir
                header("Location:"."http://localhost/Mercado-Juegos/".$seccion);
                //Crear sesion con contenido informativo al usuario
                $_SESSION['comentariopendiente'] = "Por favor inicia sesion antes de comentar";
                //Crear sesion con id de videojuego que se quiere comentar
                $_SESSION['idvideojuegopendientecomentario'] = $idVideojuego;
            }
        }

        /*
        Funcion para redirigir a inicio cuando no se este logueado y se quieran acceder a funciones
        de usuario logueado
        */

        public static function restringirAAdministrador(){
            //Verificar que el inicio de sesion no exista
            if(!isset($_SESSION['login_exitosoa'])){
                //Redirigir al inicio
                header("Location:"."http://localhost/Mercado-Juegos/?controller=UsuarioController&action=login");
            }
        }
    }
?>