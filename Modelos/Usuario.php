<?php

    class Usuario{

        private $id;
        private $rol;
        private $nombre;
        private $apellido;
        private $fechanacimiento;
        private $numerotelefono;
        private $correo;
        private $clave;
        private $departamento;
        private $municipio;
        private $foto;
        private $fecharegistro;
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

        public function getRol(){
            return $this->rol;
        }

        public function setRol($rol){
            $this->rol = $rol;
            return $this;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
            return $this;
        }

        public function getApellido(){
            return $this->apellido;
        }

        public function setApellido($apellido){
            $this->apellido = $apellido;
            return $this;
        }

        public function getFechanacimiento(){
            return $this->fechanacimiento;
        }

        public function setFechanacimiento($fechanacimiento){
            $this->fechanacimiento = $fechanacimiento;
            return $this;
        }

        public function getNumerotelefono(){
            return $this->numerotelefono;
        }

        public function setNumerotelefono($numerotelefono){
            $this->numerotelefono = $numerotelefono;
            return $this;
        }

        public function getCorreo(){
            return $this->correo;
        }

        public function setCorreo($correo){
            $this->correo = $correo;
            return $this;
        }

        public function getClave(){
                return $this->clave;
        }

        public function setClave($clave){
            $this->clave = $clave;
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

        public function getFoto(){
            return $this->foto;
        }

        public function setFoto($foto){
            $this->foto = $foto;
            return $this;
        }

        public function getFecharegistro(){
            return $this->fecharegistro;
        }

        public function setFecharegistro($fecharegistro){
            $this->fecharegistro = $fecharegistro;
            return $this;
        }

        public function guardar(){

            //Construir la consulta
            $consulta = "INSERT INTO usuarios VALUES(NULL, '{$this -> getRol()}', 
                '{$this -> getNombre()}', '{$this -> getApellido()}', 
                '{$this -> getFechaNacimiento()}', {$this -> getNumeroTelefono()}, 
                '{$this -> getCorreo()}', '{$this -> getClave()}', 
                '{$this -> getDepartamento()}', '{$this -> getMunicipio()}', 
                '{$this -> getFoto()}', '{$this -> getFechaRegistro()}')";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
            $resultado = false;
            if($registro){
                $resultado = true;
            }
            return $resultado;
        }
    }

?>