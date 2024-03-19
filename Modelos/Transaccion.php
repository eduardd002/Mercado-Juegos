<?php

    class Transaccion{

        private $id;
        private $numeroFactura;
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

        public function getNumeroFactura(){
            return $this->numeroFactura;
        }

        public function setNumeroFactura($numeroFactura){
            $this->numeroFactura = $numeroFactura;
            return $this;
        }

        public function getIdComprador(){
            return $this->idComprador;
        }

        public function setIdComprador($idComprador){
            $this->idComprador = $idComprador;
            return $this;
        }

        public function getIdVendedor(){
            return $this->idVendedor;
        }

        public function setIdVendedor($idVendedor){
            $this->idVendedor = $idVendedor;
            return $this;
        }

        public function getIdPago(){
            return $this->idPago;
        }

        public function setIdPago($idPago){
            $this->idPago = $idPago;
            return $this;
        }

        public function getIdEstado(){
            return $this->idEstado;
        }

        public function setIdEstado($idEstado){
            $this->idEstado = $idEstado;
            return $this;
        }

        public function getDepartamento(){
            return $this->departamento;
        }

        public function setDepartamento($departamento){
            $this->departamento = $departamento;
            return $this;
        }

        public function getMunicipio(){
            return $this->municipio;
        }

        public function setMunicipio($municipio){
            $this->municipio = $municipio;
            return $this;
        }

        public function getCodigoPostal(){
            return $this->codigoPostal;
        }

        public function setCodigoPostal($codigoPostal){
            $this->codigoPostal = $codigoPostal;
            return $this;
        }

        public function getBarrio(){
            return $this->barrio;
        }

        public function setBarrio($barrio){
            $this->barrio = $barrio;
            return $this;
        }

        public function getDireccion(){
            return $this->direccion;
        }

        public function setDireccion($direccion){
            $this->direccion = $direccion;
            return $this;
        }

        public function getNombreComprador(){
            return $this->nombreComprador;
        }

        public function setNombreComprador($nombreComprador){
            $this->nombreComprador = $nombreComprador;
            return $this;
        }

        public function getApellidoComprador(){
            return $this->apellidoComprador;
        }

        public function setApellidoComprador($apellidoComprador){
            $this->apellidoComprador = $apellidoComprador;
            return $this;
        }

        public function getCorreoComprador(){
            return $this->correoComprador;
        }

        public function setCorreoComprador($correoComprador){
            $this->correoComprador = $correoComprador;
            return $this;
        }

        public function getTelefonoComprador(){
            return $this->telefonoComprador;
        }

        public function setTelefonoComprador($telefonoComprador){
            $this->telefonoComprador = $telefonoComprador;
            return $this;
        }

        public function getTotal(){
            return $this->total;
        }

        public function setTotal($total){
            $this->total = $total;
            return $this;
        }

        public function getFechaRelizacion(){
            return $this->fechaRelizacion;
        }

        public function setFechaRelizacion($fechaRelizacion){
            $this->fechaRelizacion = $fechaRelizacion;
            return $this;
        }

        public function getHoraRealizacion(){
            return $this->horaRealizacion;
        }

        public function setHoraRealizacion($horaRealizacion){
            $this->horaRealizacion = $horaRealizacion;
            return $this;
        }

        /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO transacciones VALUES(NULL, {$this -> getNumeroFactura()}, {$this -> getIdComprador()}, 
                {$this -> getIdVendedor()}, {$this -> getIdPago()}, {$this -> getIdEstado()}, 
                '{$this -> getDepartamento()}', '{$this -> getMunicipio()}', '{$this -> getCodigoPostal()}', 
                '{$this -> getBarrio()}', '{$this -> getDireccion()}', '{$this -> getNombreComprador()}', 
                '{$this -> getApellidoComprador()}', '{$this -> getCorreoComprador()}', '{$this -> getTelefonoComprador()}', 
                {$this -> getTotal()}, '{$this -> getFechaRelizacion()}', 
                '{$this -> getHoraRealizacion()}')";
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

        /*
        Funcion para obtener todas las ventas realizadas por un usuario
        */

        public function obtenerVentas(){
            //Construir la consulta
            $consulta = "SELECT * FROM transacciones WHERE idVendedor = {$this -> getIdVendedor()}";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar resultado
            return $lista;
        }

        /*
        Funcion para obtener todas las compras realizadas por un usuario
        */

        public function obtenerCompras(){
            //Construir la consulta
            $consulta = "SELECT * FROM transacciones WHERE idComprador = {$this -> getIdComprador()}";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar resultado
            return $lista;
        }

        /*
        Funcion para obtener el ultimo id de la transaccion
        */

        public function traerUltimoIdTransaccion(){
            //Construir la consulta
            $consulta = "SELECT id FROM transacciones ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener resultado
            $id = $resultado -> fetch_object();
            //Comprobar si existe un id
            if($id == null){
                $id = 0;
            }
            //Retornar resultado
            return $id;
        }
    }

?>