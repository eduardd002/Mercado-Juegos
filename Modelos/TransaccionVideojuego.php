<?php

    /*
    Clase modelo de transaaccion videojuego
    */

    class TransaccionVideojuego{

        private $id;
        private $idTransaccion;
        private $idVideojuego;
        private $unidades;
        private $db;

        /*
        Funcion constructor
        */

        public function __construct(){
            /*Llamar conexion a la base de datos*/  
            $this -> db = BaseDeDatos::connect();
        }

        /*
        Funcion getter de id
        */

        public function getId(){
            /*Retornar el resultado*/
            return $this->id;
        }

        /*
        Funcion setter de id
        */

        public function setId($id){
            /*Llamar parametro*/
            $this->id = $id;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id transaccion
        */
 
        public function getIdTransaccion(){
            /*Retornar el resultado*/
            return $this->idTransaccion;
        }

        /*
        Funcion setter de id transaccion
        */

        public function setIdTransaccion($idTransaccion){
            /*Llamar parametro*/
            $this->idTransaccion = $idTransaccion;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id videojuego
        */

        public function getIdVideojuego(){
            /*Retornar el resultado*/
            return $this->idVideojuego;
        }

        /*
        Funcion setter de id videojuego
        */

        public function setIdVideojuego($idVideojuego){
            /*Llamar parametro*/
            $this->idVideojuego = $idVideojuego;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de unidades
        */

        public function getUnidades(){
            /*Retornar el resultado*/
            return $this->unidades;
        }

        /*
        Funcion setter de unidades
        */

        public function setUnidades($unidades){
            /*Llamar parametro*/
            $this->unidades = $unidades;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            /*Construir consulta*/
            $consulta = "INSERT INTO transaccionvideojuego VALUES(NULL, {$this -> getIdTransaccion()}, 
                {$this -> getIdVideojuego()}, {$this -> getUnidades()})";
            /*Llamar la funcion que ejecuta la consulta*/
            $registro = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $resultado = false;
            /*Comprobar si la consulta fue exitosa*/
            if($registro){
                /*Cambiar el estado de la variable bandera*/
                $resultado = true;
            }
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para obtener el videojuego de la transaccion
        */

        public function obtenerVideojuegoTransaccion($factura){
            /*Construir consulta*/
            $consulta = "SELECT tv.unidades, v.precio, v.idUsuario AS 'idUsuario'
            FROM transaccionvideojuego tv
                INNER JOIN videojuegos v ON v.id = tv.idVideojuego
                INNER JOIN usuarios u ON u.id = v.idUsuario
                INNER JOIN transacciones t ON t.id = tv.idTransaccion
                WHERE t.numeroFactura = $factura";
            /*Llamar la funcion que ejecuta la consulta*/                
            $resultado = $this -> db -> query($consulta);
            /*Retornar el resultado*/
            return $resultado;
        }
        
    }

?>