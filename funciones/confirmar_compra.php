<?php
require "conecta.php";
$con = conecta();

session_start();

if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $conexion = conecta(); 

    $idUsuario = $_SESSION['usuario_id'];

    $fechaPedido = date('Y-m-d H:i:s'); 
    $statusPedido = 'En proceso';

    $insertarPedido = $conexion->prepare("INSERT INTO pedidos (producto, cantidad, costo_unitario, subtotal, pedido_id) VALUES (?, ?, ?, ?, ?)");

    foreach ($_SESSION['carrito'] as $producto) {
        $subtotal = $producto['costo'] * $producto['cantidad'];
        $pedidoId = uniqid('', true); 

        $insertarPedido->bind_param("sidds", $producto['nombre'], $producto['cantidad'], $producto['costo'], $subtotal, $pedidoId);
        $insertarPedido->execute();
    }

    $insertarPedido->close();

    $insertarPedidoUsuario = $conexion->prepare("INSERT INTO pedidos_usuario (fecha, id_usuario, status) VALUES (?, ?, ?)");
    $insertarPedidoUsuario->bind_param("sis", $fechaPedido, $idUsuario, $statusPedido);
    $insertarPedidoUsuario->execute();
    $insertarPedidoUsuario->close();

    $conexion->close();

    unset($_SESSION['carrito']);

    header("Location: confirmacion_compra.php");
    exit();
} else {
    echo "<p>No hay artículos en tu carrito.</p>";
}
?>
