<?php

    //OB_START(); para
    ob_start();

    // Configurar el tiempo de vida de la sesión en segundos, en este caso 1800 segundos(1/2 hora) para que la sesion
    // permanezca por ese tiempo incluso si se cierra una instancia del navegador, todas las instancias del navegador 
    //o se apaga el pc

    $tiempo_vida = 1800;

    // Configurar el tiempo de vida de la cookie de sesión
    session_set_cookie_params($tiempo_vida);

    // Establecer la duración máxima de la sesión
    ini_set('session.gc_maxlifetime', $tiempo_vida);

    // Definir el dominio para la cookie de sesión
    $dominio = $_SERVER['HTTP_HOST'];

    // Establecer la bandera 'secure' para la cookie de sesión como en este caso que se esta utilizando HTTPS
    $secure = isset($_SERVER['HTTPS']);

    // Establecer la bandera 'httponly' para la cookie de sesión
    $httpOnly = true;

    // Configura la cookie de sesión con cada parametro requerido
    session_set_cookie_params($tiempo_vida, '/', $dominio, $secure, $httpOnly);

    // Activar la sesión
    session_start();

    //session_destroy();

    //var_dump($_SESSION);

    // Verificar si la sesión está activa
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $tiempo_vida)) {
        // Si ha pasado más tiempo del tiempo de vida, destruir la sesión y mostrar el mensaje
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['caducidad'] = 'La sesion ha expirado';
        header("Location:"."http://localhost/Mercado-Juegos/?controller=VideojuegoController&action=inicio");
    } else {
        // Si no ha pasado más tiempo, actualizar la marca de tiempo de última actividad
        $_SESSION['last_activity'] = time();
    }

    //session_destroy();

    //Incluir los archivo de autocarga de controladores
    require_once 'Autoload.php';
    //Incluir los archivo de ayudas
    require_once 'Ayudas/Ayudas.php';
    //Incluir los archivo de configuracion de rutas
    require_once 'Configuracion/Rutas.php';
    //Incluir la clave de encriptacion
    Require_once 'Configuracion/Clave.php';
    //Incluir archivo de configuracion de base de datos
    require_once 'Configuracion/BaseDeDatos.php';
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
        if(isset($_SESSION['loginexitosoa'])){
            $nombre = "AdministradorController";
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
            if(isset($_SESSION['loginexitosoa'])){
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