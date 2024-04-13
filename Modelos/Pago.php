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
        Funcion para obtener un uso
        */

        public function obtenerUno(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM pagos WHERE id = {$this -> getId()} AND activo = 1";
            //Ejecutar la consulta
            $uso = $this -> db -> query($consulta);
            //Obtener resultado
            $resultado = $uso -> fetch_object();
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para eliminar el uso
        */

        public function eliminar(){
            //Construir la consulta
            $consulta = "UPDATE pagos SET activo = 0 WHERE id = {$this -> getId()}";
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

        /*
        Funcion para actualizar el uso
        */

        public function actualizar(){
            //Construir la consulta
            $consulta = "UPDATE pagos SET idMedioPago = '{$this -> getIdMedioPago()}', numero = '{$this -> getNumero()}' 
                WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $actualizado = $this -> db -> query($consulta);
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($actualizado && mysqli_affected_rows($this -> db) > 0){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }
    }

?>