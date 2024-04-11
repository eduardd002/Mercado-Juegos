<?php

    define("rutaInicio", "http://localhost/Mercado-Juegos");
   
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

    define("carrito", "/?controller=CarritoController");
    define("verCarrito", "&action=ver");
    define("guardarCarrito", "&action=guardar");

    define("favorito", "/?controller=FavoritoController");
    define("verFavorito", "&action=ver");
    define("guardarFavorito", "&action=guardar");

    define("transaccion", "/?controller=TransaccionController");
    define("guardarCompra", "&action=guardar");
    define("verCompra", "&action=verCompra");
    define("verVenta", "&action=verVenta");
    define("direccionYPago", "&action=direccionYPago");
    define("pago", "&action=pago");
    define("realizar", "&action=exito");
    define("cambiarEstado", "&action=cambiarEstado");
    define("generarPdf", "&action=generarPdf");

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

    define("uso", "/?controller=UsoController");
    define("crearUso", "&action=crear");
    define("guardarUso", "&action=guardar");
    define("eliminarUso", "&action=eliminar");
    define("editarUso", "&action=editar");
    define("actualizarUso", "&action=actualizar");

    define("estado", "/?controller=EstadoController");
    define("crearEstado", "&action=crear");
    define("guardarEstado", "&action=guardar");
    define("eliminarEstado", "&action=eliminar");
    define("editarEstado", "&action=editar");
    define("actualizarEstado", "&action=actualizar");

    define("medioPago", "/?controller=MedioPagoController");
    define("crearMedioPago", "&action=crear");
    define("guardarMedioPago", "&action=guardar");
    define("eliminarMedioPago", "&action=eliminar");
    define("editarMedioPago", "&action=editar");
    define("actualizarMedioPago", "&action=actualizar");

    define("consola", "/?controller=ConsolaController");
    define("crearConsola", "&action=crear");
    define("guardarConsola", "&action=guardar");
    define("eliminarConsola", "&action=eliminar");
    define("editarConsola", "&action=editar");
    define("actualizarConsola", "&action=actualizar");

    define("categoria", "/?controller=CategoriaController");
    define("crearCategoria", "&action=crear");
    define("guardarCategoria", "&action=guardar");
    define("eliminarCateogoria", "&action=eliminar");
    define("editarCategoria", "&action=editar");
    define("actualizarCategoria", "&action=actualizar");

    define("chat", "/?controller=ChatController");
    define("chatear", "&action=chatear");
    define("verMensajes", "&action=verMensajes");
    define("enviarMensaje", "&action=enviarMensaje");

    define("comentario", "/?controller=ComentarioController");
    define("guardarComentario", "&action=guardar");
    define("eliminarComentario", "&action=eliminar");

    define("bloqueo", "/?controller=BloqueoController");
    define("bloquear", "&action=bloquear");
    define("desbloquear", "&action=desbloquear");
?>