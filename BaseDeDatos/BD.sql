/*Crear base de datos*/
CREATE DATABASE mercadoJuegos;

/*Usar base de datos*/
USE mercadoJuegos;

/*Crear tabla usuarios*/
CREATE TABLE usuarios (
    id              INTEGER auto_increment NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    apellido        VARCHAR(250) NOT NULL,
    fechaNacimiento DATE NOT NULL,
    numeroTelefono  VARCHAR(200) NOT NULL,
    correo          VARCHAR(200) NOT NULL,
    clave           VARCHAR(150) NOT NULL,
    departamento    VARCHAR(100) NOT NULL,
    municipio       VARCHAR(100) NOT NULL,
    foto            VARCHAR(250),
    fechaRegistro   DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT uq_correo UNIQUE(correo),
    CONSTRAINT usuarios_pk PRIMARY KEY ( id )
);

/*Crear tabla administradores*/
CREATE TABLE administradores (
    id              INTEGER auto_increment NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    apellido        VARCHAR(250) NOT NULL,
    fechaNacimiento DATE NOT NULL,
    numeroTelefono  VARCHAR(200) NOT NULL,
    correo          VARCHAR(200) NOT NULL,
    clave           VARCHAR(150) NOT NULL,
    foto            VARCHAR(250),
    fechaRegistro   DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT uq_correo UNIQUE(correo),
    CONSTRAINT administradores_pk PRIMARY KEY ( id )
);

/*Crear tabla videoujuegos*/
CREATE TABLE videojuegos (
    id              INTEGER auto_increment NOT NULL,
    idConsola       INTEGER NOT NULL,
    idUso           INTEGER NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    precio          INTEGER NOT NULL,
    descripcion     TEXT NOT NULL,
    foto            VARCHAR(150) NOT NULL,
    fechaCreacion   DATE NOT NULL,
    stock           INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT videojuegos_pk PRIMARY KEY ( id ),
    CONSTRAINT videojuegos_consola_fk FOREIGN KEY ( idconsola ) REFERENCES consolas ( id ),
    CONSTRAINT videojuegos_uso_fk FOREIGN KEY ( iduso ) REFERENCES usos ( id )
);

/*Crea tabla intermedia de usuario y videojuego*/
CREATE TABLE usuariovideojuego (
    id           INTEGER auto_increment NOT NULL,
    idUsuario    INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usuariovideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT usuariovideojuego_usuario_fk FOREIGN KEY ( idusuario ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariovideojuego_videojuego_fk FOREIGN KEY ( idvideojuego ) REFERENCES videojuegos ( id )
);

/*Crear tabla de pagos*/
CREATE TABLE pagos (
    id              INTEGER auto_increment NOT NULL,
    idTarjeta       INTEGER NOT NULL,
    numeroTarjeta   VARCHAR(200) NOT NULL,
    titular         VARCHAR(250) NOT NULL,
    codigoSeguridad VARCHAR(200) NOT NULL,
    fechaExpedicion DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT pagos_pk PRIMARY KEY ( id ),
    CONSTRAINT pagos_tarjeta_fk FOREIGN KEY ( idtarjeta ) REFERENCES tarjetas ( id )
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
    numeroFactura     INTEGER NOT NULL,
    idComprador       INTEGER NOT NULL,
    idVendedor        INTEGER NOT NULL,
    idPago            INTEGER NOT NULL,
    idEstado          INTEGER NOT NULL,
    departamento      VARCHAR(250) NOT NULL,
    municipio         VARCHAR(200) NOT NULL,
    codigoPostal      VARCHAR(200) NOT NULL,
    barrio            VARCHAR(250) NOT NULL,
    direccion         TEXT NOT NULL,
    nombreComprador   VARCHAR(200) NOT NULL,
    apellidoComprador VARCHAR(200) NOT NULL,
    correoComprador   VARCHAR(200) NOT NULL,
    telefonoComprador VARCHAR(200) NOT NULL,
    total             INTEGER NOT NULL,
    fechaRealizacion  DATE NOT NULL,
    horaRealizacion   DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT uq_nf UNIQUE(numeroFactura),
    CONSTRAINT compras_pk PRIMARY KEY ( id ),
    CONSTRAINT transacciones_comprador_fk FOREIGN KEY ( idComprador ) REFERENCES usuarios ( id ),
    CONSTRAINT transacciones_vendedor_fk FOREIGN KEY ( idVendedor ) REFERENCES usuarios ( id ),
    CONSTRAINT transacciones_pago_fk FOREIGN KEY ( idPago ) REFERENCES pagos ( id ),
    CONSTRAINT transacciones_estado_fk FOREIGN KEY ( idEstado ) REFERENCES estados ( id )
);

/*Crea tabla intermedia de usuario y videojuego*/
CREATE TABLE transaccionvideojuego (
    id                  INTEGER auto_increment NOT NULL,
    idTransaccion       INTEGER NOT NULL,
    idVideojuego        INTEGER NOT NULL,
    unidades            INTEGER NOT NULL,
    nombreVideojuego    VARCHAR(200) NOT NULL,
    precioVideojuego    INTEGER NOT NULL,
    categoriaVideojuego VARCHAR(250) NOT NULL,
    consolaVideojuego   VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT transaccionvideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT transaccionvideojuego_transaccion_fk FOREIGN KEY ( idTransaccion ) REFERENCES transacciones ( id ),
    CONSTRAINT transaccionvideojuego_videojuego_fk FOREIGN KEY ( idvideojuego ) REFERENCES videojuegos ( id )
);

/*Crea tabla intermedia de videojuego y categoria*/
CREATE TABLE videojuegocategoria (
    id             INTEGER auto_increment NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idCategoria  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT videojuegocategoria_pk PRIMARY KEY ( id ),
    CONSTRAINT videojuegocategoria_categoria_fk FOREIGN KEY ( idCategoria ) REFERENCES categorias ( id ),
    CONSTRAINT videojuegocategoria_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
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
    CONSTRAINT usos_pk PRIMARY KEY ( id )
);

/*Crea tabla de categorias*/
CREATE TABLE categorias (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT categorias_pk PRIMARY KEY ( id )
);

/*Crea tabla de comentarios*/
CREATE TABLE comentarios (
    id     INTEGER auto_increment NOT NULL,
    idUsuario INTEGER NOT NULL,
    contenido TEXT NOT NULL,
    fechaCreacion DATE NOT NULL,
    horaCreacion TIME NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT comentarios_pk PRIMARY KEY ( id ),
    CONSTRAINT comentarios_usuario_fk FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id )
);

/*Crea tabla de comentariovideojuego*/
CREATE TABLE comentariovideojuego (
    id     INTEGER auto_increment NOT NULL,
    idComentario INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT comentariovideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT comentariovideojuego_comentario_fk FOREIGN KEY ( idComentario ) REFERENCES comentarios ( id ),
    CONSTRAINT comentariovideojuego_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*Crear tabla de carritos*/
CREATE TABLE carritos (
    id   INTEGER auto_increment NOT NULL,
    idUsuario    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT carritos_id PRIMARY KEY ( id ),
    CONSTRAINT usuario_carrito FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id )
);

/*Crear tabla de carritovideojuego*/
CREATE TABLE carritovideojuego (
    id   INTEGER auto_increment NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idCarrito INTEGER NOT NULL,
    unidades   INTEGER NOT NULL,
    precio    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT carritovideojuego_id PRIMARY KEY ( id ),
    CONSTRAINT carritovideojuego_carrito FOREIGN KEY ( idCarrito ) REFERENCES carritos ( id ),
    CONSTRAINT carritovideojuego_videojuego FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*Crear tabla de favoritos*/
CREATE TABLE favoritos (
    id   INTEGER auto_increment NOT NULL,
    idUsuario    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT favoritos_id PRIMARY KEY ( id ),
    CONSTRAINT usuario_favorito FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id )
);

/*Crear tabla de favoritovideojuego*/
CREATE TABLE videojuegofavorito (
    id   INTEGER auto_increment NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idFavorito INTEGER NOT NULL,
    precio    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT favoritovideojuego_id PRIMARY KEY ( id ),
    CONSTRAINT favoritovideojuego_favorito FOREIGN KEY ( idFavorito ) REFERENCES favoritos ( id ),
    CONSTRAINT favoritovideojuego_videojuego FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*Crear tabla de chats*/
CREATE TABLE chats (
    id   INTEGER auto_increment NOT NULL,
    fechaCreacion DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT chats_id PRIMARY KEY ( id )
);

/*Crear tabla de mensajes*/
CREATE TABLE mensajes (
    id   INTEGER auto_increment NOT NULL,
    idUsuario  INTEGER NOT NULL,
    idChat  INTEGER NOT NULL,
    contenido VARCHAR(200) NOT NULL,
    fechaEnvio DATE NOT NULL,
    horaEnvio DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT mensajes_id PRIMARY KEY ( id ),
    CONSTRAINT mensajes_usuario FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id ),
    CONSTRAINT mensajes_chat FOREIGN KEY ( idChat ) REFERENCES chats ( id )
);

/*Crear tabla de usuario mensaje chat*/
CREATE TABLE usuariomensajechat (
    id   INTEGER auto_increment NOT NULL,
    idRemitente  INTEGER NOT NULL,
    idDestinatario  INTEGER NOT NULL,
    idMensaje  INTEGER NOT NULL,
    idChat  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usuariomensajechat_id PRIMARY KEY ( id ),
    CONSTRAINT usuariomensajechat_remitente FOREIGN KEY ( idRemitente ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariomensajechat_destinatario FOREIGN KEY ( idDestinatario ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariomensajechat_mensaje FOREIGN KEY ( idMensaje ) REFERENCES mensajes ( id ),
    CONSTRAINT usuariomensajechat_chat FOREIGN KEY ( idChat ) REFERENCES chats ( id )
);