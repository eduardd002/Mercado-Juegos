<?php

    //Conexion a la base de datos

    class BaseDeDatos{
        
        //Funcion para conectar la base de datos al proyecto

        public static function connect() {
            //Instancia de clase, por parametros se pasan el nombre del servidor, 
            //el usuario, la clae y el nombre de la base de datos
            $db = new mysqli('localhost', 'root', '', 'mercadoJuegos');
            //Se indica el tipamiento de datos
            $db -> query("SET NAMES 'utf8'");
            //Se retorna la base de datos
            return $db;
        }
        
    }

?>