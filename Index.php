<?php

    //OB_START(); para
    ob_start();

    //Incluir los archivos de las vistas
    require_once 'Configuracion/Rutas.php';
    require_once 'autoload.php';
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
        $nombre = "VideojuegoController";
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
            $actionDefault = "Inicio";
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