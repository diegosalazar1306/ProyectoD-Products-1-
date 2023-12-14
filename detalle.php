<?php
require "funciones/conecta.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $con = conecta();

    $sql = "SELECT nombre, codigo, descripcion, costo, archivo_n FROM productos WHERE id = ? AND status = 1 AND eliminado = 0";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $codigo, $descripcion, $costo, $archivo_n);
    $stmt->fetch();
    $stmt->close();
    $con->close();
} else {
    echo "Error: Producto no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/detalle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <title>D-Products</title>
</head>
<body>
  
  <!--Navbar-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="productos.php">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contacto.php">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="carrito.php">Carrito</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Iniciar sesión</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logoff.php">Cerrar sesión</a>
        </li>
      </ul>
      <span class="navbar-text">
        D-Products Inc.
      </span>
    </div>
  </div>
</nav>

<!--Banner-->
<div class="banner">
  <h1 class="display-4 fw-bold">Todo lo que buscas con un solo clic</h1>
  <p>"Explora el poder del gaming como un león, conquista tus desafíos virtuales."</p>
</div>


<!-- Detalles del producto -->
<div class="container">
    <div class="card">
        <div class="contenido">
            <h3><?php echo $nombre; ?></h3>
            <p>Código: <?php echo $codigo; ?></p>
            <p>Descripción: <?php echo $descripcion; ?></p>
            <p>Costo: $<?php echo $costo; ?></p>
            <a href="productos.php">Regresar</a>
            <img src="../Admin/archivos_productos/<?php echo $archivo_n; ?>" alt="<?php echo $nombre; ?>">
        </div>
    </div>
</div>


<!--Footer-->
  <footer class="text-center text-lg-start bg-body-tertiary text-muted">
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Derechos reservados:
          </h6>
          <p>
          © 2023 D-Products. Todos los derechos reservados. El contenido, diseño y elementos visuales de este sitio web están protegidos 
          por las leyes de propiedad intelectual. Queda estrictamente prohibida la reproducción total o parcial sin la autorización expresa de D-Products.
          </p>
        </div>
   
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            Términos y Condiciones:
          </h6>
          <p>
          Al acceder y utilizar nuestro sitio web, aceptas cumplir con nuestros términos y condiciones. Estos términos rigen tu uso de D-Products, incluida la compra de productos. Por favor, lee detenidamente nuestros términos y condiciones antes de realizar cualquier transacción. Si tienes alguna pregunta, no dudes en ponerte en contacto con nuestro equipo de atención al cliente.
          </p>
        </div>

        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            Redes sociales:
          </h6>
          <p>
            <a href="#!" class="text-reset">Facebook</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Instagram</a>
          </p>
          <p>
            <a href="#!" class="text-reset">YouTube</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Twitter</a>
          </p>
        </div>
      </div>
    </div>
  </section>
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2023 Copyright:
    <a class="text-reset fw-bold">D-Products Inc.</a>
  </div>
</footer>
</body>
</html>
