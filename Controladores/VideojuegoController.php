<?php

    class VideojuegoController{

        /*
        En esta funcion de listaran algunos de los videojuegos
        */

        public function inicio(){
            
            //Renderizar la vista

            require_once 'Vistas/Layout/Catalogo.html';

        }

        public function detalle(){
            //Renderizar la vista

            require_once 'Vistas/Videojuego/Detalle.html';
        }

    }

?>