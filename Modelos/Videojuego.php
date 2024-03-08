<?php

    class Videojuego{

        private $id;
        private $idConsola;
        private $idUso;
        private $nombre;
        private $precio;
        private $descripcion;
        private $foto;
        private $fechaCreacion;
        private $stock;
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

        public function getIdConsola(){
            return $this->idConsola;
        }

        public function setIdConsola($idConsola){
            $this->idConsola = $idConsola;
            return $this;
        }

        public function getIdUso(){
            return $this->idUso;
        }

        public function setIdUso($idUso){
            $this->idUso = $idUso;
            return $this;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
            return $this;
        }

        public function getPrecio(){
            return $this->precio;
        }

        public function setPrecio($precio){
            $this->precio = $precio;
            return $this;
        }

        public function getDescripcion(){
            return $this->descripcion;
        }

        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
            return $this;
        }

        public function getFoto(){
            return $this->foto;
        }

        public function setFoto($foto){
            $this->foto = $foto;
            return $this;
        }

        public function getFechaCreacion(){
            return $this->fechaCreacion;
        }

        public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
            return $this;
        }

        public function getStock(){
            return $this->stock;
        }

        public function setStock($stock){
            $this->stock = $stock;
            return $this;
        }

        /*
        Funcion para obtener el videojuego buscado, si existe
        */

        public function buscar(){
            //Construir la consulta
            $consulta = "SELECT * FROM videojuegos WHERE nombre LIKE '%{$this -> getNombre()}%'";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para realizar el registro del videojuego en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO videojuegos VALUES(NULL, {$this -> getIdConsola()}, 
                {$this -> getIdUso()}, '{$this -> getNombre()}', 
                {$this -> getPrecio()}, '{$this -> getDescripcion()}', 
                '{$this -> getFoto()}', '{$this -> getFechaCreacion()}', 
                {$this -> getStock()})";
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
        Funcion para obtener el id del ultimo videojuego registrado
        */

        public function proximoVideojuego(){
            //Construir la consulta
            $consulta = "SELECT id FROM videojuegos ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $identificadorFuturo = $resultado -> fetch_object();
            //Retornar el resultado
            return $identificadorFuturo;
        }
    }

?>