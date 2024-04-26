<?php

    /*
    Clase modelo de categoria
    */

    class Categoria{

        private $id;
        private $activo;
        private $nombre;
        private $db;

        /*
        Funcion constructor
        */

        public function __construct(){
            /*Llamar conexion a la base de datos*/
            $this -> db = BaseDeDatos::connect();
        }

        /*
        Funcion getter de id
        */

        public function getId(){
            /*Retornar el resultado*/
            return $this->id;
        }

        /*
        Funcion setter de id
        */

        public function setId($id){
            /*Llamar parametro*/
            $this->id = $id;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de activo
        */

        public function getActivo(){
            /*Retornar el resultado*/
            return $this->activo;
        }

        /*
        Funcion setter de activo
        */

        public function setActivo($activo){
            /*Llamar parametro*/
            $this->activo = $activo;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de nombre
        */

        public function getNombre(){
            /*Retornar el resultado*/
            return $this->nombre;
        }

        /*
        Funcion setter de nombre
        */

        public function setNombre($nombre){
            /*Llamar parametro*/
            $this->nombre = $nombre;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion para realizar el registro de la categoria en la base de datos
        */

        public function guardar(){
            /*Construir la consulta*/
            $consulta = "INSERT INTO categorias VALUES(NULL, {$this -> getActivo()}, '{$this -> getNombre()}')";
            /*Llamar la funcion que ejecuta la consulta*/
            $registro = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $resultado = false;
            /*Comprobar si la consulta fue exitosa y el total de columnas afectadas se altero llamando la ejecucion de la consulta*/
            if($registro && mysqli_affected_rows($this -> db) > 0){
                /*Cambiar el estado de la variable bandera*/
                $resultado = true;
            }
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para listar todas las categorias
        */

        public function listar(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT * FROM categorias WHERE activo = 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $lista = $this -> db -> query($consulta);
            /*Retornar el resultado*/
            return $lista;
        }

        /*
        Funcion para obtener una categoria
        */

        public function obtenerUna(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT * FROM categorias WHERE id = {$this -> getId()} AND activo = 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $categoria = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $resultado = $categoria -> fetch_object();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para eliminar la categoria
        */

        public function eliminar(){
            /*Construir la consulta*/
            $consulta = "UPDATE categorias SET activo = {$this -> getActivo()} WHERE id = {$this -> getId()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $eliminado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa*/
            if($eliminado){
                /*Cambiar el estado de la variable bandera*/
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

        /*
        Funcion para actualizar la categoria
        */

        public function actualizar(){
            /*Construir la consulta*/
            $consulta = "UPDATE categorias SET nombre = '{$this -> getNombre()}' 
                WHERE id = {$this -> getId()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $actualizado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa y el total de columnas afectadas se altero llamando la ejecucion de la consulta*/
            if($actualizado && mysqli_affected_rows($this -> db) > 0){
                /*Cambiar el estado de la variable bandera*/
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

        /*
        Funcion para comprobar si ya se ha creado la categoria con anterioridad
        */

        public function comprobarCategoriaUnica(){
            /*Construir la consulta*/
            $consulta = "SELECT activo FROM categorias WHERE nombre = '{$this -> getNombre()}'";
            /*Llamar la funcion que ejecuta la consulta*/
            $categoria = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $resultado = $categoria -> fetch_object();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para recuperar la categoria eliminada
        */

        public function recuperarCategoria(){
            /*Construir la consulta*/
            $consulta = "UPDATE categorias SET activo = 1 WHERE nombre = '{$this -> getNombre()}'";
            /*Llamar la funcion que ejecuta la consulta*/
            $recuperado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa y el total de columnas afectadas se altero llamando la ejecucion de la consulta*/
            if($recuperado && mysqli_affected_rows($this -> db) > 0){
                /*Cambiar el estado de la variable bandera*/
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

    }

?>