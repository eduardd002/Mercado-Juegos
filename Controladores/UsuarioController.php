<?php

    class UsuarioController{

        /*
        Funcion para realizar el registro del usuario
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
        Funcion para ver el perfil
        */

        public function perfil(){

            //Cargar la vista

            require_once "Vistas/Usuario/Perfil.html";
        }

        public function miPerfil(){

            //Cargar la vista

            require_once "Vistas/Usuario/miPerfil.html";
        }

                /*
        Funcion para ver el perfil
        */

        public function compras(){

            //Cargar la vista

            require_once "Vistas/Usuario/Compras.html";
        }

                /*
        Funcion para ver el perfil
        */

        public function ventas(){

            //Cargar la vista

            require_once "Vistas/Usuario/Ventas.html";
        }

                        /*
        Funcion para ver el perfil
        */

        public function videojuegos(){

            //Cargar la vista

            require_once "Vistas/Usuario/Videojuegos.html";
        }

    }

?>