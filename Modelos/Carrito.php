<?php

    class Carrito{

        private $id;
        private $activo;
        private $idUsuario;
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

        public function getIdUsuario(){
            return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario){
            $this->idUsuario = $idUsuario;
            return $this;
        }

        /*
        Funcion para guardar el carrito en la base de datos
        */

        public function guardar(){
            //Construir consulta
            $consulta = "INSERT INTO carritos VALUES(NULL, {$this -> getActivo()}, {$this -> getIdUsuario()})";
            //Ejecutar la consulta
            $guardado = $this -> db -> query($consulta);
            //Crear bandera
            $bandera = false;
            //Comprobar si la consulta se realizo exitosamente
            if($guardado && mysqli_affected_rows($this -> db) > 0){
                $bandera = true;
            }
            //Retorno el resultado
            return $bandera;
        }

        /*
        Funcion para obtener el ultimo favorito registrado
        */

        public function ultimo(){
            //Construir la consulta
            $consulta = "SELECT DISTINCT id FROM carritos ORDER BY id DESC LIMIT 1";
            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);
            //Obtener el resultado del objeto
            $ultimo = $resultado -> fetch_object();
            //Devolver resultado
            $ultimoFavorito = $ultimo -> id;
            //Retornar el resultado
            return $ultimoFavorito;
        }

        public function listar(){
            $consulta = "SELECT DISTINCT v.nombre AS 'nombreVideojuegoCarrito', v.foto AS 'imagenVideojuegoCarrito', v.precio AS 'precioVideojuegoCarrito', cv.unidades AS 'unidadesCarrito'
                FROM CarritoVideojuego cv
                INNER JOIN carritos c ON cv.idCarrito = c.id
                INNER JOIN videojuegos v ON v.id = cv.idVideojuego
                WHERE c.idUsuario = {$this -> getIdUsuario()}";

            //Ejecutar la consulta
            $resultado = $this -> db -> query($consulta);

            // Array para almacenar la información del usuario y sus videojuegos
            $informacionCarrito = array();

            $total = 0;

            while ($fila = $resultado->fetch_object()) {
                if (!isset($informacionCarrito['carrito'])) {
                    $informacionCarrito['carrito'] = array(
                        'videojuegos' => array()
                    );
                }
                
                // Almacenar la información del videojuego en el array de videojuegos del usuario
                $informacionCarrito['carrito']['videojuegos'][] = array(
                    'nombreVideojuegoCarrito' => $fila->nombreVideojuegoCarrito,
                    'imagenVideojuegoCarrito' => $fila->imagenVideojuegoCarrito,
                    'precioVideojuegoCarrito' => $fila->precioVideojuegoCarrito,
                    'unidadesCarrito' => $fila->unidadesCarrito
                );

                $precios = $fila -> precioVideojuegoCarrito;
                $unidades = $fila -> unidadesCarrito;
                $total += $precios * $unidades;
                $informacionCarrito['totalCarrito'] = $total;
            }
            return $informacionCarrito;
        }

    }

?>