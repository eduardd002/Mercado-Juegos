<?php

    class UsuarioController{

        /*
        Funcion para realizar el inicio de sesion del usuario
        */

        public function login(){

            //Cargar la vista
            require_once "Vistas/Usuario/Login.html";
        }

        /*
        Funcion para realizar el registro del usuario
        */

        public function registro(){

            //Cargar la vista
            require_once "Vistas/Usuario/Registro.html";
        }

        /*
        Funcion para ver el perfil de un usuario
        */

        public function perfil(){

            //Cargar la vista
            require_once "Vistas/Usuario/Perfil.html";
        }

        /*
        Funcion para ver el perfil del usuario indentificado
        */

        public function miPerfil(){

            //Cargar la vista
            require_once "Vistas/Usuario/miPerfil.html";
        }

        /*
        Funcion para ver el listado de compras realizadas por el usuario
        */

        public function compras(){

            //Cargar la vista
            require_once "Vistas/Usuario/Compras.html";
        }

        /*
        Funcion para ver el listado de ventas realizadas por el usuario
        */

        public function ventas(){

            //Cargar la vista
            require_once "Vistas/Usuario/Ventas.html";
        }

        /*
        Funcion para ver los videojuegos creados por el usuario indentificado
        */

        public function videojuegos(){

            //Cargar la vista
            require_once "Vistas/Usuario/Videojuegos.html";
        }

    }

?>