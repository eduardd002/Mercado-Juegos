<?php

    /*
    Clase modelo de videojuego
    */

    class Videojuego{

        private $id;
        private $idUsuario;
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
        Funcion getter de id usuario
        */

        public function getIdUsuario(){
            /*Retornar el resultado*/
            return $this->idUsuario;
        }

        /*
        Funcion setter de id de usuario
        */

        public function setIdUsuario($idUsuario){
            /*Llamar parametro*/
            $this->idUsuario = $idUsuario;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id de consola
        */

        public function getIdConsola(){
            /*Retornar el resultado*/
            return $this->idConsola;
        }

        /*
        Funcion setter de id de consola
        */

        public function setIdConsola($idConsola){
            /*Llamar parametro*/
            $this->idConsola = $idConsola;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de id de uso
        */

        public function getIdUso(){
            /*Retornar el resultado*/
            return $this->idUso;
        }

        /*
        Funcion setter de id de uso
        */

        public function setIdUso($idUso){
            /*Llamar parametro*/
            $this->idUso = $idUso;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de nombre
        */

        public function getNombre(){
            /*Retornar el resultado*/
            return $this->nombre;
        }

        /*
        Funcion setter de nombre
        */

        public function setNombre($nombre){
            /*Llamar parametro*/
            $this->nombre = $nombre;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de precio
        */

        public function getPrecio(){
            /*Retornar el resultado*/
            return $this->precio;
        }

        /*
        Funcion setter de precio
        */

        public function setPrecio($precio){
            /*Llamar parametro*/
            $this->precio = $precio;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de descripcion
        */

        public function getDescripcion(){
            /*Retornar el resultado*/
            return $this->descripcion;
        }

        /*
        Funcion setter de descripcion
        */

        public function setDescripcion($descripcion){
            /*Llamar parametro*/
            $this->descripcion = $descripcion;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de foto
        */

        public function getFoto(){
            /*Retornar el resultado*/
            return $this->foto;
        }

        /*
        Funcion setter de foto
        */

        public function setFoto($foto){
            /*Llamar parametro*/
            $this->foto = $foto;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de fecha de creacion
        */

        public function getFechaCreacion(){
            /*Retornar el resultado*/
            return $this->fechaCreacion;
        }

        /*
        Funcion setter de fecha de creacion
        */

        public function setFechaCreacion($fechaCreacion){
            /*Llamar parametro*/
            $this->fechaCreacion = $fechaCreacion;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion getter de stock
        */

        public function getStock(){
            /*Retornar el resultado*/
            return $this->stock;
        }

        /*
        Funcion setter de stock
        */

        public function setStock($stock){
            /*Llamar parametro*/
            $this->stock = $stock;
            /*Retornar el resultado*/
            return $this;
        }

        /*
        Funcion para obtener el videojuego buscado, si existe
        */

        public function buscar(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT * FROM videojuegos WHERE nombre LIKE '%{$this -> getNombre()}%' AND activo = 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $lista = $this -> db -> query($consulta);
            /*Retornar el resultado*/
            return $lista;
        }

        /*
        Funcion para realizar el registro del videojuego en la base de datos
        */

        public function guardar(){
            /*Construir la consulta*/
            $consulta = "INSERT INTO videojuegos VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()}, {$this -> getIdConsola()}, 
                {$this -> getIdUso()}, '{$this -> getNombre()}', 
                {$this -> getPrecio()}, '{$this -> getDescripcion()}', 
                '{$this -> getFoto()}', '{$this -> getFechaCreacion()}', 
                {$this -> getStock()})";
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
        Funcion para actualizar el videojuego
        */

        public function actualizar(){
            /*Construir la consulta*/
            $consulta = "UPDATE videojuegos SET precio = {$this -> getPrecio()}, stock = {$this -> getStock()} 
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

        /*
        Funcion para traer un videojuego
        */

        public function traerUno(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT v.id AS 'idVideojuego', v.nombre AS 'nombreVideojuego', v.precio AS 'precioVideojuego', v.stock AS 'stockVideojuego', u.id AS 'idVendedor', us.nombre AS 'nombreUso', c.nombre 'categoriaNombre', v.foto AS 'imagenVideojuego', v.descripcion AS 'descripcionVideojuego', co.nombre AS 'nombreConsola'
                FROM Videojuegos v
                INNER JOIN Usuarios u ON u.id = v.idUsuario 
                INNER JOIN Usos us ON us.id = v.idUso
                INNER JOIN Consolas co ON co.id = v.idConsola
                INNER JOIN VideojuegoCategoria cv ON cv.idVideojuego = v.id
                INNER JOIN Categorias c ON cv.idCategoria = c.id
                WHERE v.id = {$this -> getId()} AND v.activo = 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $resultados = $this->db->query($consulta);
            /*Array para almacenar la información del videojuego*/
            $informacionUsuario = array();
            /*Mientras hayan videojuegos disponibles para recorrer*/
            while ($fila = $resultados->fetch_object()) {
                /*Crear array con informacion del videojuego*/
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
                    /*Inicializar un array para almacenar los videojuegos*/
                    'categorias' => array()
                );
                /*Almacenar la información de la categoria en el array de videojuego y categoria*/
                $informacionUsuario['videojuego']['categorias'][] = array(
                    'categoriaNombre' => $fila->categoriaNombre,
                );
            }
            /*Retornar el resultado*/
            return $informacionUsuario;     
        }

        /*
        Funcion para obtener el ultimo videojuego registrado
        */

        public function ultimo(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT id FROM videojuegos ORDER BY id DESC LIMIT 1";
            /*Llamar la funcion que ejecuta la consulta*/
            $resultado = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $ultimo = $resultado -> fetch_object();
            /*Devolver resultado*/
            $ultimoVideojuego = $ultimo -> id;
            /*Retornar el resultado*/
            return $ultimoVideojuego;
        }

        /*
        Funcion para eliminar un videojuego
        */

        public function eliminar(){
            /*Construir la consulta*/
            $consulta = "UPDATE videojuegos SET activo = 0 WHERE id = {$this -> getId()}";
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
        Funcion para actualizar el stock de un videojuego
        */

        public function actualizarStock(){
            /*Construir la consulta*/
            $consulta = "UPDATE videojuegos SET stock = {$this -> getStock()} WHERE id = {$this -> getId()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $actualizado = $this -> db -> query($consulta);
            /*Establecer una variable bandera*/
            $bandera = false;
            /*Comprobar si la consulta fue exitosa*/
            if($actualizado){
                /*Cambiar el estado de la variable bandera*/    
                $bandera = true;
            }
            /*Retornar el resultado*/
            return $bandera;
        }

        /*
        Funcion para agregar un filtro de busqueda a los videojuegos
        */

        public function filtro($minimo, $maximo, $idCategoria){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT v.* 
                FROM videojuegocategoria cv
                INNER JOIN videojuegos v ON v.id = cv.idVideojuego
                INNER JOIN categorias c ON c.id = cv.idCategoria 
                WHERE v.activo = 1";
            /*Crear array para almacenar las condiciones de filtro*/
            $condiciones = [];
            /*Comprobar si la consola llega como opcion a filtrar*/
            if($this->getIdConsola() != 'null'){
                /*Agregar al array de filtro la condicion*/
                $condiciones[] = "v.idConsola = {$this->getIdConsola()}";
            }
            /*Comprobar si el uso llega como opcion a filtrar*/
            if($this->getIdUso() != 'null'){
                /*Agregar al array de filtro la condicion*/
                $condiciones[] = "v.idUso = {$this->getIdUso()}";
            }
            /*Comprobar si el precio minimo llega como opcion a filtrar*/
            if($minimo != ''){
                /*Agregar al array de filtro la condicion*/
                $condiciones[] = "v.precio >= {$minimo}";
            }
            /*Comprobar si el precio maximo llega como opcion a filtrar*/
            if($maximo != ''){
                /*Agregar al array de filtro la condicion*/
                $condiciones[] = "v.precio <= {$maximo}";
            }
            /*Comprobar si la cateogoria llega como opcion a filtrar*/
            if($idCategoria != 'null'){
                /*Agregar al array de filtro la condicion*/
                $condiciones[] = "cv.idCategoria = {$idCategoria}";
            }
            /*Comprobar si el array de condiciones llega con datos*/
            if (!empty($condiciones)) {
                /*Agregar las condiciones del filtro*/
                $consulta .= " AND " . implode(" AND ", $condiciones);
            }
            /*Llamar la funcion que ejecuta la consulta*/
            $resultado = $this->db->query($consulta);
            /*Retornar el resultado*/
            return $resultado;
        }

        /*
        Funcion para obtener el usuario vendedor
        */

        public function obtenerUsuarioVendedor(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT id AS 'idVendedor', nombre AS 'nombreVendedor' FROM usuarios WHERE id IN (SELECT idUsuario FROM videojuegos WHERE id = {$this -> getId()})";
            /*Llamar la funcion que ejecuta la consulta*/
            $resultado = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $nombre = $resultado -> fetch_object();
            /*Retornar el resultado*/
            return $nombre;
        }

        /*
        Funcion para obtener el usuario dueño del videojuego creado
        */

        public function obtenerUsuarioVideojuego(){
            /*Construir la consulta*/
            $consulta = "SELECT DISTINCT idUsuario FROM videojuegos WHERE id = {$this -> getId()}";
            /*Llamar la funcion que ejecuta la consulta*/
            $resultado = $this -> db -> query($consulta);
            /*Obtener el resultado*/
            $usuario = $resultado -> fetch_object();
            /*Retornar el resultado*/
            return $usuario;
        }

    }

?>