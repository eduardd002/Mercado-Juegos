<?php

    class VideojuegoController{

        /*
        Funcion para listar algunos videojuegos en la pantalla de inicio
        */

        public function inicio(){
            
            //Cargar la vista
            require_once 'Vistas/Layout/Catalogo.html';

        }

        /*
        Funcion para ver el detalle del videojuego
        */

        public function detalle(){

            //Cargar la vista
            require_once 'Vistas/Videojuego/Detalle.html';
        }

        /*
        Funcion para crear un videojuego
        */

        public function crear(){

            //Cargar la vista
            require_once 'Vistas/Videojuego/Crear.html';
        }

        /*
        Funcion para buscar un videojuego en concreto
        */

        public function buscar(){

            //Cargar la vista
            require_once 'Vistas/Videojuego/Buscar.html';
        }

        /*
        Funcion para actualizar un videojuego
        */

        public function actualizar(){

            //Cargar la vista
            require_once 'Vistas/Videojuego/Actualizar.html';
        }

        /*
        Funcion para eliminar un videojuego
        */

        public function eliminar(){
            
        }

        /*
        Funcion para listar todos los videojuegos en la pantalla de inicio
        */

        public function todos(){

            //Cargar la vista
            require_once 'Vistas/Videojuego/Todos.html';
        }

    }

?>