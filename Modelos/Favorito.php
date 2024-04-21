<?php

    /*
    Clase modelo de favorito
    */

    class Favorito{

        private $id;
        private $activo;
        private $idUsuario;
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
        Funcion getter de id usuario
        */

        public function getIdUsuario(){
            /*Retornar el resultado*/
            return $this->idUsuario;
        }

        /*
        Funcion setter de id de usuario
        */

        public function setIdUsuario($idUsuario){
            /*Llamar parametro*/
            $this->idUsuario = $idUsuario;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion para guardar el favorito en la base de datos
        */

        public function guardar(){
            /*Construir consulta*/
            $consulta = "INSERT INTO favoritos VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()})";
            /*Llamar la funcion que ejecuta la consulta*/
            $guardado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa y el total de columnas afectadas se altero llamando la ejecucion de la consulta*/
            if($guardado && mysqli_affected_rows($this -> db) > 0){
                /*Cambiar el estado de la variable bandera*/
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

        /*
        Funcion para obtener el ultimo favorito registrado
        */

        public function ultimo(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT id FROM favoritos ORDER BY id DESC LIMIT 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $resultado = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $ultimo = $resultado -> fetch_object();
            /*Devolver resultado*/
            $ultimoFavorito = $ultimo -> id;
            /*Retornar el resultado*/
            return $ultimoFavorito;
        }

        /*
        Funcion para listar los videojuegos de favoritos
        */

        public function listar(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT v.nombre AS 'nombreVideojuego', v.foto AS 'imagenVideojuego', v.precio AS 'precioVideojuego'
                FROM videojuegofavorito vf
                INNER JOIN favoritos f ON vf.idFavorito = f.id
                INNER JOIN videojuegos v ON v.id = vf.idVideojuego
                WHERE f.idUsuario = {$this -> getIdUsuario()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $resultado = $this -> db -> query($consulta);
            /*Retornar el resultado*/
            return $resultado;
        }
        
    }

?>