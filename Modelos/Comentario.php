<?php

    class Comentario{

        private $id;
        private $idUsuario;
        private $idVideojuego;
        private $contenido;
        private $fechaCreacion;
        private $horaCreacion;
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

        public function getContenido(){
             return $this->contenido;
        }

        public function setContenido($contenido){
             $this->contenido = $contenido;
             return $this;
        }

        public function getFechaCreacion(){
             return $this->fechaCreacion;
        }

        public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
            return $this;
        }

        public function getHoraCreacion(){
             return $this->horaCreacion;
        }

        public function setHoraCreacion($horaCreacion){
             $this->horaCreacion = $horaCreacion;
             return $this;
        }

        /*
        Funcion para guardar el comentario en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT IGNORE INTO comentarios VALUES(NULL, {$this -> getIdUsuario()}, 
                {$this -> getIdVideojuego()}, '{$this -> getContenido()}', 
                '{$this -> getFechaCreacion()}', '{$this -> getHoraCreacion()}')";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
            //Establecer una variable bandera
            $resultado = false;
            //Comporbar el registro fue exitoso y el total de columnas afectadas se altero
            if($registro && mysqli_affected_rows($this -> db) > 0){
                //Cambiar el estado de la variable bandera
                $resultado = true;
            }
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para listar los comentarios
        */

        public function listar(){
            //Construir consultas
            $consulta = "SELECT * FROM comentarios WHERE idVideojuego = {$this -> getIdVideojuego()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }
    }

?>