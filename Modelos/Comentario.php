<?php

    class Comentario{

        private $id;
        private $idUsuario;
        private $contenido;
        private $fechaCreacion;
        private $horaCreacion;
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

        public function getIdUsuario(){
             return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario){
             $this->idUsuario = $idUsuario;
             return $this;
        }

        public function getContenido(){
             return $this->contenido;
        }

        public function setContenido($contenido){
             $this->contenido = $contenido;
             return $this;
        }

        public function getFechaCreacion(){
             return $this->fechaCreacion;
        }

        public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
            return $this;
        }

        public function getHoraCreacion(){
             return $this->horaCreacion;
        }

        public function setHoraCreacion($horaCreacion){
             $this->horaCreacion = $horaCreacion;
             return $this;
        }

        /*
        Funcion para guardar el comentario en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT IGNORE INTO comentarios VALUES(NULL, {$this -> getIdUsuario()}, 
               '{$this -> getContenido()}', '{$this -> getFechaCreacion()}', 
               '{$this -> getHoraCreacion()}')";
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
        Funcion para obtener el ultimo comentario registrado
        */

        public function ultimo(){
          //Construir la consulta
          $consulta = "SELECT id FROM comentarios ORDER BY id DESC LIMIT 1";
          //Ejecutar la consulta
          $resultado = $this -> db -> query($consulta);
          //Obtener el resultado del objeto
          $ultimo = $resultado -> fetch_object();
          //Devolver resultado
          $ultimoVideojuego = $ultimo -> id;
          //Retornar el resultado
          return $ultimoVideojuego;
      }
    }

?>