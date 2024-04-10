<?php

    class UsuarioBloqueo{

        private $id;
        private $activo;
        private $idBloqueador;
        private $idBloqueado;
        private $motivo;
        private $fechaHora;
        private $db;

        public function __construct(){
            $this -> db = BaseDeDatos::connect();
        }

        public function getMotivo()
        {
                return $this->motivo;
        }

        /**
         * Set the value of motivo
         *
         * @return  self
         */ 
        public function setMotivo($motivo)
        {
                $this->motivo = $motivo;

                return $this;
        }

        
        /**
         * Get the value of fecha
         */ 
        public function getFechaHora()
        {
                return $this->fechaHora;
        }

        /**
         * Set the value of fecha
         *
         * @return  self
         */ 
        public function setFechaHora($fechaHora)
        {
                $this->fechaHora = $fechaHora;

                return $this;
        }


        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
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

        /**
         * Get the value of idBloqueador
         */ 
        public function getIdBloqueador()
        {
                return $this->idBloqueador;
        }

        /**
         * Set the value of idBloqueador
         *
         * @return  self
         */ 
        public function setIdBloqueador($idBloqueador)
        {
                $this->idBloqueador = $idBloqueador;

                return $this;
        }

        /**
         * Get the value of idBloqueado
         */ 
        public function getIdBloqueado()
        {
                return $this->idBloqueado;
        }

        /**
         * Set the value of idBloqueado
         *
         * @return  self
         */ 
        public function setIdBloqueado($idBloqueado)
        {
                $this->idBloqueado = $idBloqueado;

                return $this;
        }

        public function guardar(){
            //Construir la consulta
            $consulta = "INSERT INTO usuariobloqueo VALUES(NULL, {$this -> getActivo()}, {$this -> getIdBloqueador()}, 
                {$this -> getIdBloqueado()}, '{$this -> getMotivo()}', '{$this -> getFechaHora()}')";
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

        public function obtenerBloqueosPorUsuario(){
                $consulta = "SELECT DISTINCT b.id AS 'idBloqueo', u.nombre AS 'nombreBloqueado', u.apellido AS 'apellidoBloqueado', b.motivo AS 'motivoBloqueo', b.fechaBloqueo AS 'fechaBloqueo', b.horaBloqueo AS 'horaBloqueo'
                FROM UsuarioBloqueo ub
                INNER JOIN Usuarios u ON u.id = ub.idBloqueado
                INNER JOIN Bloqueos b ON b.id = ub.id
                WHERE ub.idBloqueador = {$this -> getIdBloqueador()} AND b.activo = 1";
                //Ejecutar la consulta
                $lista = $this -> db -> query($consulta);
                //Retornar el resultado
                return $lista;
        }

        public function eliminar(){
                $consulta = "UPDATE usuarioBloqueo SET activo = 0 WHERE idBloqueador = {$this -> getIdBloqueado()} AND idBloqueado = {$this -> getIdBloqueador()}";
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
    
            public function ultimo(){
                //Construir la consulta
                $consulta = "SELECT DISTINCT id FROM bloqueos ORDER BY id DESC LIMIT 1";
                //Ejecutar la consulta
                $resultado = $this -> db -> query($consulta);
                //Obtener el resultado del objeto
                $ultimo = $resultado -> fetch_object();
                //Devolver resultado
                $ultimoBloqueo = $ultimo -> id;
                //Retornar el resultado
                return $ultimoBloqueo;
            }
    
            public function obtenerListaBloqueos(){
                 $consulta = "SELECT DISTINCT ubo.nombre AS 'nombreBloqueado' , ubr.nombre AS 'nombreBloqueador' , b.motivo AS 'motivoBloqueo' , b.fechaBloqueo AS 'fechaBloqueo' , b.horaBloqueo AS 'horaBloqueo'
                    FROM usuarioBloqueo ub
                    INNER JOIN Bloqueos b ON b.id = ub.idBloqueo
                    INNER JOIN Usuarios ubr ON ubr.id = ub.idBloqueador
                    INNER JOIN Usuarios ubo ON ubo.id = ub.idBloqueado
                    WHERE b.activo = 1";
                    //Ejecutar la consulta
                    $resultado = $this -> db -> query($consulta);
                    //Retornar el resultado
                    return $resultado;
            }
    }

?>