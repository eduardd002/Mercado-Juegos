<?php

    class ErrorController{

        /*
        Funcion para controlar la vista al ingresar una url no existente
        */

        public function index(){

            //Cargar la vista
            require_once "Vistas/Error/Error.html";
        }

    }

?>