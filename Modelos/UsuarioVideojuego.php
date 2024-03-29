<?php

    class UsuarioVideojuego{

        private $id;
        private $idUsuario;
        private $idVideojuego;
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

        public function getIdUsuario(){
            return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario){
            $this->idUsuario = $idUsuario;
            return $this;
        }

        public function getIdVideojuego(){
            return $this->idVideojuego;
        }

        public function setIdVideojuego($idVideojuego){
            $this->idVideojuego = $idVideojuego;
            return $this;
        }

        /*
        Funcion para guardar la relacion entre videojuego y usuario en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO usuariovideojuego VALUES(NULL, {$this -> getIdUsuario()}, {$this -> getIdVideojuego()})";
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
        Funcion para obtener el usuario dueño del videojuego creado
        */

        public function obtenerUsuarioVideojuego(){
            //Construir la consulta
            $consulta = "SELECT idUsuario FROM usuariovideojuego WHERE idVideojuego = {$this -> getIdVideojuego()}";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener resultado
            $usuario = $resultado -> fetch_object();
            //Retornar el id del usuario
            return $usuario;
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

        /*
        Funcion para obtener el nombre del usuario que creo el videojuego
        */

        public function obtenerUsuarioVendedor(){
            //Construir la consulta
            $consulta = "SELECT id AS 'idVendedor', nombre AS 'nombreVendedor' FROM usuarios WHERE id IN (SELECT idUsuario FROM usuariovideojuego WHERE idVideojuego = {$this -> getIdVideojuego()})";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el nombre
            $nombre = $resultado -> fetch_object();
            //Retornar el resultado
            return $nombre;
        }

        public function obtenerVideojuegosCreadosPorUsuario(){
            $consulta = "SELECT v.nombre AS 'nombreVideojuego', v.precio AS 'precioVideojuego', c.nombre AS 'nombreConsola', v.stock AS 'stockVideojuego'
            FROM Videojuegos v
            INNER JOIN Consolas c ON c.id = v.idUso
            INNER JOIN UsuarioVideojuego uv ON uv.idVideojuego = v.id
            WHERE uv.idUsuario = {$this -> getIdUsuario()}";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        public function obtenerInformacionUsuario(){
            $consulta = "SELECT u.id AS 'idUsuario', u.nombre AS 'nombreUsuario', u.fechaRegistro AS 'fechaUsuario', u.departamento AS 'departamentoUsuario', u.municipio AS 'municipioUsuario', v.nombre AS 'nombreVideojuego', v.precio AS 'precioVideojuego', v.foto AS 'fotoVideojuego'
                        FROM UsuarioVideojuego uv
                        INNER JOIN Usuarios u ON u.id = uv.idUsuario
                        INNER JOIN Videojuegos v ON v.id = uv.idVideojuego
                        WHERE uv.idUsuario = {$this->getIdUsuario()}";
        
            // Ejecutar la consulta
            $resultados = $this->db->query($consulta);
        
            // Array para almacenar la información del usuario y sus videojuegos
            $informacionUsuario = array();
        
            // Recorrer los resultados de la consulta
            while ($fila = $resultados->fetch_object()) {
                // Verificar si ya se ha almacenado la información del usuario
                if (!isset($informacionUsuario['usuario'])) {
                    // Si no se ha almacenado, almacenar la información del usuario
                    $informacionUsuario['usuario'] = array(
                        'idUsuario' => $fila->idUsuario,
                        'nombreUsuario' => $fila->nombreUsuario,
                        'fechaUsuario' => $fila->fechaUsuario,
                        'departamentoUsuario' => $fila->departamentoUsuario,
                        'municipioUsuario' => $fila->municipioUsuario,
                        'videojuegos' => array() // Inicializar un array para almacenar los videojuegos del usuario
                    );
                }
        
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionUsuario['usuario']['videojuegos'][] = array(
                    'nombreVideojuego' => $fila->nombreVideojuego,
                    'precioVideojuego' => $fila->precioVideojuego,
                    'fotoVideojuego' => $fila->fotoVideojuego
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionUsuario;
        }        
    }

?>