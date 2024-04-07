<?php

    //Incluir el objeto de bloqueo
    require_once "Modelos/Bloqueo.php";
    //Incluir el objeto de usuario bloqueo
    require_once "Modelos/UsuarioBloqueo.php";

    class BloqueoController{

        public function bloqueos(){

            //Instanciar el objeto
            $usuarioBloqueo = new UsuarioBloqueo();
            //Construir el objeto
            $usuarioBloqueo -> setIdBloqueador($_SESSION['loginexitoso'] -> id);
            //Listar todos los usuarios desde la base de datos
            $listadoBloqueos = $usuarioBloqueo -> obtenerBloqueosPorUsuario();

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
                $idBloqueo = $_GET['idBloqueo'];

                $desbloqueoUsuarioVideojuego = new UsuarioBloqueo();
                $desbloqueoUsuarioVideojuego -> setIdBloqueo($idBloqueo);
                $desbloqueoVideojuegoUsuario = $desbloqueoUsuarioVideojuego -> eliminar();

                $bloqueo = new Bloqueo();
                $bloqueo -> setId($idBloqueo);
                $desbloqueo = $bloqueo -> eliminar();

                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("guardardesbloqueoacierto", "El desbloqueo ha sido guardado con exito", "?controller=UsuarioController&action=bloqueos");

                $this -> bloqueos();
            }
        }

        /*
        Funcion para guardar el bloqueo en la base de datos
        */

        public function guardarBloqueo($motivo){
            
            //Instanciar el objeto
            $bloqueo = new Bloqueo();
            //Crear el objeto
            $bloqueo -> setActivo(1);
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
            $usuarioBloqueo -> setActivo(1);
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

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST) && isset($_GET)){

                //Obtener el usuario a bloquear
                $idUsuarioABloquear = $_GET['idBloqueado'];
                $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : false;
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