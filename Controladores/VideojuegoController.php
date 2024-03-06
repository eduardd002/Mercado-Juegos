<?php

    //Incluir el objeto de videojuego
    require_once 'Modelos/Videojuego.php';

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    //Incluir el objeto de uso
    require_once 'Modelos/Uso.php';

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

            //Instanciar el objeto
            $categoria = new Categoria();
            //Listar todos los usuarios desde la base de datos
            $listadoCategorias = $categoria -> listar();

            //Instanciar el objeto
            $uso = new Uso();
            //Listar todos los usuarios desde la base de datos
            $listadoUsos = $uso -> listar();

            //Instanciar el objeto
            $consola = new Consola();
            //Listar todos los usuarios desde la base de datos
            $listadoConsolas = $consola -> listar();

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