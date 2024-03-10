<?php

    class VideojuegoCategoria{

        private $id;
        private $idVideojuego;
        private $categoriaId;
        private $db;

        public function __construct(){
            $this -> db = BaseDeDatos::connect();
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        public function getCategoriaId(){
            return $this->categoriaId;
        }

        public function setCategoriaId($categoriaId){
            $this->categoriaId = $categoriaId;
            return $this;
        }

        /*
        Funcion para guardar la relacion entre videojuego y categoria en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            foreach($this -> getCategoriaId() as $categorias){
                $consulta = "INSERT INTO videojuegocategoria VALUES(NULL, {$this -> getIdVideojuego()}, {$categorias})";
                //Ejecutar la consulta
                $registro = $this -> db -> query($consulta);
            }
            //Establecer una variable bandera
            $resultado = false;
            //Comprobar el registro fue exitoso y el total de columnas afectadas se altero
            if($registro){
                //Cambiar el estado de la variable bandera
                $resultado = true;
            }
            //Retornar el resultado
            return $resultado;
        }
    }

?>