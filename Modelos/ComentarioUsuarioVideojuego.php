<?php

    class ComentarioUsuarioVideojuego{

        private $id;
        private $activo;
        private $idUsuario;
        private $idVideojuego;
        private $contenido;
        private $fechaHora;
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

        
        /**
         * Get the value of idUsuario
         */ 
        public function getIdUsuario()
        {
                return $this->idUsuario;
        }

        /**
         * Set the value of idUsuario
         *
         * @return  self
         */ 
        public function setIdUsuario($idUsuario)
        {
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

        public function getFechaHora()
        {
                return $this->fechaHora;
        }

        /**
         * Set the value of fecha
         *
         * @return  self
         */ 
        public function setFechaHora($fechaHora)
        {
                $this->fechaHora = $fechaHora;

                return $this;
        }

        public function getContenido(){
            return $this->contenido;
       }

       public function setContenido($contenido){
            $this->contenido = $contenido;
            return $this;
       }

        /*
        Funcion para guardar la relacion entre videojuego y comentario en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO comentariovideojuego VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()}, {$this -> getIdVideojuego()}, '{$this -> getContenido()}', '{$this -> getFechaHora()}')";
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
            $consulta = "SELECT DISTINCT c.contenido AS 'contenidoComentario', u.nombre AS 'nombreComentador', u.foto AS 'fotoComentador', c.fechaCreacion AS 'fechaCreacionComentario', c.horaCreacion AS 'horaCreacionComentario', c.id AS 'idComentario'
            FROM Comentarios c
            INNER JOIN Usuarios u ON u.id = c.idUsuario
            INNER JOIN ComentarioVideojuego cv ON cv.idComentario = c.id
            WHERE cv.idVideojuego = {$this -> getIdVideojuego()} AND c.activo = 1";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        public function eliminar(){

            //Construir la consulta
            $consulta = "UPDATE comentarios SET activo = 0 WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $eliminado = $this -> db -> query($consulta);
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($eliminado){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }
    }

?>