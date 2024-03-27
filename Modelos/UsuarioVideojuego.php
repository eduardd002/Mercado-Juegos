<?php

    class UsuarioVideojuego{

        private $id;
        private $idUsuario;
        private $idVideojuego;
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

        public function getIdUsuario(){
            return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario){
            $this->idUsuario = $idUsuario;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        /*
        Funcion para guardar la relacion entre videojuego y usuario en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO usuariovideojuego VALUES(NULL, {$this -> getIdUsuario()}, {$this -> getIdVideojuego()})";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
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

        /*
        Funcion para obtener el usuario dueño del videojuego creado
        */

        public function obtenerUsuarioVideojuego(){
            //Construir la consulta
            $consulta = "SELECT idUsuario FROM usuariovideojuego WHERE idVideojuego = {$this -> getIdVideojuego()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener resultado
            $usuario = $resultado -> fetch_object();
            //Retornar el id del usuario
            return $usuario;
        }

        /*
        Funcion para listar todos los videojuegos
        */

        public function listarTodos(){
            //Construir la consulta
            $consulta = "SELECT * FROM videojuegos";
            if($this -> getIdUsuario() != null){
                $consulta .= " WHERE id NOT IN (SELECT idVideojuego FROM usuariovideojuego WHERE idUsuario = {$this -> getIdUsuario()})"; 
            }
            $consulta .= " ORDER BY id DESC";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        /*
        Funcion para listar algunos de los videojuegos, en concreto 6
        */

        public function listarAlgunos(){
            //Construir la consulta
            $consulta = "SELECT * FROM videojuegos";
            if($this -> getIdUsuario() != null){
                $consulta .= " WHERE id NOT IN (SELECT idVideojuego FROM usuariovideojuego WHERE idUsuario = {$this -> getIdUsuario()})"; 
            }
            $consulta .= " ORDER BY RAND() LIMIT 6";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }
    }

?>