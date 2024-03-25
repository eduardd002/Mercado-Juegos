<?php

    class UsuarioMensajeChat{

        private $id;
        private $idRemitente;
        private $idDestinatario;
        private $idMensaje;
        private $idChat;
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

        public function getIdMensaje(){
            return $this->idMensaje;
        }

        public function setIdMensaje($idMensaje){
            $this->idMensaje = $idMensaje;
            return $this;
        }

        public function getIdChat(){
            return $this->idChat;
        }

        public function setIdChat($idChat){
            $this->idChat = $idChat;
            return $this;
        }
    }

?>