<?php

    //Incluir el objeto de bloqueo
    require_once "Modelos/Bloqueo.php";

    class BloqueoController{

        public function bloqueos(){

            //Instanciar el objeto
            $bloqueo = new Bloqueo();
            //Construir el objeto
            $bloqueo -> setIdBloqueador($_SESSION['loginexitoso'] -> id);
            //Listar todos los usuarios desde la base de datos
            $listadoBloqueos = $bloqueo -> obtenerBloqueosPorUsuario();

            //Incluir la vista
            require_once "Vistas/Usuario/Bloqueos.html";
        }

        public function bloquear(){

            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Obtener el usuario a bloquear
                $idUsuarioABloquear = $_GET['aBloquear'];

                $usuario = Ayudas::obtenerUsuarioEnConcreto($idUsuarioABloquear);

                //Incluir la vista
                require_once 'Vistas/Bloqueo/Bloqueo.html';
            }
        }

        public function desbloquear(){
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Obtener el usuario a bloquear
                $idUsuarioADesbloquear = $_GET['usuarioBloqueo'];

                $bloqueo = new Bloqueo();
                $bloqueo -> setIdBloqueado($idUsuarioADesbloquear);
                $bloqueo -> setIdBloqueador($_SESSION['loginexitoso'] -> id);
                $desbloqueo = $bloqueo -> eliminar();

                if($desbloqueo){
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("guardardesbloqueoacierto", "El desbloqueo ha sido guardado con exito", "?controller=UsuarioController&action=bloqueos");
                }
            }
        }

        /*
        Funcion para guardar el bloqueo en la base de datos
        */

        public function guardarBloqueo($motivo, $idUsuarioABloquear){
            
            //Instanciar el objeto
            $bloqueo = new Bloqueo();
            //Crear el objeto
            $bloqueo -> setActivo(1);
            $bloqueo -> setIdBloqueador($_SESSION['loginexitoso'] -> id);
            $bloqueo -> setIdBloqueado($idUsuarioABloquear);
            $bloqueo -> setMotivo($motivo);
            $bloqueo -> setFechaHora(date('Y-m-d H:i:s'));
            //Guardar en la base de datos
            $guardado = $bloqueo -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para guardar el bloqueo
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST) && isset($_GET)){

                //Obtener el usuario a bloquear
                $idUsuarioABloquear = $_GET['idBloqueado'];
                $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : false;
                //Llamar funcion de guardar bloqueo
                $bloqueoGuardado = $this -> guardarBloqueo($motivo, $idUsuarioABloquear);

                //Comprobar si el bloqueo se guardo con exito
                if($bloqueoGuardado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("guardarbloqueoacierto", "El bloqueo ha sido guardado con exito", "?controller=UsuarioController&action=bloqueos");
                    
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