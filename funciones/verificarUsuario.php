<?php
require "conecta.php";
$con = conecta();

$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$passEnc = md5($pass);

$sql = "SELECT * FROM usuarios
        WHERE correo = '$correo' AND (pass = '$pass' OR pass_enc = '$passEnc')
        AND status = 1 AND eliminado = 0";

$res = $con->query($sql);
$num = $res->num_rows;

if ($num > 0) {
    session_start(); 

    $usuarioData = $res->fetch_assoc();
    
    $_SESSION['usuario_id'] = $usuarioData['id'];
    $_SESSION['usuario'] = $usuarioData['usuario'];

    echo "success";
} else {
    $inactiveSql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $inactiveRes = $con->query($inactiveSql);

    if ($inactiveRes->num_rows > 0) {
        $inactiveRow = $inactiveRes->fetch_assoc();

        if ($inactiveRow['eliminado'] == 1) {
            echo "inactive";
        } else {
            echo "failed (contraseña incorrecta)";
        }
    } else {
        echo "failed (usuario no encontrado)";
    }
}

$con->close();
?>
