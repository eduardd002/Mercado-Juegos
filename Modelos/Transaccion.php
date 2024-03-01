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

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
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
    }

?>