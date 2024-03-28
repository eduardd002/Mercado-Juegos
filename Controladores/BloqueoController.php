<?php

    require_once "Modelos/Bloqueo.php";
    require_once "Modelos/UsuarioBloqueo.php";

    class BloqueoController{

        public function guardarBloqueo($motivo){
            $bloqueo = new Bloqueo();
            $bloqueo -> setMotivo($motivo);
            $bloqueo -> setFecha(date('Y-m-d'));
            $bloqueo -> setHora(date('H:i:s'));
            $bloqueo -> guardar();
        }

        public function obtenerUltimoBloqueo(){

            //Instanciar el objeto
            $bloqueo = new Bloqueo();
            //Obtener id del ultimo bloqueo registrado
            $id = $bloqueo -> ultimo();
            //Retornar resultado
            return $id;
        }

        public function guardarUsuarioBloqueo($idUsuarioABloquear){

            $usuarioBloqueo = new UsuarioBloqueo();
            $usuarioBloqueo -> setIdBloqueador($_SESSION['loginexitoso'] -> id);
            $usuarioBloqueo -> setIdBloqueado($idUsuarioABloquear);
            $usuarioBloqueo -> setIdBloqueo($this -> obtenerUltimoBloqueo());
            $usuarioBloqueo -> guardar();
        }

        public function bloquear(){

            $idUsuarioABloquear = $_GET['aBloquear'];
            $motivo = "hola";

            $this -> guardarBloqueo($motivo);
            $this -> guardarUsuarioBloqueo($idUsuarioABloquear);
        }
    }

?>