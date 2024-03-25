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
Crear tabla videoujuegos
*/

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

/*
Crea tabla intermedia de usuario y videojuego
*/

CREATE TABLE usuariovideojuego (
    id           INTEGER auto_increment NOT NULL,
    idUsuario    INTEGER NOT NULL,
    idVideojuego INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usuariovideojuego_pk PRIMARY KEY ( id ),
    CONSTRAINT usuariovideojuego_usuario_fk FOREIGN KEY ( idusuario ) REFERENCES usuarios ( id ),
    CONSTRAINT usuariovideojuego_videojuego_fk FOREIGN KEY ( idvideojuego ) REFERENCES videojuegos ( id )
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
    CONSTRAINT pagos_tarjeta_fk FOREIGN KEY ( idtarjeta ) REFERENCES tarjetas ( id )
);

/*
Crear tabla para tipo de tarjetas
*/

CREATE TABLE tarjetas (
    id              INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT tarjetas_pk PRIMARY KEY ( id )
);

/*
Crear tabla para tipo de estados de la transacción
*/

CREATE TABLE estados (
    id              INTEGER auto_increment NOT NULL,
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
    CONSTRAINT transaccionvideojuego_videojuego_fk FOREIGN KEY ( idvideojuego ) REFERENCES videojuegos ( id )
);

/*
Crea tabla intermedia de videojuego y categoria
*/

CREATE TABLE videojuegocategoria (
    id             INTEGER auto_increment NOT NULL,
    idVideojuego INTEGER NOT NULL,
    idCategoria  INTEGER NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT videojuegocategoria_pk PRIMARY KEY ( id ),
    CONSTRAINT videojuegocategoria_categoria_fk FOREIGN KEY ( idCategoria ) REFERENCES categorias ( id ),
    CONSTRAINT videojuegocategoria_videojuego_fk FOREIGN KEY ( idVideojuego ) REFERENCES videojuegos ( id )
);

/*
Crea tabla de tipo de consolas de videojuego
*/

CREATE TABLE consolas (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT consolas_pk PRIMARY KEY ( id )
);

/*
Crea tabla de tipo de usos de videojuego
*/

CREATE TABLE usos (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT usos_pk PRIMARY KEY ( id )
);

/*
Crea tabla de categorias
*/

CREATE TABLE categorias (
    id     INTEGER auto_increment NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT categorias_pk PRIMARY KEY ( id )
);

/*
Crea tabla de comentarios
*/

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

/*
Crea tabla de comentariovideojuego
*/

CREATE TABLE comentariovideojuego (
    id     INTEGER auto_increment NOT NULL,
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
    fechaCreacion DATE NOT NULL,
    CONSTRAINT uq_id UNIQUE(id),
    CONSTRAINT chats_id PRIMARY KEY ( id )
);

/*
Crear tabla de mensajes
*/

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

/*
Crear tabla de usuario mensaje chat
*/

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

/*
Crear usuarios
*/

INSERT INTO usuarios VALUES (NULL, "Eduardo", "Cortes Pineda", "2002-07-31", "3157566407", "eduar@gmail.com", "Qwerty1@", "Quindio", "Armenia", "eduar.jpg", "2024-03-25");
INSERT INTO usuarios VALUES (NULL, "Juan David", "Giraldo Barrero", "2002-12-22", "3216549877", "juanda@gmail.com", "Qwerty1@", "Quindio", "Armenia", "juanda.jpg", "2024-03-25");
INSERT INTO usuarios VALUES (NULL, "Juan Pablo", "Velez Londoño", "2002-03-2", "3216549877", "velez@gmail.com", "Qwerty1@", "Quindio", "Armenia", "velez.jpeg", "2024-03-25");

/*
Crear administradores
*/

INSERT INTO administradores VALUES (NULL, "Raul Yulbraynner", "Rivera Galvez", "1990-02-20", "3216549878", "raw@gmail.com", "Qwerty1@", "raw.jpg", "2024-03-25");
INSERT INTO administradores VALUES (NULL, "Alexandra", "Ruiz Gaona", "1985-04-26", "3216549878", "alexandra@gmail.com", "Qwerty1@", "alexandra.jpg", "2024-03-25");

/*
Crear categorias
*/

INSERT INTO categorias VALUES (NULL, "Accion");
INSERT INTO categorias VALUES (NULL, "Aventura");
INSERT INTO categorias VALUES (NULL, "Batallas");
INSERT INTO categorias VALUES (NULL, "Deportes");
INSERT INTO categorias VALUES (NULL, "Carreras");
INSERT INTO categorias VALUES (NULL, "Estrategia");
INSERT INTO categorias VALUES (NULL, "Rol");
INSERT INTO categorias VALUES (NULL, "Disparos");
INSERT INTO categorias VALUES (NULL, "Puzzle");

/*
Crear usos
*/

INSERT INTO usos VALUES (NULL, "Nuevo");
INSERT INTO usos VALUES (NULL, "Usado");

/*
Crear tarjetas
*/

INSERT INTO tarjetas VALUES (NULL, "Credito");
INSERT INTO tarjetas VALUES (NULL, "Debito");

/*
Crear estados
*/

INSERT INTO estados VALUES (NULL, "Aprobado");
INSERT INTO estados VALUES (NULL, "Enviado");
INSERT INTO estados VALUES (NULL, "Recibido");

/*
Crear consolas
*/

INSERT INTO consolas VALUES (NULL, "Play Station 3");
INSERT INTO consolas VALUES (NULL, "Play Station 4");
INSERT INTO consolas VALUES (NULL, "Play Station 5");
INSERT INTO consolas VALUES (NULL, "Xbox 360");
INSERT INTO consolas VALUES (NULL, "Xbox One");
INSERT INTO consolas VALUES (NULL, "Windows");

/*
Crear videojuegos
*/

INSERT INTO videojuegos VALUES (NULL, 2, 1, "The Sims 4", 150000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "sims4.jpeg", "2024-03-20",65);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "Assassins Creed Valhalla", 120654, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "acv.jpg", "2024-03-20",42);
INSERT INTO videojuegos VALUES (NULL, 2, 2, "Adventure Time Finn & Jake Investigations", 200000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "aot.jpg", "2024-03-20",5);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "Call Of Duty Black Ops Cold War", 300000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "codcw.jpg", "2024-03-20",9);
INSERT INTO videojuegos VALUES (NULL, 3, 1, "Call Of Duty WWII", 154655, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "codwwii.jpg", "2024-03-20",11);
INSERT INTO videojuegos VALUES (NULL, 3, 1, "Diablo IV", 236487, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "d.jpeg", "2024-03-20",12);
INSERT INTO videojuegos VALUES (NULL, 2, 2, "Elden Ring", 100000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "er.jpeg", "2024-03-20",98);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "Fifa 23", 650000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "ff.jpg", "2024-03-20",80);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "GTA V", 120333, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "gta5.jpeg", "2024-03-20",9);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "Minecraft", 110000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "m.jpeg", "2024-03-20",11);
INSERT INTO videojuegos VALUES (NULL, 2, 2, "Mortal Kombat X", 320000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "mk.jpeg", "2024-03-20",32);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "NBA2K20", 90000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "nba2k.jpg", "2024-03-20",0);
INSERT INTO videojuegos VALUES (NULL, 3, 2, "Spider-Man Miles Morales", 127000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "sp.jpg", "2024-03-20",54);
INSERT INTO videojuegos VALUES (NULL, 2, 2, "Need For Speed", 92000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "nfs.jpeg", "2024-03-20",11);
INSERT INTO videojuegos VALUES (NULL, 2, 1, "Call Of Duty Vanguard", 107000, "Los videojuegos son programas de ordenador que conectados a una pantalla o televisión, integran un sistema de vídeo y audio. Al igual que la televisión, un correcto uso de los videojuegos tiene efectos positivos sobre el niño o el adolescente.", "codv.jpg", "2024-03-20",84);

/*
Crear categoria de videojuegos
*/

INSERT INTO videojuegocategoria VALUES (NULL, 1, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 2, 2);
INSERT INTO videojuegocategoria VALUES (NULL, 3, 3);
INSERT INTO videojuegocategoria VALUES (NULL, 4, 4);
INSERT INTO videojuegocategoria VALUES (NULL, 5, 5);
INSERT INTO videojuegocategoria VALUES (NULL, 6, 6);
INSERT INTO videojuegocategoria VALUES (NULL, 7, 7);
INSERT INTO videojuegocategoria VALUES (NULL, 8, 8);
INSERT INTO videojuegocategoria VALUES (NULL, 9, 9);
INSERT INTO videojuegocategoria VALUES (NULL, 10, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 11, 2);
INSERT INTO videojuegocategoria VALUES (NULL, 12, 3);
INSERT INTO videojuegocategoria VALUES (NULL, 13, 4);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 5);
INSERT INTO videojuegocategoria VALUES (NULL, 2, 6);
INSERT INTO videojuegocategoria VALUES (NULL, 3, 7);
INSERT INTO videojuegocategoria VALUES (NULL, 4, 8);
INSERT INTO videojuegocategoria VALUES (NULL, 5, 9);
INSERT INTO videojuegocategoria VALUES (NULL, 6, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 1, 2);
INSERT INTO videojuegocategoria VALUES (NULL, 7, 1);
INSERT INTO videojuegocategoria VALUES (NULL, 8, 2);

/*
Crear usuarios de videojuegos
*/

INSERT INTO usuariovideojuego VALUES (NULL, 1, 1);
INSERT INTO usuariovideojuego VALUES (NULL, 2, 2);
INSERT INTO usuariovideojuego VALUES (NULL, 3, 3);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 4);
INSERT INTO usuariovideojuego VALUES (NULL, 2, 5);
INSERT INTO usuariovideojuego VALUES (NULL, 3, 6);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 7);
INSERT INTO usuariovideojuego VALUES (NULL, 2, 8);
INSERT INTO usuariovideojuego VALUES (NULL, 3, 9);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 10);
INSERT INTO usuariovideojuego VALUES (NULL, 2, 11);
INSERT INTO usuariovideojuego VALUES (NULL, 3, 12);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 13);
INSERT INTO usuariovideojuego VALUES (NULL, 3, 14);
INSERT INTO usuariovideojuego VALUES (NULL, 1, 15);

/*
Crear comentarios
*/

INSERT INTO comentarios VALUES (NULL, 1, "Muy buen juego", "2024-03-24", "15:33:12");
INSERT INTO comentarios VALUES (NULL, 2, "Casi no me gusto", "2024-03-24", "07:32:21");
INSERT INTO comentarios VALUES (NULL, 3, "¿Esta disponible?", "2024-03-24", "12:51:31");
INSERT INTO comentarios VALUES (NULL, 1, "¿Es bueno?", "2024-03-24", "02:13:13");
INSERT INTO comentarios VALUES (NULL, 2, "¿Es malo?", "2024-03-24", "06:06:25");
INSERT INTO comentarios VALUES (NULL, 3, "Excelente juego", "2024-03-24", "08:10:12");
INSERT INTO comentarios VALUES (NULL, 1, "Muy regular", "2024-03-24", "10:40:34");
INSERT INTO comentarios VALUES (NULL, 2, "Está pasable", "2024-03-24", "11:10:43");
INSERT INTO comentarios VALUES (NULL, 3, "Me gustó solo un poco", "2024-03-24", "19:43:51");
INSERT INTO comentarios VALUES (NULL, 1, "Casi no lo jugué", "2024-03-24", "20:26:15");
INSERT INTO comentarios VALUES (NULL, 2, "Lo jugué un montón", "2024-03-24", "21:06:01");

/*
Crear comentarios de videojuegos
*/

INSERT INTO comentariovideojuego VALUES (NULL, 1, 1);
INSERT INTO comentariovideojuego VALUES (NULL, 2, 2);
INSERT INTO comentariovideojuego VALUES (NULL, 3, 3);
INSERT INTO comentariovideojuego VALUES (NULL, 4, 1);
INSERT INTO comentariovideojuego VALUES (NULL, 5, 2);
INSERT INTO comentariovideojuego VALUES (NULL, 6, 3);
INSERT INTO comentariovideojuego VALUES (NULL, 7, 1);
INSERT INTO comentariovideojuego VALUES (NULL, 8, 2);
INSERT INTO comentariovideojuego VALUES (NULL, 9, 3);
INSERT INTO comentariovideojuego VALUES (NULL, 10, 1);
INSERT INTO comentariovideojuego VALUES (NULL, 11, 2);

/*
Crear favoritos
*/

INSERT INTO favoritos VALUES (NULL, 1);
INSERT INTO favoritos VALUES (NULL, 2);
INSERT INTO favoritos VALUES (NULL, 3);
INSERT INTO favoritos VALUES (NULL, 1);
INSERT INTO favoritos VALUES (NULL, 2);
INSERT INTO favoritos VALUES (NULL, 3);
INSERT INTO favoritos VALUES (NULL, 1);
INSERT INTO favoritos VALUES (NULL, 2);
INSERT INTO favoritos VALUES (NULL, 3);
INSERT INTO favoritos VALUES (NULL, 1);

/*
Crear videojuegos favoritos
*/

INSERT INTO videojuegofavorito VALUES (NULL, 1, 1, 150654);
INSERT INTO videojuegofavorito VALUES (NULL, 2, 2, 10000);
INSERT INTO videojuegofavorito VALUES (NULL, 3, 3, 120000);
INSERT INTO videojuegofavorito VALUES (NULL, 4, 4, 80000);
INSERT INTO videojuegofavorito VALUES (NULL, 7, 5, 210000);
INSERT INTO videojuegofavorito VALUES (NULL, 3, 6, 650000);
INSERT INTO videojuegofavorito VALUES (NULL, 6, 7, 129000);
INSERT INTO videojuegofavorito VALUES (NULL, 10, 8, 130000);
INSERT INTO videojuegofavorito VALUES (NULL, 3, 9, 246000);
INSERT INTO videojuegofavorito VALUES (NULL, 4, 10, 90000);

/*
Crear pagos
*/

INSERT INTO pagos VALUES (NULL, 1, "654987", "Eduardo Cortes Pineda", "654", "2029-08-21");
INSERT INTO pagos VALUES (NULL, 1, "654987", "Eduardo Cortes Pineda", "654", "2029-08-21");
INSERT INTO pagos VALUES (NULL, 2, "963258", "Juan David Giraldo Barrero", "111", "2028-07-11");

/*
Crear transacciones
*/

INSERT INTO transacciones VALUES (NULL, "1000", 1, 2, 1, 1, "Quindio", "Armenia", "630003", "San Jose", "Carrera 28", "Eduardo", "Cortes Pineda", "eduar@gmail.com", "3157566407", 650000, "2024-03-21", "15:21:21");
INSERT INTO transacciones VALUES (NULL, "1001", 1, 3, 2, 1, "Cundinamarca", "Bogota", "123987", "16 de agosto", "Carrera 12", "Eduardo", "Cortes Pineda", "eduar@gmail.com", "3157566407", 105000, "2024-02-21", "20:23:08");
INSERT INTO transacciones VALUES (NULL, "1002", 2, 1, 3, 1, "Risaralda", "Pereira", "987654", "San Juan", "Carrera 11", "Juan David", "Giraldo Barrero", "juanda@gmail.com", "3216549878", 950000, "2024-01-21", "17:54:15");

/*
Crear videojuegos de la transaccion
*/

INSERT INTO transaccionvideojuego VALUES (NULL, 1, 4, 5, "Call Of Duty Vanguard", 500000, "Nuevo", "Play Station 4");
INSERT INTO transaccionvideojuego VALUES (NULL, 2, 5, 1, "Need For Speed", 150000, "Nuevo", "Play Station 4");
INSERT INTO transaccionvideojuego VALUES (NULL, 3, 6, 4, "Fifa 23", 90000, "Usado", "Play Station 4");