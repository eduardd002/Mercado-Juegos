<?php

//Cargar el autoload y tener acceso a los objetos

require 'vendor/autoload.php';

//Utilzar la libreria

use Spipu\Html2Pdf\Html2Pdf;

class GenerarPdf{

    public static function pdf(){

        $html2pdf = new Html2Pdf();

        #Generado con texto
        #$html = "Eduardo Cortes";

        //Conseguir todo el codigo html que hay dentro de un archivo de PHP
        ob_start();
        ob_end_clean();
        require_once 'Vistas/Compra/Factura.html';
        $html = ob_get_clean();

        //Escribir el HTML

        $html2pdf->writeHTML($html);

        //Exportar el HTML a un PDF, OUTPUT('nombre que se quiere sacar.pdf');
        ob_clean();
        $html2pdf->output('Compra.pdf');
    }
}
