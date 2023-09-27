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
    <!-- inicio de sesion -->
    <div class="container">
        <h1>Iniciar sesión</h1>
        <?php
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            echo '<p class="error-message">' . $mensaje . '</p>';
        }
        ?>
        <form action="/controlador/validar_login.php" method="post">
          <label for="usuario">Usuario:</label>
          <input type="usuario" id="usuario" name="usuario" >
      
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="contraseña" >
      
          <button type="submit">Iniciar sesión</button>
        </form>
      
        <p>¿No tienes cuenta? <a href="/Login_registro/registrarse/registrarse.php">Regístrate aquí</a>.</p>
      </div>


    

</body>

</html>