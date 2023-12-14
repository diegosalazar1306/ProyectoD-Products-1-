<?php
session_start();

if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {

    $compraExitosa = true;

    if ($compraExitosa) {
        unset($_SESSION['carrito']);

        header("Location: funciones/confirmacion_compra.php");
        exit();
    } else {
        echo "<p>Error al procesar la compra. Por favor, inténtalo de nuevo.</p>";
    }
} else {
    echo "<p>No hay artículos en tu carrito para comprar.</p>";
}
?>
