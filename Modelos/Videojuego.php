<?php

    class Videojuego{

        private $id;
        private $activo;
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

        public function getActivo(){
            return $this->activo;
        }

        public function setActivo($activo){
            $this->activo = $activo;
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
            $consulta = "SELECT DISTINCT * FROM videojuegos WHERE nombre LIKE '%{$this -> getNombre()}%'";
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
            $consulta = "SELECT DISTINCT v.id AS 'idVideojuego', v.nombre AS 'nombreVideojuego', v.precio AS 'precioVideojuego', v.stock AS 'stockVideojuego', u.id AS 'idVendedor', us.nombre AS 'nombreUso', c.nombre 'categoriaNombre', v.foto AS 'imagenVideojuego', v.descripcion AS 'descripcionVideojuego', co.nombre AS 'nombreConsola'
                FROM UsuarioVideojuego uv
                INNER JOIN Videojuegos v ON v.id = uv.idVideojuego 
                INNER JOIN Usuarios u ON u.id = uv.idUsuario 
                INNER JOIN Usos us ON us.id = v.idUso
                INNER JOIN Consolas co ON co.id = v.idConsola
                INNER JOIN VideojuegoCategoria cv ON cv.idVideojuego = v.id
                INNER JOIN Categorias c ON cv.idCategoria = c.id
                WHERE uv.idVideojuego = {$this -> getId()}";
            // Ejecutar la consulta
            $resultados = $this->db->query($consulta);
        
            // Array para almacenar la información del usuario y sus videojuegos
            $informacionUsuario = array();
        
            // Recorrer los resultados de la consulta
            while ($fila = $resultados->fetch_object()) {
                // Verificar si ya se ha almacenado la información del usuario
                if (!isset($informacionUsuario['videojuego'])) {
                    // Si no se ha almacenado, almacenar la información del usuario
                    $informacionUsuario['videojuego'] = array(
                        'idVideojuego' => $fila->idVideojuego,
                        'nombreVideojuego' => $fila->nombreVideojuego,
                        'precioVideojuego' => $fila->precioVideojuego,
                        'nombreConsola' => $fila->nombreConsola,
                        'descripcionVideojuego' => $fila->descripcionVideojuego,
                        'imagenVideojuego' => $fila->imagenVideojuego,
                        'stockVideojuego' => $fila->stockVideojuego,
                        'idVendedor' => $fila->idVendedor,
                        'nombreUso' => $fila->nombreUso,
                        'categorias' => array() // Inicializar un array para almacenar los videojuegos del usuario
                    );
                }
        
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionUsuario['videojuego']['categorias'][] = array(
                    'categoriaNombre' => $fila->categoriaNombre,
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionUsuario;     
        }

        /*
        Funcion para obtener el ultimo videojuego registrado
        */

        public function ultimo(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT id FROM videojuegos ORDER BY id DESC LIMIT 1";
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
            $consulta = "UPDATE videojuegos WHERE id = {$this -> getId()}";
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
            $consulta = "SELECT DISTINCT * FROM videojuegos ORDER BY id DESC";
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
            $consulta = "SELECT DISTINCT * FROM videojuegos ORDER BY RAND() LIMIT 6";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        public function filtro($minimo, $maximo, $idCategoria){
            // Construir la consulta inicial sin cláusula WHERE
            $consulta = "SELECT DISTINCT v.* 
            FROM videojuegocategoria cv
            INNER JOIN videojuegos v ON v.id = cv.idVideojuego
            INNER JOIN categorias c ON c.id = cv.idCategoria";
            
            // Array para almacenar las condiciones de filtro
            $condiciones = [];
            
            // Aplicar filtro por idConsola si está establecido
            if($this->getIdConsola() != 'null'){
                $condiciones[] = "v.idConsola = {$this->getIdConsola()}";
            }
            
            // Aplicar filtro por idUso si está establecido
            if($this->getIdUso() != 'null'){
                $condiciones[] = "v.idUso = {$this->getIdUso()}";
            }
            
            // Aplicar filtro por precio mínimo si está establecido
            if($minimo != ''){
                $condiciones[] = "v.precio >= {$minimo}";
            }
            
            // Aplicar filtro por precio máximo si está establecido
            if($maximo != ''){
                $condiciones[] = "v.precio <= {$maximo}";
            }
        
            // Aplicar filtro por categoría si está establecido
            if($idCategoria != 'null'){
                $condiciones[] = "cv.idCategoria = {$idCategoria}";
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