<?php

    class Envio{

        private $id;
        private $activo;
        private $idUsuario;
        private $departamento;
        private $municipio;
        private $codigoPostal;
        private $barrio;
        private $direccion;
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
         * Get the value of departamento
         */ 
        public function getDepartamento()
        {
                return $this->departamento;
        }

        /**
         * Set the value of departamento
         *
         * @return  self
         */ 
        public function setDepartamento($departamento)
        {
                $this->departamento = $departamento;

                return $this;
        }

        /**
         * Get the value of municipio
         */ 
        public function getMunicipio()
        {
                return $this->municipio;
        }

        /**
         * Set the value of municipio
         *
         * @return  self
         */ 
        public function setMunicipio($municipio)
        {
                $this->municipio = $municipio;

                return $this;
        }

        /**
         * Get the value of codigoPostal
         */ 
        public function getCodigoPostal()
        {
                return $this->codigoPostal;
        }

        /**
         * Set the value of codigoPostal
         *
         * @return  self
         */ 
        public function setCodigoPostal($codigoPostal)
        {
                $this->codigoPostal = $codigoPostal;

                return $this;
        }

        /**
         * Get the value of barrio
         */ 
        public function getBarrio()
        {
                return $this->barrio;
        }

        /**
         * Set the value of barrio
         *
         * @return  self
         */ 
        public function setBarrio($barrio)
        {
                $this->barrio = $barrio;

                return $this;
        }

        /**
         * Get the value of direccion
         */ 
        public function getDireccion()
        {
                return $this->direccion;
        }

        /**
         * Set the value of direccion
         *
         * @return  self
         */ 
        public function setDireccion($direccion)
        {
                $this->direccion = $direccion;

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

                /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO envios VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()}, '{$this -> getDepartamento()}', '{$this -> getMunicipio()}', '{$this -> getCodigoPostal()}', '{$this -> getBarrio()}', 
                '{$this -> getDireccion()}')";
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
            $consulta = "SELECT DISTINCT id FROM envios ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimoPago = $ultimo -> id;
            //Retornar el resultado
            return $ultimoPago;
        }

                /*
        Funcion para eliminar el uso
        */

        public function eliminar(){
                //Construir la consulta
                $consulta = "UPDATE envios SET activo = 0 WHERE id = {$this -> getId()}";
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
                $consulta = "UPDATE envios SET departamento = '{$this -> getDepartamento()}', municipio = '{$this -> getMunicipio()}', codigoPostal = '{$this -> getCodigoPostal()}', barrio = '{$this -> getBarrio()}', direccion = '{$this -> getDireccion()}' 
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

                            /*
        Funcion para obtener un uso
        */

        public function obtenerUno(){
                //Construir la consulta
                $consulta = "SELECT DISTINCT * FROM envios WHERE id = {$this -> getId()} AND activo = 1";
                //Ejecutar la consulta
                $uso = $this -> db -> query($consulta);
                //Obtener resultado
                $resultado = $uso -> fetch_object();
                //Retornar el resultado
                return $resultado;
            }
    }

?>