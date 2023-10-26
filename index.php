
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <?php
    if (isset($loginError)) {
        echo '<p>' . $loginError . '</p>';
    }
    ?>
    <form method="post" action="/controllers/validar_login.php">
        <label for="email">Correo Electrónico:</label>
        <input type="text" id="email" name="email" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
