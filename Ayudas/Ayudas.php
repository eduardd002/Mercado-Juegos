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
        Funcion para eliminar sesiones
        */

        public static function eliminarSesion($nombreSesion){
            if(isset($_SESSION[$nombreSesion])){
                unset($_SESSION[$nombreSesion]);
            }
        }
    }
?>