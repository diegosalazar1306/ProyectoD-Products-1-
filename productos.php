<?php   session_start();
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT nombre, archivo_n FROM productos WHERE status = 1 AND eliminado = 0";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->bind_result($nombre, $archivo_n);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/productos.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <title>D-Products</title>
</head>
<body>

<!--Scripts-->
<script>
$(document).ready(function() {
    $(".custom-btn").click(function(event) {
        event.preventDefault();

        var productId = $(this).data("product-id");

        $.ajax({
            url: "funciones/verificar_sesion.php",
            type: "GET",
            success: function(response) {
                if (response.trim() !== "sesion_activa") {
                    window.location.href = "login.php";
                    return;
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    });
});
</script>


<!--Contador de carrito-->
<?php 
$totalcantidad = 0; 

if(isset($_SESSION['carrito'])){
  foreach ($_SESSION['carrito'] as $producto){
    if(isset($producto['cantidad'])){
      $totalcantidad += $producto['cantidad']; 
    }
  }
}
?>

  
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
<!--Icono de carrito-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_cart" style="color: white;"><i class=" fas fa-shopping-cart"></i> <?php echo $totalcantidad; ?></a>
            </li>
          </ul>
          <li class="nav-item d-flex ml-auto" style="color: white;">
              <?php
              // Verifica si hay una sesión iniciada
              if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario'])) {
                  echo 'Bienvenido: ' . $_SESSION['usuario'];
              } else {
                  echo '';
              }
              ?>
          </li>
        </div>
<!--Icono de carrito-->
      </ul>
      <span class="navbar-text">
        D-Products Inc.
      </span>
    </div>
  </div>
</nav>

<!-- Modal carrito -->
<div class="modal fade" id="modal_cart" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLaber">Tu carrito</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
      </div>

      <div class="modal-body">
        <div class="p-2">
          <ul class="list-group mb-3">
            <?php
            $total = 0; 
            if (isset($_SESSION['carrito'])) {
              foreach ($_SESSION['carrito'] as $index => $producto) {
            ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                  <div class="row col-12">
                    <div class="col-6 p-0" style="text-align: left; color: #000000;">
                      <h6 class="my-0">Nombre: <?php echo $producto['nombre']; ?></h6>
                    </div>
                    <div class="col-4 p-0" style="text-align: right; color: #000000;">
                      <span>Cantidad: </span>
                      <input type="number" min="1" value="<?php echo $producto['cantidad']; ?>" class="form-control" onchange="actualizarCantidad(this.value, <?php echo $index; ?>)">
                    </div>
                    <div class="col-2 p-0" style="text-align: right; color: #000000;">
                      <span class="text-muted"><?php echo $producto['costo'] * $producto['cantidad']; ?>$</span>
                      <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarProducto(<?php echo $index; ?>)">X</button>
                    </div>
                  </div>
                </li>
            <?php
                $total += $producto['costo'] * $producto['cantidad'];
              }
            }
            ?>
            <li class="list-group-item d-flex justify-content-between">
              <span style="text-align: left; color: #000000;">Total (MXN)</span>
              <strong style="text-align: left; color: #000000;"><?php echo $total; ?>$</strong>
            </li>
          </ul>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <div class="modal-footer">
          <a type="button" class="btn btn-primary" href="funciones/vaciarcarro.php">Vaciar carrito</a>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-primary" href="confirmacion_carrito.php">Comprar</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
     function actualizarCantidad(cantidad, index) {
        $.ajax({
          type: 'POST',
          url: 'funciones/actualizar_cantidad.php', 
          data: {
            cantidad: cantidad,
            index: index
          },
          success: function(response) {
            console.log(response); 
          },
          error: function(error) {
            console.error('Error en la solicitud AJAX', error);
          }
        });
        }

    function actualizarModalCarrito() {
        $.ajax({
            url: 'funciones/obtener_carrito.php',
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                $('#modal_cart .modal-body').html(response);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function eliminarProducto(index) {
    console.log("Haciendo clic en eliminarProducto para el índice: ", index);
    $.ajax({
        url: 'funciones/eliminar_producto.php',
        type: 'POST',
        data: { index: index },
        success: function(response) {
            if (response.success) {
                console.log("Producto eliminado exitosamente");
                location.reload(); 
            } else {
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}


    $(document).ready(function() {
    $(".agregar-carrito").on("click", function() {
        var productId = $(this).data("product-id");
        var cantidad = $("#cantidad_" + productId).val();

        $.ajax({
            url: "funciones/agregar_al_carrito.php",
            method: "POST",
            data: {
                id: productId,
                cantidad: cantidad,
                nombre: $("#nombre_" + productId).val(),
                codigo: $("#codigo_" + productId).val(),
                costo: $("#costo_" + productId).val()
            },
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                location.reload(); 
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});

    function comprarAhora() {
    window.location.href = "confirmacion_carrito.php";
}

</script>
<!-- End Modal carrito -->


<!--Banner-->
<div class="banner">
  <h1 class="display-4 fw-bold">Todo lo que buscas con un solo clic</h1>
  <p>"Explora el poder del gaming como un león, conquista tus desafíos virtuales."</p>
</div>

<!-- Cards -->
<div class="container">
    <?php
    $con = conecta();
    $sql = "SELECT id, codigo, nombre, costo, archivo_n FROM productos WHERE status = 1 AND eliminado = 0";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($id, $codigo, $nombre, $costo, $archivo_n);

    $contador = 0;

    while ($stmt->fetch()) {
    ?>
       <div class="card">
        <figure>
          <img class="fixed-size-image" src="../Admin/archivos_productos/<?php echo $archivo_n; ?>" alt="">
        </figure>
        <form class="formulario" method="post" action="carrito.php">
          <div class="contenido">
            <h3><?php echo $nombre; ?></h3>
            <p>Código: <?php echo $codigo; ?></p>
            <p>Costo: <?php echo $costo; ?></p>
            <label for="cantidad_<?php echo $id; ?>" class="mr-2"></label>
            <p>Selecciona una cantidad</p>
            <input type="number" name="cantidad" id="cantidad_<?php echo $id; ?>" value="1" min="1" class="form-control mr-2">
            <a href="detalle.php?id=<?php echo $id; ?>">Ver detalles del producto</a>
            
            <button type="button" class="btn btn-primary custom-btn agregar-carrito" data-product-id="<?php echo $id; ?>">
                <i class="fas fa-shopping-cart"></i> Agregar al carrito
            </button>


            <input name="nombre" type="hidden" id="nombre_<?php echo $id; ?>" value="<?php echo $nombre; ?>"/>
            <input name="codigo" type="hidden" id="codigo_<?php echo $id; ?>" value="<?php echo $codigo; ?>"/>
            <input name="costo" type="hidden" id="costo_<?php echo $id; ?>" value="<?php echo $costo; ?>"/>
            <input name="cantidad" type="hidden" id="cantidad" value="cantidad"/>
          </div>
        </form>
      </div>
      
      <?php
        $contador++;
        if ($contador == 3) {
            echo '</div><div class="container">';
            $contador = 0;
        }
    }

    if ($contador != 0) {
        echo '</div>';
    }

    $stmt->close();
    $con->close();
    ?>
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
