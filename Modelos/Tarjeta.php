<?php

    class Tarjeta{

        private $id;
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

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
            return $this;
        }

        /*
        Funcion para realizar el registro de la tarjeta en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT IGNORE INTO tarjetas VALUES(NULL, '{$this -> getNombre()}')";
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
        Funcion para listar todas las tarjetas
        */

        public function listar(){
            //Construir la consulta
            $consulta = "SELECT * FROM tarjetas";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para obtener una tarjeta
        */

        public function obtenerUna(){
            //Construir la consulta
            $consulta = "SELECT * FROM tarjetas WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $tarjeta = $this -> db -> query($consulta);
            //Obtener resultado
            $resultado = $tarjeta -> fetch_object();
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para eliminar la tarjeta
        */

        public function eliminar(){
            //Construir la consulta
            $consulta = "DELETE FROM tarjetas WHERE id = {$this -> id}";
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
        Funcion para actualizar la tarjeta
        */

        public function actualizar(){
            //Construir la consulta
            $consulta = "UPDATE tarjetas SET nombre = '{$this -> getNombre()}' 
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