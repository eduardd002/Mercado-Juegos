<?php

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    class UsuarioController{

        /*
        Funcion para realizar el inicio de sesion del usuario
        */

        public function login(){

            //Incluir la vista
            require_once "Vistas/Usuario/Login.html";
        }

        /*
        Funcion para realizar el registro del usuario
        */

        public function registro(){

            //Incluir la vista
            require_once "Vistas/Usuario/Registro.html";
        }

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $fechaNacimiento = isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;

                //Comprobar si todos los datos exsiten
                if($nombre && $apellidos && $fechaNacimiento && $telefono && $email && $departamento && $municipio){

                    //Instanciar el objeto
                    $usuario = new Usuario();

                    //Crear el objeto
                    $usuario -> setNombre($nombre);
                    $usuario -> setRol('Usuario');
                    $usuario -> setApellido($apellidos);
                    $usuario -> setFechanacimiento($fechaNacimiento);
                    $usuario -> setNumerotelefono($telefono);
                    $usuario -> setCorreo($email);
                    $usuario -> setDepartamento($departamento);
                    $usuario -> setMunicipio($municipio);
                    $usuario -> setFecharegistro(date('d-m-y'));

                    //Guardar la imagen

                    //Guardar toda la informacion referente a la imagen
                    $archivo = $_FILES['foto'];
                    //Extraer nombre del archivo de imagen
                    $nombreArchivo = $archivo['name'];
                    //Extraer el tipo de archivo de la imagen
                    $tipoArchivo = $archivo['type'];

                    //Comprobar si el archivo tiene la extensión de una imagen
                    if($tipoArchivo == "image/jpg" || $tipoArchivo == "image/jpeg" || $tipoArchivo == "image/png" || $tipoArchivo == "image/gif"){

                        //Comprobar si no existe un directorio para las imagenes a subir
                        if(!is_dir('Recursos/ImagenesUsuarios')){

                            //Crear el directorio
                            mkdir('Recursos/ImagenesUsuarios', 0777, true);
                        }

                        //Crear el objeto
                        $usuario -> setFoto($nombreArchivo);
                        //Mover la foto subida a la ruta temporal del servidor y luego a la de la carpeta de las imagenes
                        move_uploaded_file($archivo['tmp_name'], 'Recursos/ImagenesUsuarios/'.$nombreArchivo);
                    }else{
                        $_SESSION['RegistroUsuario'] = "El formato debe ser de una imagen";
                        header("Location:"."<?=rutaInicio?><?=usuario?><?=crear?>");
                    }
                        //Guardar en la base de datos
                        $guardado = $usuario -> guardar();

                        if($guardado){
                            $_SESSION['LoginUsuario'] = 'Exito';
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        }else{
                            $_SESSION['RegistroUsuario'] = "Ya hay una ruta de correo en uso";
                            header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
                        }
                }else{
                    $_SESSION['RegistroUsuario'] = "Ha ocurrido un error al realizar el registro";
                    header("Location:"."<?=rutaInicio?><?=usuario?><?=crear?>");
                }

            }
        }

        /*
        Funcion para ver el perfil de un usuario
        */

        public function perfil(){

            //Incluir la vista
            require_once "Vistas/Usuario/Perfil.html";
        }

        /*
        Funcion para ver el perfil del usuario indentificado
        */

        public function miPerfil(){

            //Incluir la vista
            require_once "Vistas/Usuario/miPerfil.html";
        }

        /*
        Funcion para ver el listado de compras realizadas por el usuario
        */

        public function compras(){

            //Incluir la vista
            require_once "Vistas/Usuario/Compras.html";
        }

        /*
        Funcion para ver el listado de ventas realizadas por el usuario
        */

        public function ventas(){

            //Incluir la vista
            require_once "Vistas/Usuario/Ventas.html";
        }

        /*
        Funcion para ver los videojuegos creados por el usuario indentificado
        */

        public function videojuegos(){

            //Incluir la vista
            require_once "Vistas/Usuario/Videojuegos.html";
        }

    }

?>