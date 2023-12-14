<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <title>D-Products</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<!--Iniciar sesion-->
<script>
        function verificarUsuario() {
            var correo = document.forma01.correo.value;
            var pass = document.forma01.pass.value;

            if (correo.trim() === '' || pass.trim() === '') {
                mostrarError("Por favor, completa todos los campos.");
                return;
            }
            mostrarError("");

            $.ajax({
                type: "POST",
                url: "funciones/verificarUsuario.php",
                data: { correo: correo, pass: pass },
                success: function (response) {
                    console.log("Respuesta del servidor:", response);

                    if (response === "success") {
                        window.location.href = "productos.php";
                    } else if (response === "inactive") {
                        mostrarError("Usuario inactivo o eliminado.");
                    } else {
                        mostrarError("Correo o contraseña incorrectos");
                    }
                }
            });
        }

        function mostrarError(mensaje) {
            $("#error-message").text(mensaje);
            setTimeout(function() {
                $("#error-message").text("");
            }, 5000);
        }
    </script>
</head>

<body>

      <div class="formulario">
    <h1>Necesitas iniciar sesión antes para seguir comprando!</h1>
    <h2>Iniciar Sesión</h2>
    <form name="forma01" method="post">
        <div class="correo">
            <input type="text" name="correo" id="correo" placeholder="Escribe tu correo" />
            <label></label>
        </div>
        <div class="correo">
            <input type="password" name="pass" id="pass" placeholder="Escribe tu contraseña" />
            <label></label>
        </div>
        <input type="button" value="Iniciar Sesión" onclick="verificarUsuario();">
    </form>
</div>
</body>
</html>

