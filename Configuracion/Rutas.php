<?php

    /*
    Clase con todas las rutas utilizadas
    */

    /*Ruta de alojamiento local*/

    define("rutaInicio", "http://localhost/Mercado-Juegos");

    /*Ruta para usuario*/

    define("usuario", "/?controller=UsuarioController");
    define("login", "&action=login");
    define("registro", "&action=registro");
    define("logout", "&action=cerrarSesion");
    define("guardarUsuario", "&action=guardar");
    define("loginUsuario", "&action=inicioDeSesion");
    define("perfil", "&action=perfil");
    define("miPerfil", "&action=miPerfil");
    define("compras", "&action=compras");
    define("bloqueos", "&action=bloqueos");
    define("envios", "&action=envios");
    define("pagos", "&action=pagos");
    define("ventas", "&action=ventas");
    define("videojuegos", "&action=videojuegos");
    define("eliminarUsuario", "&action=eliminar");
    define("actualizarUsuario", "&action=actualizar");
    define("cambiarClave", "&action=cambiarClave");
    define("actualizarClave", "&action=actualizarClave");

    /*Ruta para videojuego*/

    define("videojuego", "/?controller=VideojuegoController");
    define("inicio", "&action=inicio");
    define("detalle", "&action=detalle");
    define("buscar", "&action=buscar");
    define("crear", "&action=crear");
    define("guardar", "&action=guardar");
    define("actualizarVideojuego", "&action=actualizar");
    define("editarVideojuego", "&action=editar");
    define("eliminarVideojuego", "&action=eliminar");
    define("todos", "&action=todos");
    define("algunos", "&action=inicio");
    define("filtro", "&action=filtro");

    /*Ruta para carrito*/

    define("carrito", "/?controller=CarritoController");
    define("verCarrito", "&action=ver");
    define("guardarCarrito", "&action=guardar");
    define("eliminarVideojuegoCarrito", "&action=eliminarVideojuegoCarrito");
    define("eliminarCarrito", "&action=eliminarCarrito");

    /*Ruta para favorito*/

    define("favorito", "/?controller=FavoritoController");
    define("verFavorito", "&action=ver");
    define("guardarFavorito", "&action=guardar");
    define("eliminarFavorito", "&action=eliminarFavorito");

    /*Ruta para transaccion*/

    define("transaccion", "/?controller=TransaccionController");
    define("transaccionVideojuego", "&action=transaccionVideojuego");
    define("guardarCompra", "&action=guardar");
    define("verCompra", "&action=verCompra");
    define("verVenta", "&action=verVenta");
    define("direccionYPago", "&action=direccionYPago");
    define("realizar", "&action=exito");
    define("cambiarEstado", "&action=cambiarEstado");
    define("generarPdf", "&action=generarPdf");

    /*Ruta para administrador*/

    define("administrador", "/?controller=AdministradorController");
    define("administrar", "&action=administrar");
    define("registroAdmin", "&action=registro");
    define("guardarAdmin", "&action=guardar");
    define("gestionarUso", "&action=gestionarUso");
    define("eliminarUsuarioAdministrador", "&action=eliminarUsuario");
    define("verBloqueos", "&action=verBloqueos");
    define("gestionarCategoria", "&action=gestionarCategoria");
    define("gestionarUsuario", "&action=gestionarUsuario");
    define("gestionarConsola", "&action=gestionarConsola");
    define("gestionarEstado", "&action=gestionarEstado");
    define("gestionarMedioPago", "&action=gestionarMedioPago");
    define("eliminarAdministrador", "&action=eliminar");
    define("actualizarAdministrador", "&action=actualizar");

    /*Ruta para uso*/

    define("uso", "/?controller=UsoController");
    define("crearUso", "&action=crear");
    define("guardarUso", "&action=guardar");
    define("eliminarUso", "&action=eliminar");
    define("editarUso", "&action=editar");
    define("actualizarUso", "&action=actualizar");

    /*Ruta para pago*/

    define("pago", "/?controller=PagoController");
    define("crearPago", "&action=crear");
    define("guardarPago", "&action=guardar");
    define("eliminarPago", "&action=eliminar");
    define("editarPago", "&action=editar");
    define("actualizarPago", "&action=actualizar");

    /*Ruta para envio*/

    define("envio", "/?controller=EnvioController");
    define("crearEnvio", "&action=crear");
    define("guardarEnvio", "&action=guardar");
    define("eliminarEnvio", "&action=eliminar");
    define("editarEnvio", "&action=editar");
    define("actualizarEnvio", "&action=actualizar");

    /*Ruta para estado*/

    define("estado", "/?controller=EstadoController");
    define("crearEstado", "&action=crear");
    define("guardarEstado", "&action=guardar");
    define("eliminarEstado", "&action=eliminar");
    define("editarEstado", "&action=editar");
    define("actualizarEstado", "&action=actualizar");

    /*Ruta para medio de pago*/

    define("medioPago", "/?controller=MedioPagoController");
    define("crearMedioPago", "&action=crear");
    define("guardarMedioPago", "&action=guardar");
    define("eliminarMedioPago", "&action=eliminar");
    define("editarMedioPago", "&action=editar");
    define("actualizarMedioPago", "&action=actualizar");

    /*Ruta para consola*/

    define("consola", "/?controller=ConsolaController");
    define("crearConsola", "&action=crear");
    define("guardarConsola", "&action=guardar");
    define("eliminarConsola", "&action=eliminar");
    define("editarConsola", "&action=editar");
    define("actualizarConsola", "&action=actualizar");

    /*Ruta para categoria*/

    define("categoria", "/?controller=CategoriaController");
    define("crearCategoria", "&action=crear");
    define("guardarCategoria", "&action=guardar");
    define("eliminarCateogoria", "&action=eliminar");
    define("editarCategoria", "&action=editar");
    define("actualizarCategoria", "&action=actualizar");

    /*Ruta para chat*/

    define("chat", "/?controller=ChatController");
    define("chatear", "&action=chatear");
    define("verMensajes", "&action=verMensajes");
    define("enviarMensaje", "&action=enviarMensaje");

    /*Ruta para comentario*/

    define("comentario", "/?controller=ComentarioController");
    define("guardarComentario", "&action=guardar");
    define("eliminarComentario", "&action=eliminar");

    /*Ruta para bloqueo*/

    define("bloqueo", "/?controller=BloqueoController");
    define("bloquear", "&action=bloquear");
    define("desbloquear", "&action=desbloquear");

?>