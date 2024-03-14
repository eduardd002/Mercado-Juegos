<?php

    class Uso{

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
        Funcion para realizar el registro del uso en la base de datos
        */

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT IGNORE INTO usos VALUES(NULL, '{$this -> getNombre()}')";
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
        Funcion para listar todos los usos
        */

        public function listar(){
            //Construir la consulta
            $consulta = "SELECT * FROM usos";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para eliminar el uso
        */

        public function eliminar(){
            //Construir la consulta
            $consulta = "DELETE FROM usos WHERE id = {$this -> id}";
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

    }

?>