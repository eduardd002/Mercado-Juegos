<?php

    class VentaController{
        
        /*
        Funcion para ver el detalle de la venta realizada
        */

        public function ver(){
            
            //Cargar la vista
            require_once "Vistas/Venta/Detalle.html";
        }

    }

?>