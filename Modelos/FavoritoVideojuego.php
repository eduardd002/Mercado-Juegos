<?php

    /*
    Clase modelo de favorito videojuego
    */

    class FavoritoVideojuego{

        private $id;
        private $activo;
        private $idVideojuego;
        private $idFavorito;
        private $precio;
        private $db;

        /*
        Funcion constructor
        */

        public function __construct(){
            /*Llamar conexion a la base de datos*/  
            $this -> db = BaseDeDatos::connect();
        }

        /*
        Funcion getter de id
        */

        public function getId(){
            /*Retornar el resultado*/
            return $this->id;
        }

        /*
        Funcion setter de id
        */

        public function setId($id){
            /*Llamar parametro*/
            $this->id = $id;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de activo
        */

        public function getActivo(){
            /*Retornar el resultado*/
            return $this->activo;
        }

        /*
        Funcion setter de activo
        */

        public function setActivo($activo){
            /*Llamar parametro*/
            $this->activo = $activo;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id videojuego
        */

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        /*
        Funcion setter de id videojuego
        */

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        /*
        Funcion getter de id favorito
        */

        public function getIdFavorito(){
            return $this->idFavorito;
        }

        /*
        Funcion setter de id favorito
        */

        public function setIdFavorito($idFavorito){
            $this->idFavorito = $idFavorito;
            return $this;
        }

        /*
        Funcion getter de precio
        */

        public function getPrecio(){
            return $this->precio;
        }

        /*
        Funcion setter de precio
        */

        public function setPrecio($precio){
            $this->precio = $precio;
            return $this;
        }

        /*
        Funcion para guardar la relacion entre videojuego y favorito en la base de datos
        */

        public function guardar(){
            /*Construir consulta*/
            $consulta = "INSERT INTO videojuegofavorito VALUES(NULL, {$this -> getActivo()}, 
                {$this -> getIdVideojuego()}, {$this -> getIdFavorito()}, 
                {$this -> getPrecio()})";
            /*Llamar la funcion que ejecuta la consulta*/
            $registro = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $resultado = false;
            /*Comprobar si la consulta fue exitosa y el total de columnas afectadas se altero llamando la ejecucion de la consulta*/
            if($registro && mysqli_affected_rows($this -> db) > 0){
                /*Cambiar el estado de la variable bandera*/
                $resultado = true;
            }
            /*Retornar el resultado*/
            return $resultado;
        }

    }

?>