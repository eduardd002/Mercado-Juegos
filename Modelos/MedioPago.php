<?php

    class MedioPago{

        private $id;
        private $activo;
        private $nombre;
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

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
            return $this;
        }

        /*
        Funcion para realizar el registro de el medio de pago en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO mediospago VALUES(NULL, {$this -> getActivo()}, '{$this -> getNombre()}')";
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
        Funcion para listar todas los medios de pago
        */

        public function listar(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM mediospago WHERE activo = 1";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para obtener un medio de pago
        */

        public function obtenerUna(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM mediospago WHERE id = {$this -> getId()} AND activo = 1";
            //Ejecutar la consulta
            $medio = $this -> db -> query($consulta);
            //Obtener resultado
            $resultado = $medio -> fetch_object();
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para eliminar el medio de pago
        */

        public function eliminar(){
            //Construir la consulta
            $consulta = "UPDATE mediospago SET activo = 0 WHERE id = {$this -> getId()}";
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
        Funcion para actualizar el medio de pago
        */

        public function actualizar(){
            //Construir la consulta
            $consulta = "UPDATE mediospago SET nombre = '{$this -> getNombre()}' 
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