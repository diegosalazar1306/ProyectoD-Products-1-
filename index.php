<?php
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT nombre, archivo FROM promociones WHERE eliminado = 0 ORDER BY RAND() LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->bind_result($nombre, $archivo);
$stmt->fetch();
$stmt->close();
$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/index.css">
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
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $con = conecta();
            $sql = "SELECT nombre, archivo FROM promociones WHERE eliminado = 0";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($nombre, $archivo);

            $first = true; 
            while ($stmt->fetch()) {
                $activeClass = $first ? 'active' : ''; 
            ?>
            <div class="carousel-item <?php echo $activeClass; ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-5">
                            <h1 class="display-4 fw-bold">BUEN FIN 2023</h1>
                            <h2 class="display-4 fw-bold"><?php echo $nombre; ?></h2>
                            <p>El poder de un videojuego en tus manos, ahora con un precio increíble podrás llevar la experiencia de jugar, ver videos, reproducir música al instante y con mayor fluidez..</p>
                            <button class="btn btn-success"><a href="productos.php" class="text-white text-decoration-none">Leer más</a></button>
                        </div>
                        <div class="col-sm-7">
                        <img class="fixed-size-image" src="../Admin/archivos_promociones/<?php echo $archivo; ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $first = false; 
            }
            $stmt->close();
            $con->close();
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Contenido -->
<div class="container">
    <div class="row">
        <?php
        $con = conecta();
        $sql = "SELECT nombre, archivo FROM promociones WHERE eliminado = 0 ORDER BY RAND() LIMIT 6";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($nombre, $archivo);
        $textos_productos = array(
            "Domina el juego, sé leyenda.",
            "Experimenta la emoción del gaming puro.",
            "Haz historia con cada clic.",
            "Vive, juega, conquista.",
            "Enciende la pasión del gaming.",
            "Explora mundos virtuales, crea realidades épicas.",
            "El poder está en tus manos, ¡juega ahora!",
            "Conquista el universo virtual.",
            "Siente la adrenalina, sé imparable.",
            "Despierta al gamer dentro de ti.",
        );

        $contador = 0;

        while ($stmt->fetch()) {
            $indice_texto = rand(0, count($textos_productos) - 1);
            $texto_producto = $textos_productos[$indice_texto];
        ?>
            <div class="col-md-4">
                <div class="card">
                    <figure>
                        <img class="fixed-size-image" src="../Admin/archivos_promociones/<?php echo $archivo; ?>" alt="">
                    </figure>
                    <div class="contenido">
                        <h3><?php echo $nombre; ?></h3>
                        <p><?php echo $texto_producto; ?></p>
                        <a href="productos.php">Leer más</a>
                    </div>
                </div>
            </div>
        <?php
            $contador++;
        }

    
        if ($contador % 3 !== 0) {
            echo '</div>';
        }

        $stmt->close();
        $con->close();
        ?>
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