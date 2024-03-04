<?php

    // Configura el tiempo de vida de la sesión en segundos
    $tiempo_vida = 3600; // Por ejemplo, 1 hora

    // Configura el tiempo de vida de la cookie de sesión
    session_set_cookie_params($tiempo_vida);

    // Establece la duración máxima de la sesión
    ini_set('session.gc_maxlifetime', $tiempo_vida);

    // Define el dominio para la cookie de sesión
    $dominio = $_SERVER['HTTP_HOST'];

    // Establece la bandera 'secure' para la cookie de sesión si estás utilizando HTTPS
    $secure = isset($_SERVER['HTTPS']);

    // Establece la bandera 'httponly' para la cookie de sesión
    $httpOnly = true;

    // Configura la cookie de sesión con los parámetros anteriores
    session_set_cookie_params($tiempo_vida, '/', $dominio, $secure, $httpOnly);

    // Activa la sesión
    session_start();

    //session_destroy();

    //Incluir los archivo de configuracion de rutas
    require_once 'Configuracion/Rutas.php';
    //Incluir archivo de configuracion de base de datos
    require_once 'Configuracion/BaseDeDatos.php';
    //Incluir los archivo de autocarga de controladores
    require_once 'autoload.php';
    //Incluir los archivos de las vistas
    require_once 'Vistas/Layout/Cabecera.html';
    require_once 'Vistas/Layout/Categorias.html';
    
    //Funcion para mostrar un error
    function showError(){
        $error = new ErrorController();
        $error -> index();
        return $error;
    }

    //Compruebo si me llega el controlador por la URL 
    if(isset($_GET['controller'])){
        $nombre = $_GET['controller'];
    }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
        if(isset($_SESSION['administrar'])){
            $nombre = "UsuarioController";
        }else{
            $nombre = "VideojuegoController";
        }
    }else{
        showError();
        exit();
    }

    //Compruebo si existe el controladorS
    if(class_exists($nombre)){
        
        //Si existe la clase se crea el objeto
        $controlador = new $nombre();

        //Compruebo si me llega la acción y si el metodo existe dentro del controlador
        if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){

            //Si existe invocar o llamar a ese metodo
            $action = $_GET['action'];
            $controlador -> $action();
        }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
            if(isset($_SESSION['administrar'])){
                $actionDefault = "Administrar";
            }else{
                $actionDefault = "Inicio";
            }
            $controlador -> $actionDefault();
        }else{
            showError();
        }
    }else{
        showError();
    }

    //Incluir los archivos de las vistas
    require_once 'Vistas/Layout/PieDePagina.html';

?>