<?php

    class Bloqueo{
        
        private $id;
        private $motivo;
        private $fecha;
        private $hora;
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
         * Get the value of motivo
         */ 
        public function getMotivo()
        {
                return $this->motivo;
        }

        /**
         * Set the value of motivo
         *
         * @return  self
         */ 
        public function setMotivo($motivo)
        {
                $this->motivo = $motivo;

                return $this;
        }

        
        /**
         * Get the value of fecha
         */ 
        public function getFecha()
        {
                return $this->fecha;
        }

        /**
         * Set the value of fecha
         *
         * @return  self
         */ 
        public function setFecha($fecha)
        {
                $this->fecha = $fecha;

                return $this;
        }

        /**
         * Get the value of hora
         */ 
        public function getHora()
        {
                return $this->hora;
        }

        /**
         * Set the value of hora
         *
         * @return  self
         */ 
        public function setHora($hora)
        {
                $this->hora = $hora;

                return $this;
        }

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO bloqueos VALUES(NULL, '{$this -> getMotivo()}', 
            '{$this -> getFecha()}', '{$this -> getHora()}')";
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

        public function ultimo(){
            //Construir la consulta
            $consulta = "SELECT id FROM bloqueos ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimoBloqueo = $ultimo -> id;
            //Retornar el resultado
            return $ultimoBloqueo;
        }

    }

?>