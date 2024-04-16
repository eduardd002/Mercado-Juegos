<?php

    class TransaccionVideojuego{

        private $id;
        private $idTransaccion;
        private $idVideojuego;
        private $unidades;
        private $db;

        public function __construct(){
            $this -> db = BaseDeDatos::connect();
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }
 
        public function getIdTransaccion(){
            return $this->idTransaccion;
        }

        public function setIdTransaccion($idTransaccion){
            $this->idTransaccion = $idTransaccion;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        public function getUnidades(){
            return $this->unidades;
        }

        public function setUnidades($unidades){
            $this->unidades = $unidades;
            return $this;
        }

        /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO transaccionvideojuego VALUES(NULL, {$this -> getIdTransaccion()}, 
                {$this -> getIdVideojuego()}, {$this -> getUnidades()})";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
            //Establecer una variable bandera
            $resultado = false;
            //Comprobar el registro fue exitoso y el total de columnas afectadas se altero
            if($registro){
                //Cambiar el estado de la variable bandera
                $resultado = true;
            }
            //Retornar el resultado
            return $resultado;
        }

        
        public function obtenerVideojuegoTransaccion($factura){
            $consulta = "SELECT tv.unidades, v.precio, v.idUsuario AS 'idUsuario'
            FROM transaccionvideojuego tv
                INNER JOIN videojuegos v ON v.id = tv.idVideojuego
                INNER JOIN usuarios u ON u.id = v.idUsuario
                INNER JOIN transacciones t ON t.id = tv.idTransaccion
                WHERE t.numeroFactura = $factura";
            $resultado = $this -> db -> query($consulta);
            return $resultado;
        }
    }

?>