<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["index"])) {
    $index = $_POST["index"];

    if (isset($_SESSION["carrito"][$index])) {
        unset($_SESSION["carrito"][$index]);

        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
exit;
?>
