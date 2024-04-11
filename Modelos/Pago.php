<?php

    class Pago{

        private $id;
        private $activo;
        private $idUsuario;
        private $idMedioPago;
        private $numero;
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

        
        /**
         * Get the value of idMedioPago
         */ 
        public function getIdMedioPago()
        {
                return $this->idMedioPago;
        }

        
        /**
         * Get the value of numero
         */ 
        public function getNumero()
        {
                return $this->numero;
        }

        /**
         * Set the value of numero
         *
         * @return  self
         */ 
        public function setNumero($numero)
        {
                $this->numero = $numero;

                return $this;
        }

        /**
         * Set the value of idMedioPago
         *
         * @return  self
         */ 
        public function setIdMedioPago($idMedioPago)
        {
                $this->idMedioPago = $idMedioPago;

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
         * Get the value of activo
         */ 
        public function getActivo()
        {
                return $this->activo;
        }

        /**
         * Set the value of activo
         *
         * @return  self
         */ 
        public function setActivo($activo)
        {
                $this->activo = $activo;

                return $this;
        }

                /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO pagos VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()}, {$this -> getIdMedioPago()}, 
                '{$this -> getNUmero()}')";
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
        Funcion para obtener el ultimo pago registrado
        */

        public function ultimo(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT id FROM pagos ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimoPago = $ultimo -> id;
            //Retornar el resultado
            return $ultimoPago;
        }
    }

?>