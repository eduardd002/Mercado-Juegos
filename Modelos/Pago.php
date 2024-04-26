<?php

    /*
    Clase modelo de pago
    */

    class Pago{

        private $id;
        private $activo;
        private $idUsuario;
        private $idMedioPago;
        private $numero;
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
        Funcion getter de activo
        */

        public function getActivo(){
            /*Retornar el resultado*/
            return $this->activo;
        }

        /*
        Funcion setter de activo
        */

        public function setActivo($activo){
            /*Llamar parametro*/
            $this->activo = $activo;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id medio pago
        */

        public function getIdMedioPago(){
            /*Retornar el resultado*/
            return $this->idMedioPago;
        }

        /*
        Funcion setter de id medio pago
        */

        public function setIdMedioPago($idMedioPago){
            /*Llamar parametro*/
            $this->idMedioPago = $idMedioPago;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de numero
        */

        public function getNumero(){
            /*Retornar el resultado*/
            return $this->numero;
        }

        /*
        Funcion setter de numero
        */

        public function setNumero($numero){
            /*Llamar parametro*/
            $this->numero = $numero;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id usuario
        */

        public function getIdUsuario(){
            /*Retornar el resultado*/
            return $this->idUsuario;
        }

        /*
        Funcion setter de id usuario
        */

        public function setIdUsuario($idUsuario){
            /*Llamar parametro*/
            $this->idUsuario = $idUsuario;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            /*Construir la consulta*/
            $consulta = "INSERT INTO pagos VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()}, {$this -> getIdMedioPago()}, 
                '{$this -> getNUmero()}')";
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
        Funcion para obtener un pago
        */

        public function obtenerUno(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT p.numero AS 'numeroPago', mp.nombre AS 'nombreMedioPago', p.id AS 'idMedioPago'
                FROM Pagos p
                INNER JOIN MediosPago mp ON p.idMedioPago = mp.id
                WHERE p.id = {$this -> id} AND p.activo = 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $uso = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $resultado = $uso -> fetch_object();
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para eliminar el uso
        */

        public function eliminar(){
            /*Construir la consulta*/
            $consulta = "UPDATE pagos SET activo = FALSE WHERE id = {$this -> getId()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $eliminado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa*/
            if($eliminado){
                /*Cambiar el estado de la variable bandera*/
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

        /*
        Funcion para actualizar el uso
        */

        public function actualizar(){
            /*Construir la consulta*/
            $consulta = "UPDATE pagos SET idMedioPago = '{$this -> getIdMedioPago()}', numero = '{$this -> getNumero()}' 
                WHERE id = {$this -> getId()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $actualizado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa y el total de columnas afectadas se altero llamando la ejecucion de la consulta*/
            if($actualizado && mysqli_affected_rows($this -> db) > 0){
                /*Cambiar el estado de la variable bandera*/
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

    }

?>