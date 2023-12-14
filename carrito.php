<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre'], $_POST['codigo'], $_POST['costo'], $_POST['cantidad'])) {
        $producto = array(
            'nombre' => $_POST['nombre'],
            'codigo' => $_POST['codigo'],
            'costo' => $_POST['costo'],
            'cantidad' => $_POST['cantidad']
        );
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        $_SESSION['carrito'][] = $producto;

        header('Location: carrito_exito.php');
        exit;
    }
}
?>
