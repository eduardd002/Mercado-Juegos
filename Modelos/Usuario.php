<?php

    class Usuario{

        private $id;
        private $activo;
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

        public function getActivo(){
            return $this->activo;
        }

        public function setActivo($activo){
            $this->activo = $activo;
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

        /*
        Funcion para realizar el registro del usuario en la base de datos
        */

        public function guardar(){
            $clave = $this -> getClave();
            $claveSegura = password_hash($clave, PASSWORD_BCRYPT, ['cost'=>4]);
            //Construir la consulta
            $consulta = "INSERT INTO usuarios VALUES(NULL, {$this -> getActivo()},
                '{$this -> getNombre()}', '{$this -> getApellido()}', 
                '{$this -> getFechaNacimiento()}', {$this -> getNumeroTelefono()}, 
                '{$this -> getCorreo()}', '{$claveSegura}', 
                '{$this -> getDepartamento()}', '{$this -> getMunicipio()}', 
                '{$this -> getFoto()}', '{$this -> getFechaRegistro()}')";
            //Ejecutar la consulta
            $registro = $this -> db -> query($consulta);
            //Establecer una variable bandera
            $resultado = false;
            //Comporbar el registro fue exitoso y el total de columnas afectadas se altero
            if($registro && mysqli_affected_rows($this -> db) > 0){
                //Cambiar el estado de la variable bandera
                $resultado = true;
            }
            //Retornar el resultado
            return $resultado;
        }

        public function traerClave($correo){
            $consulta = "SELECT clave FROM usuarios WHERE correo = '$correo' AND activo = 1";
            $clave = $this -> db -> query($consulta);
            $resultado = $clave -> fetch_object();
            return $resultado;
        }

        /*
        Funcion para realizar el inicio de sesion
        */

        public function login(){

            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM usuarios WHERE correo = '{$this -> getCorreo()}' AND activo = 1";
            $clave = $this -> traerClave($this -> getCorreo());
            $claveAsociada = $clave -> clave;
            $resultado = false;
            $alho = password_verify($this -> getClave(), $claveAsociada);
            if($alho){
                //Ejecutar la consulta
            $login = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $usuario = $login -> fetch_object();
            //Comprobar si el objeto llegó
            if($usuario){
                //Establecer una variable bandera con el valor del objeto
                $resultado = $usuario;
            }
            }
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para listar todos los usuarios
        */

        public function listar(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM usuarios WHERE activo = 1";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para eliminar el usuario desde el administrador
        */

        public function eliminar(){
            //Construir la consulta
            $consulta = "UPDATE usuarios SET activo = 0 WHERE id = {$this -> getId()}";
            //Ejecutar la consulta
            $eliminado = $this -> db -> query($consulta);
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
        Funcion para obtener un usuario
        */

        public function obtenerUno(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT * FROM usuarios WHERE id = {$this -> getId()} AND activo = 1";
            //Ejecutar la consulta
            $categoria = $this -> db -> query($consulta);
            //Obtener resultado
            $resultado = $categoria -> fetch_object();
            //Retornar el resultado
            return $resultado;
        }

        /*
        Funcion para actualizar el usuario
        */

        public function actualizar(){

            //Construir la consulta
            $consulta = "UPDATE usuarios SET nombre = '{$this -> getNombre()}', apellido = '{$this -> getApellido()}',
                numeroTelefono = '{$this -> getNumeroTelefono()}', correo = '{$this -> getCorreo()}', 
                departamento = '{$this -> getDepartamento()}', 
                municipio = '{$this -> getMunicipio()}' ";
            if($this -> getFoto() != null){
                $consulta .= ",foto = '{$this -> getFoto()}'";
            }
            $consulta .= "WHERE id = {$this -> getId()}";
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

        public function actualizarClave(){
            $clave = $this -> getClave();
            $claveSegura = password_hash($clave, PASSWORD_BCRYPT, ['cost'=>4]);
            //Construir la consulta
            $consulta = "UPDATE usuarios SET clave = '{$claveSegura}' 
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

        public function obtenerInformacionUsuario(){
            $consulta = "SELECT u.id AS 'idUsuario', u.nombre AS 'nombreUsuario', u.fechaRegistro AS 'fechaUsuario', u.departamento AS 'departamentoUsuario', u.municipio AS 'municipioUsuario', v.nombre AS 'nombreVideojuego', v.precio AS 'precioVideojuego', v.foto AS 'fotoVideojuego', v.id AS 'idVideojuego'
                FROM Videojuegos v
                INNER JOIN Usuarios u ON u.id = v.idUsuario
                WHERE v.idUsuario = {$this->getId()} AND v.activo = 1";
        
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
                    'idVideojuego' => $fila->idVideojuego,
                    'nombreVideojuego' => $fila->nombreVideojuego,
                    'precioVideojuego' => $fila->precioVideojuego,
                    'fotoVideojuego' => $fila->fotoVideojuego
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionUsuario;
        } 

        public function obtenerTotalPublicados(){
            $consulta = "SELECT COUNT(idUsuario) AS 'videojuegosPublicados' FROM videojuegos WHERE idUsuario = {$this -> getId()}";
            // Ejecutar la consulta
            $total = $this->db->query($consulta);
            $resultado = $total -> fetch_object();
            // Retornar la información del usuario y sus videojuegos
            return $resultado;
        }

        public function obtenerTotalVendidos(){
            $consulta = "SELECT COUNT(idVendedor) AS 'videojuegosVendidos' FROM Transacciones WHERE idVendedor = {$this -> getId()}";
            // Ejecutar la consulta
            $total = $this->db->query($consulta);
            $resultado = $total -> fetch_object();
            // Retornar la información del usuario y sus videojuegos
            return $resultado;
        }

        public function obtenerVideojuegosCreadosPorUsuario(){
            $consulta = "SELECT DISTINCT v.nombre AS 'nombreVideojuego', v.precio AS 'precioVideojuego', c.nombre AS 'nombreConsola', v.stock AS 'stockVideojuego', v.id AS 'idVideojuego', v.foto AS 'imagenVideojuego'
            FROM Videojuegos v
            INNER JOIN Consolas c ON c.id = v.idUso
            INNER JOIN Usuarios u ON u.id = v.idUsuario
            WHERE u.id = {$this -> getId()} AND v.activo = 1";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar el resultado
            return $lista;
        }

        /*
        Funcion para listar algunos de los videojuegos, en concreto 6
        */

        public function listarAlgunos(){
            //Construir la consulta
            $consulta = "SELECT v.*
                FROM videojuegos v
                INNER JOIN usuarios u ON u.id = v.idUsuario
                WHERE v.activo = 1 ";
                if($this -> getId() != null){
                    $consulta .= "EXCEPT
                    SELECT v.*
                    FROM bloqueos b
                    INNER JOIN usuarios u ON u.id = b.idBloqueado
                    INNER JOIN videojuegos v ON v.idUsuario = u.id
                    AND b.idBloqueador = {$this -> getId()} AND b.activo = 1 ";
                }
            $consulta .= "ORDER BY RAND() LIMIT 6";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        /*
        Funcion para listar todos los videojuegos
        */

        public function listarTodos(){
            //Construir la consulta
            $consulta = "SELECT v.*
                FROM videojuegos v
                INNER JOIN usuarios u ON v.idUsuario = u.id
                WHERE v.activo = 1 ";
                if($this -> getId() != null){
                    $consulta .= "EXCEPT
                    SELECT v.*
                    FROM bloqueos b
                    INNER JOIN usuarios u ON u.id = b.idBloqueado
                    INNER JOIN videojuegos v ON v.idUsuario = u.id
                    AND b.idBloqueador = {$this -> getId()} AND b.activo = 1 ";
                }
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Retornar resultado
            return $resultado;
        }

        /*
        Funcion para obtener la ultima transaccion registrada
        */

        public function obtenerEnvios(){
            //Construir la consulta
            $consulta = "SELECT * FROM Envios e WHERE idUsuario = {$this -> getId()} AND activo = 1";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar resultado
            return $lista;
        }

        /*
        Funcion para obtener la ultima transaccion registrada
        */

        public function obtenerPagos(){
            //Construir la consulta
            $consulta = "SELECT mp.nombre AS 'nombreMedioPago', p.numero AS 'numeroPago', p.id AS 'idPago'
                FROM Pagos p
                INNER JOIN MediosPago mp ON mp.id = p.idMedioPago
                WHERE idUsuario = {$this -> getId()} AND p.activo = 1";
            //Ejecutar la consulta
            $lista = $this -> db -> query($consulta);
            //Retornar resultado
            return $lista;
        }

    }

?>