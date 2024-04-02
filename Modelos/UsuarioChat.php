<?php

    class UsuarioChat{

        private $id;
        private $activo;
        private $idRemitente;
        private $idDestinatario;
        private $idChat;
        private $db;

        public function __construct(){
            $this -> db = BaseDeDatos::connect();
        }

        public function getId(){
            return $this->id;
        }

        public function getActivo(){
            return $this->activo;
        }

        public function setActivo($activo){
            $this->activo = $activo;
            return $this;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function getIdRemitente(){
            return $this->idRemitente;
        }

        public function setIdRemitente($idRemitente){
            $this->idRemitente = $idRemitente;
            return $this;
        }

        public function getIdDestinatario(){
            return $this->idDestinatario;
        }

        public function setIdDestinatario($idDestinatario){
            $this->idDestinatario = $idDestinatario;
            return $this;
        }

        public function getIdChat(){
            return $this->idChat;
        }

        public function setIdChat($idChat){
            $this->idChat = $idChat;
            return $this;
        }

        /*
        Funcion para guardar el usuario chat en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO usuariochat VALUES (NULL, {$this -> getActivo()}, {$this -> getIdRemitente()}, 
                {$this -> getIdDestinatario()}, {$this -> getIdChat()})";
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
        Funcion para obtener los chats propios de cada usuario
        */

        public function obtenerChats(){

            //Construir la consulta
            $consulta = "SELECT DISTINCT id AS 'idUsuarioChat', nombre AS 'nombreChat', foto AS 'fotoChat', apellido AS 'apellidoChat' 
            FROM usuarios WHERE id IN 
            (SELECT idDestinatario FROM usuarioChat WHERE idRemitente = {$this->getIdRemitente()} 
            UNION 
            SELECT idRemitente FROM usuarioChat WHERE idDestinatario = {$this->getIdDestinatario()})";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar el resultado
            return $resultado;
        }

        public function obtenerIdentificadorPropioDeChat(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT idChat from usuariochat WHERE idRemitente = {$this -> getIdRemitente()} AND idDestinatario = {$this -> getIdDestinatario()} OR
                idRemitente = {$this -> getIdDestinatario()} AND idDestinatario = {$this -> getIdRemitente()}"; 
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            $idenficador = $resultado -> fetch_object();
            return $idenficador -> idChat;
        }
    }

?>