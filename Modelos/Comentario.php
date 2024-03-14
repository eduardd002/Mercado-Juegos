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

        


        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

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

        /**
         * Get the value of idVideojuego
         */ 
        public function getIdVideojuego()
        {
                return $this->idVideojuego;
        }

        /**
         * Set the value of idVideojuego
         *
         * @return  self
         */ 
        public function setIdVideojuego($idVideojuego)
        {
                $this->idVideojuego = $idVideojuego;

                return $this;
        }

        /**
         * Get the value of contenido
         */ 
        public function getContenido()
        {
                return $this->contenido;
        }

        /**
         * Set the value of contenido
         *
         * @return  self
         */ 
        public function setContenido($contenido)
        {
                $this->contenido = $contenido;

                return $this;
        }

        /**
         * Get the value of fechaCreacion
         */ 
        public function getFechaCreacion()
        {
                return $this->fechaCreacion;
        }

        /**
         * Set the value of fechaCreacion
         *
         * @return  self
         */ 
        public function setFechaCreacion($fechaCreacion)
        {
                $this->fechaCreacion = $fechaCreacion;

                return $this;
        }

        /**
         * Get the value of horaCreacion
         */ 
        public function getHoraCreacion()
        {
                return $this->horaCreacion;
        }

        /**
         * Set the value of horaCreacion
         *
         * @return  self
         */ 
        public function setHoraCreacion($horaCreacion)
        {
                $this->horaCreacion = $horaCreacion;

                return $this;
        }

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