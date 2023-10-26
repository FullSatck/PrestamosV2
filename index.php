<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/login.css">
    <title>Iniciar sesión</title>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="/controllers/validar_login.php" method="post">
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>


    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('Password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'Password' ? 'text' : 'Password';
            passwordInput.setAttribute('type', type);
            togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>