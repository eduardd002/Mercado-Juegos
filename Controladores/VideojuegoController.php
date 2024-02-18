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

        public function crear(){
            //Renderizar la vista

            require_once 'Vistas/Videojuego/Crear.html';
        }

        public function buscar(){
            //Renderizar la vista

            require_once 'Vistas/Videojuego/Buscar.html';
        }

        public function actualizar(){
            //Renderizar la vista

            require_once 'Vistas/Videojuego/Actualizar.html';
        }

        public function eliminar(){
            
        }

    }

?>