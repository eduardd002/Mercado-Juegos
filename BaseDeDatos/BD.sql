/*
Eliminar la base de datos
*/

DROP DATABASE mercadoJuegos;

/*
Crear base de datos
*/

CREATE DATABASE mercadoJuegos;

/*
Usar base de datos
*/

USE mercadoJuegos;

/*
Crear tabla usuarios
*/

CREATE TABLE usuarios (
    id              INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
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

/*
Crear tabla administradores
*/

CREATE TABLE administradores (
    id              INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
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

/*
Crea tabla de categorias
*/

CREATE TABLE categorias (
    id     INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT categorias_pk PRIMARY KEY ( id )
);

/*
Crea tabla de tipo de consolas de videojuego
*/

CREATE TABLE consolas (
    id     INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT consolas_pk PRIMARY KEY ( id )
);

/*
Crea tabla de tipo de usos de videojuego
*/

CREATE TABLE usos (
    id     INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usos_pk PRIMARY KEY ( id )
);

/*
Crear tabla videoujuegos
*/

CREATE TABLE videojuegos (
    id              INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
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
    CONSTRAINT videojuegos_consola_fk FOREIGN KEY ( idConsola ) REFERENCES consolas ( id ),
    CONSTRAINT videojuegos_uso_fk FOREIGN KEY ( idUso ) REFERENCES usos ( id )
);

/*
Crea tabla intermedia de usuario y videojuego
*/

CREATE TABLE usuariovideojuego (
    id           INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idUsuario    INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usuariovideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT usuariovideojuego_usuario_fk FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariovideojuego_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crear tabla para tipo de tarjetas
*/

CREATE TABLE tarjetas (
    id              INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT tarjetas_pk PRIMARY KEY ( id )
);

/*
Crear tabla de pagos
*/

CREATE TABLE pagos (
    id              INTEGER auto_increment NOT NULL,
    idTarjeta       INTEGER NOT NULL,
    numeroTarjeta   VARCHAR(200) NOT NULL,
    titular         VARCHAR(250) NOT NULL,
    codigoSeguridad VARCHAR(200) NOT NULL,
    fechaExpedicion DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT pagos_pk PRIMARY KEY ( id ),
    CONSTRAINT pagos_tarjeta_fk FOREIGN KEY ( idTarjeta ) REFERENCES tarjetas ( id )
);

/*
Crear tabla para tipo de estados de la transacción
*/

CREATE TABLE estados (
    id              INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    nombre VARCHAR(250) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT estados_pk PRIMARY KEY ( id )
);

/*
Crear tabla para las transacciones
*/

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
    nombreVendedor   VARCHAR(200) NOT NULL,
    apellidoVendedor VARCHAR(200) NOT NULL,
    correoVendedor   VARCHAR(200) NOT NULL,
    telefonoVendedor VARCHAR(200) NOT NULL,
    total             INTEGER NOT NULL,
    fechaRealizacion  DATE NOT NULL,
    horaRealizacion   TIME NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT uq_nf UNIQUE(numeroFactura),
    CONSTRAINT compras_pk PRIMARY KEY ( id ),
    CONSTRAINT transacciones_comprador_fk FOREIGN KEY ( idComprador ) REFERENCES usuarios ( id ),
    CONSTRAINT transacciones_vendedor_fk FOREIGN KEY ( idVendedor ) REFERENCES usuarios ( id ),
    CONSTRAINT transacciones_pago_fk FOREIGN KEY ( idPago ) REFERENCES pagos ( id ),
    CONSTRAINT transacciones_estado_fk FOREIGN KEY ( idEstado ) REFERENCES estados ( id )
);

/*
Crea tabla intermedia de usuario y videojuego
*/

CREATE TABLE transaccionvideojuego (
    id                  INTEGER auto_increment NOT NULL,
    idTransaccion       INTEGER NOT NULL,
    idVideojuego        INTEGER NOT NULL,
    unidades            INTEGER NOT NULL,
    nombreVideojuego    VARCHAR(200) NOT NULL,
    precioVideojuego    INTEGER NOT NULL,
    usoVideojuego VARCHAR(250) NOT NULL,
    consolaVideojuego   VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT transaccionvideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT transaccionvideojuego_transaccion_fk FOREIGN KEY ( idTransaccion ) REFERENCES transacciones ( id ),
    CONSTRAINT transaccionvideojuego_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crea tabla intermedia de videojuego y categoria
*/

CREATE TABLE videojuegocategoria (
    id             INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idCategoria  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT videojuegocategoria_pk PRIMARY KEY ( id ),
    CONSTRAINT videojuegocategoria_categoria_fk FOREIGN KEY ( idCategoria ) REFERENCES categorias ( id ),
    CONSTRAINT videojuegocategoria_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crea tabla de comentarios
*/

CREATE TABLE comentarios (
    id     INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idUsuario INTEGER NOT NULL,
    contenido TEXT NOT NULL,
    fechaCreacion DATE NOT NULL,
    horaCreacion TIME NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT comentarios_pk PRIMARY KEY ( id ),
    CONSTRAINT comentarios_usuario_fk FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id )
);

/*
Crea tabla de comentariovideojuego
*/

CREATE TABLE comentariovideojuego (
    id     INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idComentario INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT comentariovideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT comentariovideojuego_comentario_fk FOREIGN KEY ( idComentario ) REFERENCES comentarios ( id ),
    CONSTRAINT comentariovideojuego_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crear tabla de carritos
*/

CREATE TABLE carritos (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idUsuario    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT carritos_id PRIMARY KEY ( id ),
    CONSTRAINT usuario_carrito FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id )
);

/*
Crear tabla de carritovideojuego
*/

CREATE TABLE carritovideojuego (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idCarrito INTEGER NOT NULL,
    unidades   INTEGER NOT NULL,
    precio    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT carritovideojuego_id PRIMARY KEY ( id ),
    CONSTRAINT carritovideojuego_carrito FOREIGN KEY ( idCarrito ) REFERENCES carritos ( id ),
    CONSTRAINT carritovideojuego_videojuego FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crear tabla de favoritos
*/

CREATE TABLE favoritos (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idUsuario    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT favoritos_id PRIMARY KEY ( id ),
    CONSTRAINT usuario_favorito FOREIGN KEY ( idUsuario ) REFERENCES usuarios ( id )
);

/*
Crear tabla de favoritovideojuego
*/

CREATE TABLE videojuegofavorito (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idFavorito INTEGER NOT NULL,
    precio    INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT favoritovideojuego_id PRIMARY KEY ( id ),
    CONSTRAINT favoritovideojuego_favorito FOREIGN KEY ( idFavorito ) REFERENCES favoritos ( id ),
    CONSTRAINT favoritovideojuego_videojuego FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crear tabla de chats
*/

CREATE TABLE chats (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    fechaCreacion DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT chats_id PRIMARY KEY ( id )
);

/*
Crear tabla de usuario mensaje chat
*/

CREATE TABLE usuariochat (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idRemitente  INTEGER NOT NULL,
    idDestinatario  INTEGER NOT NULL,
    idChat  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT uq_rd UNIQUE(idRemitente, idDestinatario),
    CONSTRAINT usuariomensajechat_id PRIMARY KEY ( id ),
    CONSTRAINT usuariomensajechat_remitente FOREIGN KEY ( idRemitente ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariomensajechat_destinatario FOREIGN KEY ( idDestinatario ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariomensajechat_chat FOREIGN KEY ( idChat ) REFERENCES chats ( id )
);

/*
Crear tabla de mensajes
*/

CREATE TABLE mensajes (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idRemitente  INTEGER NOT NULL,
    idDestinatario  INTEGER NOT NULL,
    idChat  INTEGER NOT NULL,
    contenido   TEXT NOT NULL,
    fechaEnvio    DATE NOT NULL,
    horaEnvio   TIME NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT mensaje_id PRIMARY KEY ( id ),
    CONSTRAINT mensaje_remitente FOREIGN KEY ( idRemitente ) REFERENCES usuarios ( id ),
    CONSTRAINT mensaje_destinatario FOREIGN KEY ( idDestinatario ) REFERENCES usuarios ( id ),
    CONSTRAINT mensaje_chat FOREIGN KEY ( idChat ) REFERENCES chats ( id )
);

/*
Crear tabla de bloqueos
*/

CREATE TABLE bloqueos (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    motivo  TEXT NOT NULL,
    fechaBloqueo    DATE NOT NULL,
    horaBloqueo   TIME NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT bloqueos_id PRIMARY KEY ( id )
);
/*
Crear tabla de usuariosbloqueados
*/

CREATE TABLE usuariobloqueo (
    id   INTEGER auto_increment NOT NULL,
    activo          INTEGER NOT NULL,
    idBloqueador  INTEGER NOT NULL,
    idBloqueado  INTEGER NOT NULL,
    idBloqueo  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usuariobloqueo_id PRIMARY KEY ( id ),
    CONSTRAINT usuariobloqueo_bloqueo FOREIGN KEY ( idBloqueo ) REFERENCES bloqueos ( id ),
    CONSTRAINT usuariobloqueo_bloqueador FOREIGN KEY ( idBloqueador ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariobloqueo_bloqueado FOREIGN KEY ( idBloqueado ) REFERENCES usuarios ( id )
);

/*
Crear usuarios
*/

INSERT INTO usuarios VALUES (NULL, 1, "Eduardo", "Cortes Pineda", "2002-07-31", "3157566407", "eduar@gmail.com", "Qwerty1@", "Quindio", "Armenia", "eduar.jpg", "2024-03-25");
INSERT INTO usuarios VALUES (NULL, 1, "Juan David", "Giraldo Barrero", "2002-12-22", "3216549877", "juanda@gmail.com", "Qwerty1@", "Quindio", "Armenia", "juanda.jpg", "2024-03-25");
INSERT INTO usuarios VALUES (NULL, 1, "Juan Pablo", "Velez Londoño", "2002-03-2", "3216549877", "velez@gmail.com", "Qwerty1@", "Quindio", "Armenia", "velez.jpeg", "2024-03-25");

/*
Crear administradores
*/

INSERT INTO administradores VALUES (NULL, 1, "Raul Yulbraynner", "Rivera Galvez", "1990-02-20", "3216549878", "raw@gmail.com", "Qwerty1@", "raw.jpg", "2024-03-25");
INSERT INTO administradores VALUES (NULL, 1, "Alexandra", "Ruiz Gaona", "1985-04-26", "3216549878", "alexandra@gmail.com", "Qwerty1@", "alexandra.jpg", "2024-03-25");

/*
Crear categorias
*/

INSERT INTO categorias VALUES (NULL, 1, "Accion");
INSERT INTO categorias VALUES (NULL, 1, "Aventura");
INSERT INTO categorias VALUES (NULL, 1, "Batallas");
INSERT INTO categorias VALUES (NULL, 1, "Deportes");
INSERT INTO categorias VALUES (NULL, 1, "Carreras");
INSERT INTO categorias VALUES (NULL, 1, "Estrategia");
INSERT INTO categorias VALUES (NULL, 1, "Rol");
INSERT INTO categorias VALUES (NULL, 1, "Disparos");
INSERT INTO categorias VALUES (NULL, 1, "Puzzle");

/*
Crear usos
*/

INSERT INTO usos VALUES (NULL, 1, "Nuevo");
INSERT INTO usos VALUES (NULL, 1, "Usado");

/*
Crear tarjetas
*/

INSERT INTO tarjetas VALUES (NULL, 1, "Credito");
INSERT INTO tarjetas VALUES (NULL, 1, "Debito");

/*
Crear estados
*/

INSERT INTO estados VALUES (NULL, 1, "Aprobado");
INSERT INTO estados VALUES (NULL, 1, "Enviado");
INSERT INTO estados VALUES (NULL, 1, "Recibido");

/*
Crear consolas
*/

INSERT INTO consolas VALUES (NULL, 1, "Play Station 3");
INSERT INTO consolas VALUES (NULL, 1, "Play Station 4");
INSERT INTO consolas VALUES (NULL, 1, "Play Station 5");
INSERT INTO consolas VALUES (NULL, 1, "Xbox 360");
INSERT INTO consolas VALUES (NULL, 1, "Xbox One");
INSERT INTO consolas VALUES (NULL, 1, "Windows");

/*
Crear videojuegos
*/

INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "The Sims 4", 150000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "sims4.jpeg", "2024-03-20",65);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "Assassins Creed Valhalla", 120654, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "acv.jpg", "2024-03-20",42);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 2, "Adventure Time Finn & Jake Investigations", 200000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "aot.jpg", "2024-03-20",5);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "Call Of Duty Black Ops Cold War", 300000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "codcw.jpg", "2024-03-20",9);
INSERT INTO videojuegos VALUES (NULL, 1, 3, 1, "Call Of Duty WWII", 154655, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "codwwii.jpg", "2024-03-20",11);
INSERT INTO videojuegos VALUES (NULL, 1, 3, 1, "Diablo IV", 236487, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "d.jpeg", "2024-03-20",12);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 2, "Elden Ring", 100000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "er.jpeg", "2024-03-20",98);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "Fifa 23", 650000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "ff.jpg", "2024-03-20",80);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "GTA V", 120333, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "gta5.jpeg", "2024-03-20",9);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "Minecraft", 110000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "m.jpeg", "2024-03-20",11);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 2, "Mortal Kombat X", 320000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "mk.jpeg", "2024-03-20",32);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "NBA2K20", 90000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "nba2k.jpg", "2024-03-20",0);
INSERT INTO videojuegos VALUES (NULL, 1, 3, 2, "Spider-Man Miles Morales", 127000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "sp.jpg", "2024-03-20",54);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 2, "Need For Speed", 92000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "nfs.jpeg", "2024-03-20",11);
INSERT INTO videojuegos VALUES (NULL, 1, 2, 1, "Call Of Duty Vanguard", 107000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "codv.jpg", "2024-03-20",84);

/*
Crear categoria de videojuegos
*/

INSERT INTO videojuegocategoria VALUES (NULL, 1, 1, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 2, 2);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 3, 3);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 4, 4);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 5, 5);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 6, 6);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 7, 7);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 8, 8);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 9, 9);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 10, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 11, 2);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 12, 3);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 13, 4);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 1, 5);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 2, 6);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 3, 7);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 4, 8);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 5, 9);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 6, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 1, 2);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 7, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 8, 2);

/*
Crear usuarios de videojuegos
*/

INSERT INTO usuariovideojuego VALUES (NULL, 1, 1, 1);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 2, 2);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 3, 3);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 1, 4);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 2, 5);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 3, 6);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 1, 7);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 2, 8);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 3, 9);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 1, 10);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 2, 11);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 3, 12);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 1, 13);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 3, 14);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 1, 15);

/*
Crear favoritos
*/

INSERT INTO favoritos VALUES (NULL, 1, 1);
INSERT INTO favoritos VALUES (NULL, 1, 2);
INSERT INTO favoritos VALUES (NULL, 1, 3);
INSERT INTO favoritos VALUES (NULL, 1, 1);
INSERT INTO favoritos VALUES (NULL, 1, 2);
INSERT INTO favoritos VALUES (NULL, 1, 3);
INSERT INTO favoritos VALUES (NULL, 1, 1);
INSERT INTO favoritos VALUES (NULL, 1, 2);
INSERT INTO favoritos VALUES (NULL, 1, 3);
INSERT INTO favoritos VALUES (NULL, 1, 1);

/*
Crear videojuegos favoritos
*/

INSERT INTO videojuegofavorito VALUES (NULL, 1, 1, 1, 150654);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 2, 2, 10000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 3, 3, 120000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 4, 4, 80000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 7, 5, 210000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 3, 6, 650000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 6, 7, 129000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 10, 8, 130000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 3, 9, 246000);
INSERT INTO videojuegofavorito VALUES (NULL, 1, 4, 10, 90000);