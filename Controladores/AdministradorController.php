<?php

    //Incluir el objeto de uso
    require_once 'Modelos/Uso.php';

    //Incluir el objeto de consola
    require_once 'Modelos/Consola.php';

    //Incluir el objeto de estado
    require_once 'Modelos/Estado.php';

    //Incluir el objeto de categoria
    require_once 'Modelos/Categoria.php';

    //Incluir el objeto de tarjeta
    require_once 'Modelos/MedioPago.php';

    //Incluir el objeto de administrador
    require_once 'Modelos/Administrador.php';

    //Incluir el objeto de usuario
    require_once 'Modelos/Usuario.php';

    require_once 'Modelos/Bloqueo.php';

    class AdministradorController{

        /*
        Funcion para realizar el registro del administrador
        */

        public function registro(){

            //Incluir la vista
            require_once "Vistas/Administrador/Registro.html";
        }

        public function cambiarClave(){

            //Incluir la vista
            require_once "Vistas/Administrador/CambiarClave.html";
        }

        /*
        Funcion para entrar a las funciones de administrador
        */

        public function administrar(){

            //Incluir la vista
            require_once "Vistas/Administrador/Inicio.html";
        }

        /*
        Funcion para obtener el administrador
        */

        public function perfilDeAdministrador($id){

            //Instanciar el objeto
            $administrador = new Administrador();
            //Creo el objeto
            $administrador -> setId($id);
            //Obtener resultado
            $adminUnico = $administrador -> obtenerUno();
            //Retornar el resultado
            return $adminUnico;
        }

        /*
        Funcion para ver el perfil del administrador indentificado
        */

        public function miPerfil(){

            //Llamar la funcion auxiliar para redirigir en caso de que no haya inicio de sesion
            Ayudas::restringirAAdministrador();

            //Comprobar si el dato está llegando
            if(isset($_GET)){

                //Comprobar si la sesion de inicio de sesion existe
                $id = isset($_SESSION['loginexitosoa']) ? $_SESSION['loginexitosoa'] -> id : false;

                //Si el dato existe
                if($id){

                    //Iniciar sesion
                    $adminUnico = $this -> perfilDeAdministrador($id);
                    //Incluir la vista
                    require_once "Vistas/Administrador/miPerfil.html";
                }
            }
        }

        /*
        Funcion para guardar el administrador
        */

        public function guardarAdministrador($nombre, $apellidos, $fechaNacimiento, $telefono, $email, $clave, $nombreArchivo){

            //Instanciar el objeto
            $administrador = new Administrador();
            //Crear el objeto
            $administrador -> setActivo(1);
            $administrador -> setNombre($nombre);
            $administrador -> setApellido($apellidos);
            $administrador -> setFechanacimiento($fechaNacimiento);
            $administrador -> setNumerotelefono($telefono);
            $administrador -> setCorreo($email);
            $administrador -> setClave($clave);
            $administrador -> setFecharegistro(date('y-m-d'));
            $administrador -> setFoto($nombreArchivo);
            try{
                //Ejecutar la consulta
                $guardado = $administrador -> guardar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('guardaradministradorerror', "Esta direccion de correo ya existe", '?controller=AdministradorController&action=registro');
                die();
            }
            return $guardado;
        }

        /*
        Funcion para guardar el administrador en la base de datos
        */

        public function guardar(){

            //Comprobar si los datos están llegando
            if(isset($_POST)){

                //Comprobar si cada dato existe
                $nombre = isset($_POST['nombreadmin']) ? $_POST['nombreadmin'] : false;
                $apellidos = isset($_POST['apellidosadmin']) ? $_POST['apellidosadmin'] : false;
                $fechaNacimiento = isset($_POST['fechaNacimientoadmin']) ? $_POST['fechaNacimientoadmin'] : false;
                $telefono = isset($_POST['telefonoadmin']) ? $_POST['telefonoadmin'] : false;
                $email = isset($_POST['emailadmin']) ? $_POST['emailadmin'] : false;
                $clave = isset($_POST['passwordadmin']) ? $_POST['passwordadmin'] : false;
                $archivo = $_FILES['foto'];
                $foto = $archivo['name'];

                //Comprobar si todos los datos exsiten
                if($nombre && $apellidos && $fechaNacimiento && $telefono && $clave && $email){

                    //Comprobar si la contraseña es valida
                    $claveSegura = Ayudas::comprobarContrasenia($clave);
                    
                    //Comprobar si todo esta correcto para guardar el administrador
                    if($claveSegura){

                        //Comprobar si la foto es valida
                        $fotoGuardada = Ayudas::guardarImagen($archivo, "ImagenesAdministradores");

                        //Comprobar si la foto ha sido guardada
                        if($fotoGuardada){

                            //Comprobar si se ha guardado con exito
                            $guardado = $this -> guardarAdministrador($nombre, $apellidos, $fechaNacimiento, $telefono, $email, $clave, $foto);

                            //Comprobar si el administrador ha sido guardado
                            if($guardado){

                               Ayudas::iniciarSesionAdmnistrador($email, $clave);
                            }else{
                                //Crear la sesion y redirigir a la ruta pertinente
                                Ayudas::crearSesionYRedirigir("guardaradministradorerror", "Ha ocurrido un error al guardar el administrador", "?controller=AdministradorController&action=registro");
                            }
                        }else{

                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir("guardaradministradorerror", "La imagen debe ser de tipo imagen", "?controller=AdministradorController&action=registro");
                        }
                    }else{

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir("guardaradministradorerror", "La clave debe contener un mayuscula, miniscula, numero, caracter especial y minimo 8 caracteres de longitud", "?controller=AdministradorController&action=registro");
                    }       
                }else{

                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir("guardaradministradorerror", "Ha ocurrido un error al guardar el administrador", "?controller=AdministradorController&action=registro");
                }
            }else{

                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir("guardaradministradorerror", "Ha ocurrido un error al guardar el administrador", "?controller=AdministradorController&action=registro");
            }
        }

        /*
        Funcion para eliminar el administrador
        */

        public function eliminarAdministrador($idAdmin){

            //Instanciar el objeto
            $administrador = new Administrador();
            //Crear objeto
            $administrador -> setId($idAdmin);
            //Ejecutar la consulta
            $eliminado = $administrador -> eliminar();
            //Retornar el resultado
            return $eliminado;
        }

        /*
        Funcion para eliminar la cuenta del administrador de la base de datos
        */

        public function eliminar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idAdmin = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idAdmin){

                    $eliminado = $this -> eliminarAdministrador($idAdmin);

                    //Comprobar si el administrador ha sido eliminado exitosamente
                    if($eliminado){

                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminaradministradoracierto', "El administrador ha sido eliminado exitosamente", '?controller=VideojuegoController&action=inicio');
                        //Eliminar el inicio de sesion
                        Ayudas::eliminarSesion('loginexitosoa');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminaradministradorerror', "El administrador no ha sido eliminado exitosamente", '?controller=AdminsitradorController&action=miPerfil');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminaradministradorerror', "Ha ocurrido un error al eliminar el adminsitrador", '?controller=Adminsitrador&action=miPerfil');
                }
            }
        }

        public function verBloqueos(){
            $bloqueo = new Bloqueo();
            $listaBloqueos = $bloqueo -> obtenerListaBloqueos();
            require_once "Vistas/Administrador/VerBloqueos.html";
        }

        /*
        Funcion para gestionar los usuarios
        */

        public function gestionarUsuario(){
            //Instanciar el objeto
            $usuario = new Usuario();
            //Listar todos los usuarios desde la base de datos
            $listadoUsuarios = $usuario -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionUsuarios.html";
        }

        /*
        Funcion para gestionar las categorias
        */

        public function gestionarCategoria(){
            //Instanciar el objeto
            $categoria = new Categoria();
            //Listar todas las categorias desde la base de datos
            $listadoCategorias = $categoria -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionCategorias.html";
        }

        /*
        Funcion para gestionar las tarjetas
        */

        public function gestionarTarjeta(){
            //Instanciar el objeto
            $medioPago = new MedioPago();
            //Listar todas las tarjetas desde la base de datos
            $listadoTarjetas = $medioPago -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionMediosPago.html";
        }

        /*
        Funcion para gestionar los usos
        */

        public function gestionarUso(){
            //Instanciar el objeto
            $uso = new Uso();
            //Listar todos los usos desde la base de datos
            $listadoUsos = $uso -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionUsos.html";
        }

        /*
        Funcion para gestionar las consolas
        */

        public function gestionarConsola(){
            //Instanciar el objeto
            $consola = new Consola();
            //Listar todas las consolas desde la base de datos
            $listadoConsolas = $consola -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionConsolas.html";
        }

        /*
        Funcion para crear un estado
        */

        public function gestionarEstado(){
            //Instanciar el objeto
            $estado = new Estado();
            //Listar todos los estados desde la base de datos
            $listadoEstados = $estado -> listar();
            //Incluir la vista
            require_once "Vistas/Administrador/GestionEstados.html";
        }

        /*
        Funcion para eliminar un usuario
        */

        public function eliminarUsuarioDesdeAdministrador($idUsu){

            //Instanciar el objeto
            $usuario = new Usuario();
            //Crear objeto
            $usuario -> setId($idUsu);
            //Ejecutar la consulta
            $eliminado = $usuario -> eliminar();
            //Retornar el resultado
            return $eliminado;
        }

        /*
        Funcion para eliminar un usuario desde el administrador
        */

        public function eliminarUsuario(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET)){

                //Comprobar si el dato existe
                $idUsuario = isset($_GET['id']) ? $_GET['id'] : false;

                //Si el dato existe
                if($idUsuario){

                    //Ejecutar la consulta
                    $eliminado = $this -> eliminarUsuarioDesdeAdministrador($idUsuario);

                    //Comprobar si el usuario ha sido eliminado
                    if($eliminado){
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminaradministradorusuarioacierto', "El usuario ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarUsuario');
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('eliminaradministradorusuarioerror', "El usuario no ha sido eliminado exitosamente", '?controller=AdministradorController&action=gestionarUsuario');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('eliminaradministradorusuarioerror', "Ha ocurrido un error al eliminar el usuario", '?controller=AdministradorController&action=gestionarUsuario');
                }
            }
        }

        /*
        Funcion para actuazliar el administrador
        */

        public function actualizarAdministrador($id, $nombre, $apellidos, $email, $telefono, $foto){

            //Instanciar el objeto
            $administrador = new Administrador();
            //Crear objeto
            $administrador -> setId($id);
            $administrador -> setNombre($nombre);
            $administrador -> setApellido($apellidos);
            $administrador -> setCorreo($email);
            $administrador -> setNumerotelefono($telefono);
            $administrador -> setFoto($foto);
            try{
                //Ejecutar la consulta
                $actualizado = $administrador -> actualizar();
            }catch(mysqli_sql_exception $excepcion){
                //Crear la sesion y redirigir a la ruta pertinente
                Ayudas::crearSesionYRedirigir('actualizaradministradorerror', "Esta direccion de correo ya existe", '?controller=AdministradorController&action=miPerfil');
                die();
            }
            return $actualizado;
        }

        /*
        Funcion para actualizar un administrador
        */

        public function actualizar(){
            
            //Comprobar si los datos están llegando
            if(isset($_GET) && isset($_POST)){

                //Comprobar si los datos existe
                $id = isset($_GET['id']) ? $_GET['id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
                $archivo = $_FILES['foto'];
                $foto = $archivo['name'];

                //Si el dato existe
                if($id && $nombre && $apellidos && $email && $telefono){

                    //Comprobar si el formato de la foto es imagen
                    if(Ayudas::comprobarImagen($archivo['type']) != 3){

                        if(Ayudas::comprobarImagen($archivo['type']) == 1){
                            //Comprobar la foto
                            Ayudas::guardarImagen($archivo, "ImagenesAdministradores");
                        }

                        //Llamar la funcion de actualizar
                        $actualizado = $this -> actualizarAdministrador($id, $nombre, $apellidos, $email, $telefono, $foto);

                        if($actualizado){
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('actualizaradministradoracierto', "Administrador actualizado con exito", '?controller=AdministradorController&action=miPerfil');
                        }else{
                            //Crear la sesion y redirigir a la ruta pertinente
                            Ayudas::crearSesionYRedirigir('actualizaradministradorsugerencia', "Agrega nuevos datos", '?controller=AdministradorController&action=miPerfil');
                        }
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizaradministradorerror', "El formato de la foto debe ser una imagen", '?controller=AdministradorController&action=miPerfil');
                    }
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizaradministrador', "Ha ocurrido un error al actualizar el administrador", '?controller=AdministradorController&action=miPerfil');
                } 
            }
        }

        
        public function comprobarClaves($actual){

            $administrador = new Administrador();
            $correo = $_SESSION['loginexitosoa'] -> correo;
            $claveAdministrador = $administrador -> traerClave($correo);
            $alho = password_verify($actual, $claveAdministrador -> clave);
            if($alho){
                return true;
            }

        }

        public function actualizarNuevaClave($clave){

            //Instanciar el objeto
            $administrador = new Administrador();
            //Crear objeto
            $administrador -> setId($_SESSION['loginexitosoa'] -> id);
            $administrador -> setClave($clave);
            //Ejecutar la consulta
            $actualizado = $administrador -> actualizarClave();
            return $actualizado;
        }

        public function actualizarClave(){
            
            //Comprobar si los datos están llegando
            if(isset($_POST)){

                $actual = isset($_POST['passwordactual']) ? $_POST['passwordactual'] : false;
                $nueva = isset($_POST['passwordnueva']) ? $_POST['passwordnueva'] : false;

                //Si el dato existe
                if($actual && $nueva){
                    $seguta = Ayudas::comprobarContrasenia($nueva);
                    if($seguta){
                        if($this -> comprobarClaves($actual)){
                            $actualizada = $this -> actualizarNuevaClave($nueva);
                            if($actualizada){
                                Ayudas::crearSesionYRedirigir('actualizarclaveacierto', "La clave ha sido actualizada con exito", '?controller=AdministradorController&action=cambiarClave');
                            }else{
                                Ayudas::crearSesionYRedirigir('actualizarclaveerror', "La clave no ha sido actualizada con exito", '?controller=AdministradorController&action=cambiarClave');
                            }
                        }else{
                            Ayudas::crearSesionYRedirigir('actualizarclaveerror', "Clave actual incorrecta", '?controller=AdministradorController&action=cambiarClave');
                        }
                    }else{
                        //Crear la sesion y redirigir a la ruta pertinente
                        Ayudas::crearSesionYRedirigir('actualizarclaveerror', "Clave poco segura", '?controller=AdministradorController&action=cambiarClave');
                    }
                    
                }else{
                    //Crear la sesion y redirigir a la ruta pertinente
                    Ayudas::crearSesionYRedirigir('actualizarclaveerror', "Ha ocurrido un error al actualizar la clave", '?controller=AdministradorController&action=cambiarClave');
                }
            }
        }
    }
?>