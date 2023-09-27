<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Login_registro/login/login.css">
    <script src="validacion.js"></script>
    
    <title>Login</title>
</head>

<body>
    <!-- Barra de navegacion -->

    <header class="header">
        <div class="logo">
            <img src="/img/Logo.png" alt="logoImagen">
        </div>
        <nav>
            <ul class="nav-links">
                <li> <a href="/quienes_somos/quienes_somos.html">Quienes somos</a></li>
                <li> <a href="/nuestra_historia/historia.html">Nuestra Historia</a></li>
                <li> <a href="/tecnicas/tecnicas.html">tecnicas</a></li>
                <li><a href="/index.html">Inicio</a></li>
            </ul>
        </nav>
        <a href="/contacto/Contacto.html" class="boton"><button>Contacto</button></a>
    </header>

    <!-- inicio de sesion -->
    <div class="container">
        <h1>Iniciar sesión</h1>
        <?php
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            echo '<p class="error-message">' . $mensaje . '</p>';
        }
        ?>
        <form action="/Login_registro/login/validar.php" method="post">
          <label for="email">Correo electrónico:</label>
          <input type="email" id="email" name="correo" >
      
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="contraseña" >
      
          <button type="submit">Iniciar sesión</button>
        </form>
      
        <p>¿No tienes cuenta? <a href="/Login_registro/registrarse/registrarse.php">Regístrate aquí</a>.</p>
      </div>


    

</body>

</html>