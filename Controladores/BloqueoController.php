<?php

    //Incluir el objeto de bloqueo
    require_once "Modelos/Bloqueo.php";
    //Incluir el objeto de usuario bloqueo
    require_once "Modelos/UsuarioBloqueo.php";

    class BloqueoController{

        /*
        Funcion para guardar el bloqueo en la base de datos
        */

        public function guardarBloqueo($motivo){
            
            //Instanciar el objeto
            $bloqueo = new Bloqueo();
            //Crear el objeto
            $bloqueo -> setMotivo($motivo);
            $bloqueo -> setFecha(date('Y-m-d'));
            $bloqueo -> setHora(date('H:i:s'));
            //Guardar en la base de datos
            $guardado = $bloqueo -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para obtener el ultimo bloqueo registrado
        */

        public function obtenerUltimoBloqueo(){

            //Instanciar el objeto
            $bloqueo = new Bloqueo();
            //Obtener id del ultimo bloqueo registrado
            $id = $bloqueo -> ultimo();
            //Retornar resultado
            return $id;
        }

        /*
        Funcion para guardar el usuario bloqueo en la base de datos
        */

        public function guardarUsuarioBloqueo($idUsuarioABloquear){

            //Instanciar el objeto
            $usuarioBloqueo = new UsuarioBloqueo();
            //Crear el objeto
            $usuarioBloqueo -> setIdBloqueador($_SESSION['loginexitoso'] -> id);
            $usuarioBloqueo -> setIdBloqueado($idUsuarioABloquear);
            $usuarioBloqueo -> setIdBloqueo($this -> obtenerUltimoBloqueo());
            //Guardar en la base de datos
            $guardado = $usuarioBloqueo -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para guardar el bloqueo
        */

        public function bloquear(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Obtener el usuario a bloquear
                $idUsuarioABloquear = $_GET['aBloquear'];
                $motivo = "hola";
                //Llamar funcion de guardar bloqueo
                $bloqueoGuardado = $this -> guardarBloqueo($motivo);

                //Comprobar si el bloqueo se guardo con exito
                if($bloqueoGuardado){

                    //Llamar funcion de guardar bloqueo usuario
                    $bloqueoUsuarioGuardado = $this -> guardarUsuarioBloqueo($idUsuarioABloquear);

                    //Comprobar si el bloqueo se guardo con exito
                    if($bloqueoUsuarioGuardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("guardarbloqueoacierto", "El bloqueo ha sido guardado con exito", "?controller=UsuarioController&action=bloqueos");
                    }else{

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("guardarbloqueoerror", "Ha ocurrido un error al guardar el bloqueo del usuario", "?controller=UsuarioController&action=perfil&idVendedor=$idUsuarioABloquear");
                    }
                }else{

                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("guardarbloqueoerror", "Ha ocurrido un error al guardar el bloqueo", "?controller=UsuarioController&action=perfil&idVendedor=$idUsuarioABloquear");
                }
            }else{

                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("guardarbloqueoerror", "Ha ocurrido un error al guardar el bloqueo", "?controller=VideojuegoController&action=inicio");
            }
        }
    }

?>