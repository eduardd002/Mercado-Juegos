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

        public function actualizar(){
            //Construir la consulta
            $consulta = "UPDATE videojuegos SET precio = {$this -> getPrecio()}, stock = {$this -> getStock()} 
            WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $actualizado = $this -> db -> query($consulta);
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($actualizado && mysqli_affected_rows($this -> db) > 0){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }

        /*
        Funcion para traer un videojuego
        */

        public function traerUno(){
            //Construir la consulta
            $consulta = "SELECT v.*, v.id AS 'idVideojuego', u.id AS 'idVendedor'
                FROM UsuarioVideojuego uv
                INNER JOIN Videojuegos v ON v.id = uv.idVideojuego 
                INNER JOIN Usuarios u ON u.id = uv.idUsuario 
                WHERE idVideojuego = {$this -> getId()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $videojuego = $resultado -> fetch_object();
            //Retornar resultado
            return $videojuego;
        }

        /*
        Funcion para obtener el ultimo videojuego registrado
        */

        public function ultimo(){
            //Construir la consulta
            $consulta = "SELECT id FROM videojuegos ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimoVideojuego = $ultimo -> id;
            //Retornar el resultado
            return $ultimoVideojuego;
        }

        public function eliminar(){

            //Construir la consulta
            $consulta = "DELETE FROM videojuegos WHERE id = {$this -> id}";
            //Ejecutar la consulta
            $eliminado = $this -> db -> query($consulta);
            var_dump($eliminado);
            die();
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($eliminado){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }

        /*
        Funcion para listar todos los videojuegos
        */

        public function listarTodos(){
            //Construir la consulta
            $consulta = "SELECT * FROM videojuegos ORDER BY id DESC";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        /*
        Funcion para listar algunos de los videojuegos, en concreto 6
        */

        public function listarAlgunos(){
            //Construir la consulta
            $consulta = "SELECT * FROM videojuegos ORDER BY RAND() LIMIT 6";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        public function filtro($minimo, $maximo){
            // Construir la consulta inicial sin cláusula WHERE
            $consulta = "SELECT * FROM videojuegos";
        
            // Array para almacenar las condiciones de filtro
            $condiciones = [];
        
            // Aplicar filtro por idConsola si está establecido
            if($this->getIdConsola() != 'null'){
                $condiciones[] = "idConsola = {$this->getIdConsola()}";
            }
        
            // Aplicar filtro por idUso si está establecido
            if($this->getIdUso() != 'null'){
                $condiciones[] = "idUso = {$this->getIdUso()}";
            }
        
            // Aplicar filtro por precio mínimo si está establecido
            if($minimo != ''){
                $condiciones[] = "precio >= {$minimo}";
            }
        
            // Aplicar filtro por precio máximo si está establecido
            if($maximo != ''){
                $condiciones[] = "precio <= {$maximo}";
            }
        
            // Si hay condiciones, agregar la cláusula WHERE
            if (!empty($condiciones)) {
                $consulta .= " WHERE " . implode(" AND ", $condiciones);
            }
        
            // Ejecutar la consulta
            $resultado = $this->db->query($consulta);
        
            // Retornar resultado
            return $resultado;
        }
        
    }

?>