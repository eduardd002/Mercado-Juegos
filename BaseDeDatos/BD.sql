/*Crear base de datos*/
CREATE DATABASE mercadoJuegos;

/*Usar base de datos*/
USE mercadoJuegos;

/*Crear tabla usuarios*/
CREATE TABLE usuarios (
    id              INTEGER auto_increment NOT NULL,
    rol             VARCHAR(100) NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    apellido        VARCHAR(250) NOT NULL,
    fechanacimiento DATE NOT NULL,
    numerotelefono  INTEGER NOT NULL,
    correo          VARCHAR(200) NOT NULL,
    clave           VARCHAR(150) NOT NULL,
    departamento    VARCHAR(100) NOT NULL,
    municipio       VARCHAR(100) NOT NULL,
    foto            VARCHAR(250),
    fecharegistro   DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT uq_correo UNIQUE(correo),
    CONSTRAINT usuarios_pk PRIMARY KEY ( id )
);

/*Crear tabla videoujuegos*/
CREATE TABLE videojuegos (
    id              INTEGER auto_increment NOT NULL,
    idconsola       INTEGER NOT NULL,
    iduso           INTEGER NOT NULL,
    idclasificacion INTEGER NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    precio          INTEGER NOT NULL,
    descripcion     TEXT NOT NULL,
    foto            VARCHAR(150) NOT NULL,
    fechacreacion   DATE NOT NULL,
    stock           INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT videojuegos_pk PRIMARY KEY ( id ),
    CONSTRAINT videojuegos_consolas_fk FOREIGN KEY ( idconsola ) REFERENCES consolas ( id ),
    CONSTRAINT videojuegos_usos_fk FOREIGN KEY ( iduso ) REFERENCES usos ( id )
);

/*Crea tabla intermedia de usuario y videojuego*/
CREATE TABLE usuariovideojuego (
    id           INTEGER auto_increment NOT NULL,
    idusuario    INTEGER NOT NULL,
    idvideojuego INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usuariovideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT usuariovideojuego_usuarios_fk FOREIGN KEY ( idusuario ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariovideojuego_videojuegos_fk FOREIGN KEY ( idvideojuego ) REFERENCES videojuegos ( id )
);

/*Crear tabla de pagos*/
CREATE TABLE pagos (
    id              INTEGER auto_increment NOT NULL,
    idtarjeta       INTEGER NOT NULL,
    numerotarjeta   INTEGER NOT NULL,
    titular         VARCHAR(250) NOT NULL,
    codigoseguridad INTEGER NOT NULL,
    fechaexpedicion DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT pagos_pk PRIMARY KEY ( id ),
    CONSTRAINT pagos_tarjetas_fk FOREIGN KEY ( idtarjeta ) REFERENCES tarjetas ( id )
);

/*Crear tabla para tipo de tarjetas*/
CREATE TABLE tarjetas (
    id              INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT tarjetas_pk PRIMARY KEY ( id )
);

/*Crear tabla para tipo de estados de la transacción*/
CREATE TABLE estados (
    id              INTEGER auto_increment NOT NULL,
    nombre VARCHAR(250) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT estados_pk PRIMARY KEY ( id )
);

/*Crear tabla para las transacciones*/
CREATE TABLE transacciones (
    id                INTEGER auto_increment NOT NULL,
    idcomprador       INTEGER NOT NULL,
    idvendedor        INTEGER NOT NULL,
    idpago            INTEGER NOT NULL,
    idestado          INTEGER NOT NULL,
    departamento      VARCHAR(250) NOT NULL,
    municipio         VARCHAR(200) NOT NULL,
    codigopostal      INTEGER NOT NULL,
    barrio            VARCHAR(250) NOT NULL,
    direccion         TEXT NOT NULL,
    nombrecomprador   VARCHAR(200) NOT NULL,
    apellidocomprador VARCHAR(200) NOT NULL,
    correocomprador   VARCHAR(200) NOT NULL,
    telefonocomprador INTEGER NOT NULL,
    total             INTEGER NOT NULL,
    fecharealizacion  DATE NOT NULL,
    horarealizacion   DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT compras_pk PRIMARY KEY ( id ),
    CONSTRAINT compras_compradores_fk FOREIGN KEY ( idcomprador ) REFERENCES usuarios ( id ),
    CONSTRAINT compras_pagos_fk FOREIGN KEY ( idpago ) REFERENCES pagos ( id ),
    CONSTRAINT compras_vendedores_fk FOREIGN KEY ( idvendedor ) REFERENCES usuarios ( id ),
    CONSTRAINT transacciones_estados_fk FOREIGN KEY ( idestado ) REFERENCES estados ( id )
);

/*Crea tabla intermedia de usuario y videojuego*/
CREATE TABLE transaccionvideojuego (
    id                  INTEGER auto_increment NOT NULL,
    idcompra            INTEGER NOT NULL,
    idvideojuego        INTEGER NOT NULL,
    unidades            INTEGER NOT NULL,
    nombrevideojuego    VARCHAR(200) NOT NULL,
    preciovideojuego    INTEGER NOT NULL,
    categoriavideojuego VARCHAR(250) NOT NULL,
    consolavideojuego   VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT transaccionvideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT transaccionvideojuego_transacciones_fk FOREIGN KEY ( idcompra ) REFERENCES transacciones ( id ),
    CONSTRAINT transaccionvideojuego_videojuegos_fk FOREIGN KEY ( idvideojuego ) REFERENCES videojuegos ( id )
);

/*Crea tabla intermedia de videojuego y categoria*/
CREATE TABLE videojuegocategoria (
    id             INTEGER auto_increment NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idCategoria  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT videojuegouso_pk PRIMARY KEY ( id ),
    CONSTRAINT videojuegocategoria_categorias_fk FOREIGN KEY ( idCategoria ) REFERENCES categorias ( id ),
    CONSTRAINT videojuegocategoria_videojuegos_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*Crea tabla de tipo de consolas de videojuego*/
CREATE TABLE consolas (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT consolas_pk PRIMARY KEY ( id )
);

/*Crea tabla de tipo de usos de videojuego*/
CREATE TABLE usos (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT estados_pkv1 PRIMARY KEY ( id )
);

/*Crea tabla de categorias*/
CREATE TABLE categorias (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT categorias_pk PRIMARY KEY ( id )
);