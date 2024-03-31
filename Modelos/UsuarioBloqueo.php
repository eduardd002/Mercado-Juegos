<?php

    class UsuarioBloqueo{

        private $id;
        private $idBloqueador;
        private $idBloqueado;
        private $idBloqueo;
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
         * Get the value of idBloqueador
         */ 
        public function getIdBloqueador()
        {
                return $this->idBloqueador;
        }

        /**
         * Set the value of idBloqueador
         *
         * @return  self
         */ 
        public function setIdBloqueador($idBloqueador)
        {
                $this->idBloqueador = $idBloqueador;

                return $this;
        }

        /**
         * Get the value of idBloqueado
         */ 
        public function getIdBloqueado()
        {
                return $this->idBloqueado;
        }

        /**
         * Set the value of idBloqueado
         *
         * @return  self
         */ 
        public function setIdBloqueado($idBloqueado)
        {
                $this->idBloqueado = $idBloqueado;

                return $this;
        }

        /**
         * Get the value of idBloqueo
         */ 
        public function getIdBloqueo()
        {
                return $this->idBloqueo;
        }

        /**
         * Set the value of idBloqueo
         *
         * @return  self
         */ 
        public function setIdBloqueo($idBloqueo)
        {
                $this->idBloqueo = $idBloqueo;

                return $this;
        }

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO usuariobloqueo VALUES(NULL, {$this -> getIdBloqueador()}, 
                {$this -> getIdBloqueado()}, {$this -> getIdBloqueo()})";
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

        public function obtenerBloqueosPorUsuario(){
                $consulta = "SELECT b.id AS 'idBloqueo', u.nombre AS 'nombreBloqueado', u.apellido AS 'apellidoBloqueado', b.motivo AS 'motivoBloqueo', b.fechaBloqueo AS 'fechaBloqueo', b.horaBloqueo AS 'horaBloqueo'
                FROM UsuarioBloqueo ub
                INNER JOIN Usuarios u ON u.id = ub.idBloqueado
                INNER JOIN Bloqueos b ON b.id = ub.id
                WHERE ub.idBloqueador = {$this -> getIdBloqueador()}";
                //Ejecutar la consulta
                $lista = $this -> db -> query($consulta);
                //Retornar el resultado
                return $lista;
        }
    }

?>