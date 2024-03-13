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
    define("ventas", "&action=ventas");
    define("videojuegos", "&action=videojuegos");
    define("eliminarUsuario", "&action=eliminar");

    define("videojuego", "/?controller=VideojuegoController");
    define("inicio", "&action=inicio");
    define("detalle", "&action=detalle");
    define("buscar", "&action=buscar");
    define("crear", "&action=crear");
    define("guardar", "&action=guardar");
    define("actualizarVideojuego", "&action=actualizar");
    define("eliminarVideojuego", "&action=eliminar");
    define("todos", "&action=todos");

    define("carrito", "/?controller=CarritoController");
    define("ver", "&action=ver");

    define("transaccion", "/?controller=TransaccionController");
    define("verCompras", "&action=verCompras");
    define("verVentas", "&action=verVentas");
    define("direccion", "&action=direccion");
    define("pago", "&action=pago");
    define("realizar", "&action=exito");
    define("generarPdf", "&action=generarPdf");

    define("administrador", "/?controller=AdministradorController");
    define("administrar", "&action=administrar");
    define("registroAdmin", "&action=registro");
    define("guardarAdmin", "&action=guardar");
    define("gestionarUso", "&action=gestionarUso");
    define("eliminarUsuarioAdministrador", "&action=eliminarUsuario");
    define("gestionarCategoria", "&action=gestionarCategoria");
    define("gestionarUsuario", "&action=gestionarUsuario");
    define("gestionarConsola", "&action=gestionarConsola");
    define("gestionarEstado", "&action=gestionarEstado");
    define("gestionarTarjeta", "&action=gestionarTarjeta");

    define("uso", "/?controller=UsoController");
    define("crearUso", "&action=crear");
    define("guardarUso", "&action=guardar");

    define("estado", "/?controller=EstadoController");
    define("crearEstado", "&action=crear");
    define("guardarEstado", "&action=guardar");

    define("tarjeta", "/?controller=TarjetaController");
    define("crearTarjeta", "&action=crear");
    define("guardarTarjeta", "&action=guardar");

    define("consola", "/?controller=ConsolaController");
    define("crearConsola", "&action=crear");
    define("guardarConsola", "&action=guardar");
    define("eliminarConsola", "&action=eliminar");

    define("categoria", "/?controller=CategoriaController");
    define("crearCategoria", "&action=crear");
    define("guardarCategoria", "&action=guardar");
    define("eliminarCateogoria", "&action=eliminar");

    define("chat", "/?controller=ChatController");
    define("enviarMensaje", "&action=enviar");
    define("guardarMensaje", "&action=guardar");
?>