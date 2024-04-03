<?php

    class ComentarioVideojuego{

        private $id;
        private $activo;
        private $idComenatario;
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

        public function getActivo(){
            return $this->activo;
        }

        public function setActivo($activo){
            $this->activo = $activo;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        public function getIdComentario(){
            return $this->idComenatario;
        }

        public function setIdComentario($categoriaId){
            $this->idComenatario = $categoriaId;
            return $this;
        }

        /*
        Funcion para guardar la relacion entre videojuego y comentario en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO comentariovideojuego VALUES(NULL, {$this -> getActivo()}, {$this -> getIdComentario()}, {$this -> getIdVideojuego()})";
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

        public function obtenerComentariosDeVideojuego(){
            $consulta = "SELECT DISTINCT c.contenido AS 'contenidoComentario', u.nombre AS 'nombreComentador', u.foto AS 'fotoComentador', c.fechaCreacion AS 'fechaCreacionComentario', c.horaCreacion AS 'horaCreacionComentario'
            FROM Comentarios c
            INNER JOIN Usuarios u ON u.id = c.idUsuario
            INNER JOIN ComentarioVideojuego cv ON cv.idComentario = c.id
            WHERE cv.idVideojuego = {$this -> getIdVideojuego()}";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }
    }

?>