<?php

    class Estado{

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
        Funcion para realizar el registro del estado en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO estados VALUES(NULL, {$this -> getActivo()}, '{$this -> getNombre()}')";
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
        Funcion para listar todos los estados
        */

        public function listar(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM estados";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para obtener un estado
        */

        public function obtenerUno(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM estados WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $estado = $this -> db -> query($consulta);
            //Obtener resultado
            $resultado = $estado -> fetch_object();
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para eliminar el estado
        */

        public function eliminar(){
            //Construir la consulta
            $consulta = "UPDATE estados WHERE id = {$this -> getId()}";
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
        Funcion para actualizar el estado
        */

        public function actualizar(){
            //Construir la consulta
            $consulta = "UPDATE estados SET nombre = '{$this -> getNombre()}' 
                WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $actualizado = $this -> db -> query($consulta);
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($actualizado){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }

    }

?>