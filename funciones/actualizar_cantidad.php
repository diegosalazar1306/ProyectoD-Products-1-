<?php
// actualizar_cantidad.php

session_start();

if (isset($_POST['cantidad']) && isset($_POST['index'])) {
    $cantidad = intval($_POST['cantidad']);
    $index = intval($_POST['index']);

    if ($cantidad > 0) {
        // Actualiza la cantidad en el carrito
        $_SESSION['carrito'][$index]['cantidad'] = $cantidad;

        // Puedes devolver una respuesta al cliente si es necesario
        echo 'Cantidad actualizada exitosamente';
    } else {
        echo 'Error: La cantidad debe ser mayor que cero';
    }
} else {
    echo 'Error: Datos no válidos';
}
?>
