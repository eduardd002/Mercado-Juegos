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
        private $nombreVendedor;
        private $apellidoVendedor;
        private $correoVendedor;
        private $telefonoVendedor;
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



        /**
         * Get the value of nombreVendedor
         */ 
        public function getNombreVendedor()
        {
                return $this->nombreVendedor;
        }

        /**
         * Set the value of nombreVendedor
         *
         * @return  self
         */ 
        public function setNombreVendedor($nombreVendedor)
        {
                $this->nombreVendedor = $nombreVendedor;

                return $this;
        }

        /**
         * Get the value of apellidoVendedor
         */ 
        public function getApellidoVendedor()
        {
                return $this->apellidoVendedor;
        }

        /**
         * Set the value of apellidoVendedor
         *
         * @return  self
         */ 
        public function setApellidoVendedor($apellidoVendedor)
        {
                $this->apellidoVendedor = $apellidoVendedor;

                return $this;
        }

        /**
         * Get the value of correoVendedor
         */ 
        public function getCorreoVendedor()
        {
                return $this->correoVendedor;
        }

        /**
         * Set the value of correoVendedor
         *
         * @return  self
         */ 
        public function setCorreoVendedor($correoVendedor)
        {
                $this->correoVendedor = $correoVendedor;

                return $this;
        }

        /**
         * Get the value of telefonoVendedor
         */ 
        public function getTelefonoVendedor()
        {
                return $this->telefonoVendedor;
        }

        /**
         * Set the value of telefonoVendedor
         *
         * @return  self
         */ 
        public function setTelefonoVendedor($telefonoVendedor)
        {
                $this->telefonoVendedor = $telefonoVendedor;

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
                '{$this -> getApellidoComprador()}', '{$this -> getCorreoComprador()}', '{$this -> getTelefonoComprador()}', '{$this -> getNombreVendedor()}', 
                '{$this -> getApellidoVendedor()}', '{$this -> getCorreoVendedor()}', '{$this -> getTelefonoVendedor()}',
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
            $consulta = "SELECT DISTINCT t.nombreVendedor AS 'nombreVendedor', t.apellidoVendedor AS 'apellidoVendedor', t.telefonoVendedor AS 'telefonoVendedor', t.correoVendedor AS 'correoVendedor', t.departamento AS 'departamentoEnvio', t.municipio AS 'municipioEnvio', t.codigoPostal AS 'codigoPostalEnvio', t.direccion AS 'direccionEnvio', t.barrio AS 'barrioEnvio', tt.nombre AS 'tipoTarjetaPago', p.numeroTarjeta AS 'numeroTarjetaPago', te.nombre AS 'tipoEstadoTransaccion', t.total AS 'totalTransaccion', v.nombre AS 'nombreVideojuegoCompra', u.nombre AS 'usoVideojuegoCompra', c.nombre AS 'consolaVideojuegoCompra', v.precio AS 'precioVideojuegoCompra', t.numeroFactura AS 'factura', tv.unidades AS 'unidadesCompra'
                FROM TransaccionVideojuego tv
                INNER JOIN Transacciones t ON t.id = tv.idTransaccion
                INNER JOIN Videojuegos v ON v.id = tv.idVideojuego
                INNER JOIN Consolas c ON c.id = v.idConsola
                INNER JOIN Usos u ON u.id = v.idUso
                INNER JOIN Pagos p ON p.id = t.idPago
                INNER JOIN Tarjetas tt ON p.idTarjeta = tt.id
                INNER JOIN Estados te ON t.idEstado = te.id
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
                        'tipoTarjetaPago' => $fila->tipoTarjetaPago,
                        'numeroTarjetaPago' => $fila->numeroTarjetaPago,
                        'tipoEstadoTransaccion' => $fila->tipoEstadoTransaccion,
                        'unidadesCompra' => $fila->unidadesCompra,
                        'totalTransaccion' => $fila->totalTransaccion,
                        'videojuegos' => array() // Inicializar un array para almacenar los videojuegos del usuario
                    );
                }
        
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionCompra['compra']['videojuegos'][] = array(
                    'nombreVideojuegoCompra' => $fila->nombreVideojuegoCompra,
                    'usoVideojuegoCompra' => $fila->usoVideojuegoCompra,
                    'consolaVideojuegoCompra' => $fila->consolaVideojuegoCompra,
                    'precioVideojuegoCompra' => $fila->precioVideojuegoCompra
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionCompra;
        }   
        
        public function detalleVenta(){
            $consulta = "SELECT DISTINCT t.nombreComprador AS 'nombreComprador', t.apellidoComprador AS 'apellidoComprador', t.telefonoComprador AS 'telefonoComprador', t.correoComprador AS 'correoComprador', t.departamento AS 'departamentoEnvio', t.municipio AS 'municipioEnvio', t.codigoPostal AS 'codigoPostalEnvio', t.direccion AS 'direccionEnvio', t.barrio AS 'barrioEnvio', tt.nombre AS 'tipoTarjetaPago', p.numeroTarjeta AS 'numeroTarjetaPago', te.nombre AS 'tipoEstadoTransaccion', t.total AS 'totalTransaccion', v.foto AS 'imagenVideojuego', tv.unidades AS 'unidadesCompra', v.precio AS 'precioVideojuegoVenta'
                FROM TransaccionVideojuego tv
                INNER JOIN Transacciones t ON t.id = tv.idTransaccion
                INNER JOIN Videojuegos v ON v.id = tv.idVideojuego
                INNER JOIN Pagos p ON p.id = t.idPago
                INNER JOIN Tarjetas tt ON p.idTarjeta = tt.id
                INNER JOIN Estados te ON t.idEstado = te.id
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
                        'nombreComprador' => $fila->nombreComprador,
                        'apellidoComprador' => $fila->apellidoComprador,
                        'telefonoComprador' => $fila->telefonoComprador,
                        'correoComprador' => $fila->correoComprador,
                        'departamentoEnvio' => $fila->departamentoEnvio,
                        'municipioEnvio' => $fila->municipioEnvio,
                        'codigoPostalEnvio' => $fila->codigoPostalEnvio,
                        'direccionEnvio' => $fila->direccionEnvio,
                        'barrioEnvio' => $fila->barrioEnvio,
                        'tipoTarjetaPago' => $fila->tipoTarjetaPago,
                        'numeroTarjetaPago' => $fila->numeroTarjetaPago,
                        'tipoEstadoTransaccion' => $fila->tipoEstadoTransaccion,
                        'unidadesCompra' => $fila->unidadesCompra,
                        'totalTransaccion' => $fila->totalTransaccion,
                        'videojuegos' => array() // Inicializar un array para almacenar los videojuegos del usuario
                    );
                }
        
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionVenta['venta']['videojuegos'][] = array(
                    'imagenVideojuego' => $fila->imagenVideojuego,
                    'precioVideojuegoVenta' => $fila->precioVideojuegoVenta
                );
            }
        
            // Retornar la información del usuario y sus videojuegos
            return $informacionVenta;
        }   
    }

?>