<?php

    //Incluir el objeto de videojuego
    require_once 'Modelos/Videojuego.php';

    class VideojuegoController{

        /*
        Funcion para listar algunos videojuegos en la pantalla de inicio
        */

        public function inicio(){
            
            //Incluir la vista
            require_once 'Vistas/Layout/Catalogo.html';

        }

        /*
        Funcion para ver el detalle del videojuego
        */

        public function detalle(){

            //Incluir la vista
            require_once 'Vistas/Videojuego/Detalle.html';
        }

        /*
        Funcion para crear un videojuego
        */

        public function crear(){

            //Incluir la vista
            require_once 'Vistas/Videojuego/Crear.html';
        }

        /*
        Funcion para buscar un videojuego en concreto
        */

        public function buscar(){

            //Incluir la vista
            require_once 'Vistas/Videojuego/Buscar.html';
        }

        /*
        Funcion para actualizar un videojuego
        */

        public function actualizar(){

            //Incluir la vista
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

            //Incluir la vista
            require_once 'Vistas/Videojuego/Todos.html';
        }

        /*
        Funcion para guardar el videojuego en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                foreach($_POST['categorias'] as $lista){
                    echo $lista;
                }

            }
        }

    }

?>