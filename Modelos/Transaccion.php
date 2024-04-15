<?php

    class Transaccion{

        private $id;
        private $numeroFactura;
        private $idComprador;
        private $idVendedor;
        private $idPago;
        private $idEstado;
        private $total;
        private $idEnvio;
        private $fechaHora;
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

        public function getTotal(){
            return $this->total;
        }

        public function setTotal($total){
            $this->total = $total;
            return $this;
        }

        public function getFechaHora(){
            return $this->fechaHora;
        }

        public function setFechaHora($fechaHora){
            $this->fechaHora = $fechaHora;
            return $this;
        }

                /**
         * Get the value of idEnvio
         */ 
        public function getIdEnvio()
        {
                return $this->idEnvio;
        }

        /**
         * Set the value of idEnvio
         *
         * @return  self
         */ 
        public function setIdEnvio($idEnvio)
        {
                $this->idEnvio = $idEnvio;

                return $this;
        }

        /*
        Funcion para realizar el registro de la transaccion en la base de datos
        */

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO transacciones VALUES(NULL, {$this -> getNumeroFactura()}, {$this -> getIdComprador()}, 
                {$this -> getIdVendedor()}, {$this -> getIdPago()}, {$this -> getIdEstado()}, {$this -> getIdEnvio()}, 
                {$this -> getTotal()}, '{$this -> getFechaHora()}')";
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
            $consulta = "SELECT DISTINCT * FROM transacciones WHERE idVendedor = {$this -> getIdVendedor()}";
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
            $consulta = "SELECT DISTINCT * FROM transacciones WHERE idComprador = {$this -> getIdComprador()}";
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
            $consulta = "SELECT DISTINCT id FROM transacciones ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener ultimo id
            $ultimo = $resultado -> fetch_object();
            //Comprobar si existe un id, si es asi asignarle el valor, de lo contrario asignar un 0
            if($ultimo == null){
                $id = 0;
            }else{
                //Obtener ultimo resultado
                $id = $ultimo -> id;
            }
            //Retornar resultado
            return $id;
        }

        /*
        Funcion para obtener la ultima transaccion registrada
        */

        public function ultima(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT id FROM transacciones ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimaTransaccion = $ultimo -> id;
            //Retornar el resultado
            return $ultimaTransaccion;
        }

        public function detalleCompra(){
            $consulta = "SELECT DISTINCT ve.nombre AS 'nombreVendedor', ve.apellido AS 'apellidoVendedor', ve.numeroTelefono AS 'telefonoVendedor', ve.correo AS 'correoVendedor', en.departamento AS 'departamentoEnvio', en.municipio AS 'municipioEnvio', en.codigoPostal AS 'codigoPostalEnvio', en.direccion AS 'direccionEnvio', en.barrio AS 'barrioEnvio', p.numero AS 'numero', t.total AS 'totalTransaccion', v.nombre AS 'nombreVideojuegoCompra', u.nombre AS 'usoVideojuegoCompra', c.nombre AS 'consolaVideojuegoCompra', v.precio AS 'precioVideojuegoCompra', t.numeroFactura AS 'factura', tv.unidades AS 'unidadesCompra', mp.nombre AS 'medioPagoNombre', te.nombre AS 'nombreEstado'
                FROM TransaccionVideojuego tv
                INNER JOIN Transacciones t ON t.id = tv.idTransaccion
                INNER JOIN Estados te ON te.id = t.idEstado
                INNER JOIN Videojuegos v ON v.id = tv.idVideojuego
                INNER JOIN Consolas c ON c.id = v.idConsola
                INNER JOIN usuarios ve ON t.idVendedor = ve.id
                INNER JOIN Usos u ON u.id = v.idUso
                INNER JOIN Pagos p ON p.id = t.idPago
                INNER JOIN MediosPago mp ON mp.id = p.idMedioPago
                INNER JOIN Envios en ON en.id = t.idEnvio
                WHERE t.numeroFactura = {$this -> getNumeroFactura()}";
        
            // Ejecutar la consulta
            $resultados = $this->db->query($consulta);
        
            // Array para almacenar la información del usuario y sus videojuegos
            $informacionCompra = array();
        
            // Recorrer los resultados de la consulta
            while ($fila = $resultados->fetch_object()) {
                // Verificar si ya se ha almacenado la información del usuario
                if (!isset($informacionCompra['compra'])) {
                    // Si no se ha almacenado, almacenar la información del usuario
                    $informacionCompra['compra'] = array(
                        'factura' => $fila->factura,
                        'nombreVendedor' => $fila->nombreVendedor,
                        'apellidoVendedor' => $fila->apellidoVendedor,
                        'telefonoVendedor' => $fila->telefonoVendedor,
                        'correoVendedor' => $fila->correoVendedor,
                        'departamentoEnvio' => $fila->departamentoEnvio,
                        'municipioEnvio' => $fila->municipioEnvio,
                        'codigoPostalEnvio' => $fila->codigoPostalEnvio,
                        'direccionEnvio' => $fila->direccionEnvio,
                        'barrioEnvio' => $fila->barrioEnvio,
                        'nombreEstado' => $fila->nombreEstado,
                        'numero' => $fila->numero,
                        'medioPagoNombre'=>$fila->medioPagoNombre,
                        'totalTransaccion' => $fila->totalTransaccion,
                        'videojuegos' => array() // Inicializar un array para almacenar los videojuegos del usuario
                    );
                }
        
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionCompra['compra']['videojuegos'][] = array(
                    'nombreVideojuegoCompra' => $fila->nombreVideojuegoCompra,
                    'unidadesCompra' => $fila->unidadesCompra,
                    'usoVideojuegoCompra' => $fila->usoVideojuegoCompra,
                    'consolaVideojuegoCompra' => $fila->consolaVideojuegoCompra,
                    'precioVideojuegoCompra' => $fila->precioVideojuegoCompra
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionCompra;
        }   
        
        public function detalleVenta(){
            $consulta = "SELECT DISTINCT co.nombre AS 'nombreComprador', co.apellido AS 'apellidoComprador', co.numeroTelefono AS 'telefonoComprador', co.correo AS 'correoComprador', en.departamento AS 'departamentoEnvio', en.municipio AS 'municipioEnvio', en.codigoPostal AS 'codigoPostalEnvio', en.direccion AS 'direccionEnvio', en.barrio AS 'barrioEnvio', p.numero AS 'numero', t.total AS 'totalTransaccion', v.foto AS 'imagenVideojuego', tv.unidades AS 'unidadesCompra', v.precio AS 'precioVideojuegoVenta', t.numeroFactura AS 'facturaVenta', t.id AS 'idTransaccion', mp.nombre AS 'medioPagoNombre', p.numero AS 'numeroPago', te.nombre AS 'nombreEstado'
                FROM TransaccionVideojuego tv
                INNER JOIN Transacciones t ON t.id = tv.idTransaccion
                INNER JOIN Estados te ON te.id = t.idEstado
                INNER JOIN Videojuegos v ON v.id = tv.idVideojuego
                INNER JOIN Pagos p ON p.id = t.idPago
                INNER JOIN MediosPago mp ON mp.id = p.idMedioPago
                INNER JOIN Envios en ON en.id = t.idEnvio
                INNER JOIN usuarios co ON t.idComprador = co.id
                WHERE t.numeroFactura = {$this -> getNumeroFactura()}";
        
            // Ejecutar la consulta
            $resultados = $this->db->query($consulta);
        
            // Array para almacenar la información del usuario y sus videojuegos
            $informacionVenta = array();
        
            // Recorrer los resultados de la consulta
            while ($fila = $resultados->fetch_object()) {
                // Verificar si ya se ha almacenado la información del usuario
                if (!isset($informacionVenta['venta'])) {
                    // Si no se ha almacenado, almacenar la información del usuario
                    $informacionVenta['venta'] = array(
                        'facturaVenta' => $fila->facturaVenta,
                        'idTransaccion' => $fila->idTransaccion,
                        'nombreComprador' => $fila->nombreComprador,
                        'apellidoComprador' => $fila->apellidoComprador,
                        'telefonoComprador' => $fila->telefonoComprador,
                        'correoComprador' => $fila->correoComprador,
                        'departamentoEnvio' => $fila->departamentoEnvio,
                        'municipioEnvio' => $fila->municipioEnvio,
                        'codigoPostalEnvio' => $fila->codigoPostalEnvio,
                        'direccionEnvio' => $fila->direccionEnvio,
                        'barrioEnvio' => $fila->barrioEnvio,
                        'nombreEstado' => $fila->nombreEstado,
                        'numeroPago' => $fila->numeroPago,
                        'medioPagoNombre'=>$fila->medioPagoNombre,
                        'totalTransaccion' => $fila->totalTransaccion,
                        'videojuegos' => array() // Inicializar un array para almacenar los videojuegos del usuario
                    );
                }
        
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionVenta['venta']['videojuegos'][] = array(
                    'unidadesCompra' => $fila->unidadesCompra,
                    'imagenVideojuego' => $fila->imagenVideojuego,
                    'precioVideojuegoVenta' => $fila->precioVideojuegoVenta
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionVenta;
        }   

        public function cambiarEstado(){
            //Construir la consulta
            $consulta = "UPDATE transacciones SET idEstado = {$this -> getIdEstado()} 
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
    }

?>