<?php

    //OB_START(); para
    ob_start();

    // Activar la sesión
    session_start();

    //session_destroy();

    //var_dump($_SESSION);

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