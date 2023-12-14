<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_POST['nombre'], $_POST['codigo'], $_POST['costo'], $_POST['cantidad'])) {

  $nombre = $_POST['nombre'];
  $codigo = $_POST['codigo'];
  $costo = $_POST['costo'];
  $cantidad = $_POST['cantidad'];


  if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
  }

  $producto = [
    'nombre' => $nombre,
    'codigo' => $codigo,
    'costo' => $costo,
    'cantidad' => $cantidad,
  ];

  $_SESSION['carrito'][] = $producto;

  header('Content-Type: application/json');
  echo json_encode($_SESSION['carrito']);
} else {
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Parámetros insuficientes']);
}
?>

