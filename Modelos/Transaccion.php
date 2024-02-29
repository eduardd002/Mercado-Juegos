<?php

    class Transaccion{

        private $id;
        private $idComprador;
        private $idVendedor;
        private $idPago;
        private $idEstado;
        private $departamento;
        private $municipio;
        private $codigoPostal;
        private $barrio;
        private $direccion;
        private $nombreComprador;
        private $apellidoComprador;
        private $correoComprador;
        private $telefonoComprador;
        private $total;
        private $fechaRelizacion;
        private $horaRealizacion;

        public function __construct(){
            BaseDeDatos::connect();
        }        
    }

?>