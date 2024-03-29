<?php

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    //Incluir el objeto de administrador
    require_once 'Modelos/Administrador.php';

    //Incluir el objeto de transaccion
    require_once 'Modelos/Transaccion.php';

    
    require_once 'Modelos/UsuarioVideojuego.php';

    
    require_once 'Modelos/UsuarioBloqueo.php';

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

        /*
        Funcion para guardar el usuario
        */

        public function guardarUsuario($nombre, $apellidos, $fechaNacimiento, $telefono, $email, $clave, $departamento, $municipio, $nombreArchivo){

            //Instanciar el objeto
            $usuario = new Usuario();
            //Crear el objeto
            $usuario -> setNombre($nombre);
            $usuario -> setApellido($apellidos);
            $usuario -> setFechanacimiento($fechaNacimiento);
            $usuario -> setNumerotelefono($telefono);
            $usuario -> setCorreo($email);
            $usuario -> setClave($clave);
            $usuario -> setDepartamento($departamento);
            $usuario -> setMunicipio($municipio);
            $usuario -> setFecharegistro(date('y-m-d'));
            $usuario -> setFoto($nombreArchivo);
            //Guardar en la base de datos
            $guardado = $usuario -> guardar();
            //Retornar el resultado
            return $guardado;
        }

        /*
        Funcion para guardar el usuario en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreusu']) ? $_POST['nombreusu'] : false;
                $apellidos = isset($_POST['apellidosusu']) ? $_POST['apellidosusu'] : false;
                $fechaNacimiento = isset($_POST['fechaNacimientousu']) ? $_POST['fechaNacimientousu'] : false;
                $telefono = isset($_POST['telefonousu']) ? $_POST['telefonousu'] : false;
                $email = isset($_POST['emailusu']) ? $_POST['emailusu'] : false;
                $clave = isset($_POST['passwordusu']) ? $_POST['passwordusu'] : false;
                $departamento = isset($_POST['departamentousu']) ? $_POST['departamentousu'] : false;
                $municipio = isset($_POST['municipiousu']) ? $_POST['municipiousu'] : false;
                $archivo = $_FILES['foto'];
                $foto = $archivo['name'];

                //Comprobar si todos los datos exsiten
                if($nombre && $apellidos && $fechaNacimiento && $telefono && $clave && $email && $departamento && $municipio){

                    //Comprobar si la contraseña es valida
                    $claveSegura = Ayudas::comprobarContrasenia($clave);
                    //Comprobar si la foto es valida
                    $fotoGuardada = Ayudas::guardarImagen($archivo, "ImagenesUsuarios");
                    
                    //Comprobar si todo esta correcto para guardar el usuario
                    if($claveSegura){

                        //Comprobar si la foto ha sido guardada
                        if($fotoGuardada){

                            //Comprobar si se ha guardado con exito
                            $guardado = $this -> guardarUsuario($nombre, $apellidos, $fechaNacimiento, $telefono, $email, $clave, $departamento, $municipio, $foto);

                            //Comprobar si el administrador ha sido guardado
                            if($guardado){
                                //Iniciar la sesion
                               Ayudas::iniciarSesionUsuario($email, $clave);
                            }else{
                                //Crear la sesion y redirigir a la ruta pertinente
                                Ayudas::crearSesionYRedirigir("guardarusuarioerror", "Ya existe una direccion de correo asociada", "?controller=UsuarioController&action=registro");
                            }
                        }else{

                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir("guardarusuarioerror", "La imagen debe ser de tipo imagen", "?controller=UsuarioController&action=registro");
                        }
                    }else{

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("guardarusuarioerror", "La clave debe contener un mayuscula, miniscula, numero, caracter especial y minimo 8 caracteres de longitud", "?controller=UsuarioController&action=registro");
                    }       
                }else{

                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("guardarusuarioerror", "Ha ocurrido un error al guardar el usuario", "?controller=UsuarioController&action=registro");
                }
            }else{

                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("guardarusuarioerror", "Ha ocurrido un error al guardar el usuario", "?controller=UsuarioController&action=registro");
            }
        }

        /*
        Funcion para realizar el inicio de sesion
        */

        public function inicioDeSesion(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $clave = isset($_POST['password']) ? $_POST['password'] : false;

                //Comprobar si todos los datos exsiten
                if($email && $clave){
                    //Iniciar la sesion
                    Ayudas::iniciarSesion($email, $clave);
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("iniciarsesionerror", "Ha ocurrido un error al iniciar sesion", "?controller=UsuarioController&action=login");
                }
            }
        }

        /*
        Funcion para eliminar un usuario de la base de datos
        */

        public function eliminarUsuario($idUsuario){

            //Instanciar el objeto
            $usuario = new Usuario();
            //Crear objeto
            $usuario -> setId($idUsuario);
            //Ejecutar la consulta
            $eliminado = $usuario -> eliminar();
            //Retornar el resultado
            return $eliminado;
        }

        /*
        Funcion para eliminar la cuenta del usuario de la base de datos
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idUsuario = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idUsuario){

                    //Obtener el resultado
                    $eliminado = $this -> eliminarUsuario($idUsuario);

                    //Comprobar si se ha elimininado el usuario con exito
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("eliminarusuarioacierto", "El usuario ha sido eliminado con exito", "?controller=VideojuegoController&action=inicio");
                        //Eliminar la sesion de login
                        Ayudas::eliminarSesion('loginexitoso');
                    }else{

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("eliminarusuarioerror", "El usuario no ha sido eliminado con exito", "?controller=UsuarioController&action=perfil");
                    }
                }  
            }
        }

        public function actualizarUsuario($id, $nombre, $apellidos, $telefono, $email, $clave, $departamento, $municipio, $foto){

            //Instanciar el objeto
            $usuario = new Usuario();
            //Crear objeto
            $usuario -> setId($id);
            $usuario -> setNombre($nombre);
            $usuario -> setApellido($apellidos);
            $usuario -> setNumerotelefono($telefono);
            $usuario -> setCorreo($email);
            $usuario -> setClave($clave);
            $usuario -> setDepartamento($departamento);
            $usuario -> setMunicipio($municipio);
            $usuario -> setFoto($foto);
            //Ejecutar la consulta
            $actualizado = $usuario -> actualizar();
            return $actualizado;
        }

        /*
        Funcion para actualizar un usuario
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $clave = isset($_POST['password']) ? $_POST['password'] : false;
                $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;
                //Añadir archivo de foto
                $archivo = $_FILES['foto'];

                //Si el dato existe
                if($id && $nombre && $apellidos && $telefono && $email && $clave && $departamento && $municipio){

                    //Comprobar si el formato de la foto es imagen
                    if(Ayudas::comprobarImagen($archivo['type']) == 2){
                        //Comprobar si la contraseña es valida
                        $claveSegura = Ayudas::comprobarContrasenia($clave);
                        //Comprobar la foto
                        $foto = Ayudas::guardarImagen($archivo, "ImagenesUsuarios");
                        //Llamar la funcion de actualizar
                        $actualizado = $this -> actualizarUsuario($id, $nombre, $apellidos, $telefono, $email, $clave, $departamento, $municipio, $foto);

                        if($claveSegura){

                            if($actualizado){
                                //Crear la sesion y redirigir a la ruta pertinente
                                Ayudas::crearSesionYRedirigir('actualizarusuarioacierto', "Usuario actualizado con exito", '?controller=UsuarioController&action=miPerfil');
                            }else{
                                //Crear la sesion y redirigir a la ruta pertinente
                                Ayudas::crearSesionYRedirigir('actualizarusuariosugerencia', "Agrega nuevos datos", '?controller=UsuarioController&action=miPerfil');
                            }
                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('actualizarusuariosugerencia', "Clave poco segura", '?controller=UsuarioController&action=miPerfil');
                        }
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarusuariosugerencia', "El formato de la foto debe ser una imagen", '?controller=UsuarioController&action=miPerfil');
                    }
                }
            }
        }

        /*
        Funcion para cerrar la sesión
        */

        public function cerrarSesion(){

            //Lamar funciones para eliminar las sesiones
            Ayudas::eliminarSesion('loginexitosoa');
            Ayudas::eliminarSesion('loginexitoso');
            
            //Crear sesion de sesion creada con exito
            $_SESSION['logincerrado'] = "Sesion cerrada con exito";

            //Redirigir al menu principal
            header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
        }

        /*
        Funcion para ver el perfil de un usuario
        */

        public function perfil(){

            $idVendedor = $_GET['idVendedor'];

            //Instanciar el objeto
            $usuarioVideojuego = new UsuarioVideojuego();
            $usuarioVideojuego -> setIdUsuario($idVendedor);
            $listaDatosUsuario = $usuarioVideojuego -> obtenerInformacionUsuario();
            //Incluir la vista
            require_once "Vistas/Usuario/Perfil.html";
        }

        public function obtenerPerfil($id){

            //Instanciar el objeto
            $usuario = new Usuario();
            //Creo el objeto
            $usuario -> setId($id);
            //Obtener categoria
            $usuarioUnico = $usuario -> obtenerUno();
            //Retornar el resultado
            return $usuarioUnico;
        }

        /*
        Funcion para ver el perfil del usuario indentificado
        */

        public function miPerfil(){

            //Llamar la funcion auxiliar para redirigir en caso de que no haya inicio de sesion
            Ayudas::restringirAUsuario('?controller=UsuarioController&action=login');

            //Comprobar si el dato está llegando
            if(isset($_GET)){

                //Comprobar si la sesion de inicio de sesion existe
                $id = isset($_SESSION['loginexitoso']) ? $_SESSION['loginexitoso'] -> id : false;

                //Si el dato existe
                if($id){

                    $usuarioUnico = $this -> obtenerPerfil($id);

                    //Incluir la vista
                    require_once "Vistas/Usuario/miPerfil.html";
                }
            }
        }

        /*
        Funcion para ver el listado de compras realizadas por el usuario
        */

        public function compras(){

            //Instanciar el objeto
            $transaccion = new Transaccion();
            //Construir el objeto
            $transaccion -> setIdComprador($_SESSION['loginexitoso'] -> id);
            //Listar todos los usuarios desde la base de datos
            $listadoCompras = $transaccion -> obtenerCompras();

            //Incluir la vista
            require_once "Vistas/Usuario/Compras.html";
        }

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

        /*
        Funcion para ver el listado de ventas realizadas por el usuario
        */

        public function ventas(){

            //Instanciar el objeto
            $transaccion = new Transaccion();
            //Construir el objeto
            $transaccion -> setIdVendedor($_SESSION['loginexitoso'] -> id);
            //Listar todos los usuarios desde la base de datos
            $listadoVentas = $transaccion -> obtenerVentas();

            //Incluir la vista
            require_once "Vistas/Usuario/Ventas.html";
        }

        /*
        Funcion para ver los videojuegos creados por el usuario indentificado
        */

        public function videojuegos(){

            //Instanciar el objeto
            $usuarioVideojuego = new UsuarioVideojuego();
            $usuarioVideojuego -> setIdUsuario($_SESSION['loginexitoso'] -> id);
            $listaVideojuegos = $usuarioVideojuego -> obtenerVideojuegosCreadosPorUsuario();
            //Incluir la vista
            require_once "Vistas/Usuario/Videojuegos.html";
        }

    }

?>