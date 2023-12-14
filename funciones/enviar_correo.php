<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Título</title>
    <link rel="stylesheet" type="text/css" href="../css/enviar_correo.css">
    <meta http-equiv="refresh" content="5;url=../index.php">
</head>
<body>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpMailer/PHPMailer.php';
require '../phpMailer/SMTP.php';
require '../phpMailer/Exception.php';

function enviarCorreo($nombre, $correo, $mensaje) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'diego.szr13@gmail.com';
        $mail->Password   = 'jhql tbei shvw krav'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;


        $mail->setFrom('diego.szr13@gmail.com', 'Diego Salazar');
        $mail->addAddress('diego.szr13@gmail.com');

 
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "Nombre: $nombre <br>Correo: $correo <br>Mensaje: $mensaje";

      
        $mail->send();
        
        return true; 
    } catch (Exception $e) {
   
        error_log("Error al enviar el mensaje: {$mail->ErrorInfo}");
        
        return false; 
    }
}

if (isset($_REQUEST['enviar'])) {
    $nombre = $_REQUEST['name'];
    $correo = $_REQUEST['email'];
    $mensaje = $_REQUEST['message'];

   
    if (!empty($nombre) && !empty($correo) && !empty($mensaje)) {
    
        if (enviarCorreo($nombre, $correo, $mensaje)) {
            echo '<div class="mensaje-container"><p class="mensaje-exito">El mensaje ha sido enviado correctamente</p></div>';
          
            header('Refresh: 5; URL=index.php');
        } else {
            echo '<div class="mensaje-container"><p>Error al enviar el mensaje. Por favor, inténtalo más tarde.</p></div>';
        }
    } else {
        echo 'Por favor, completa todos los campos del formulario.';
    }
}
?>

</body>
</html>
