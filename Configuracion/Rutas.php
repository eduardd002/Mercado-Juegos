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

    define("videojuego", "/?controller=VideojuegoController");
    define("inicio", "&action=inicio");
    define("detalle", "&action=detalle");
    define("buscar", "&action=buscar");
    define("crear", "&action=crear");
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

?>