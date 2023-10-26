<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/login.css">
    <title>Iniciar sesión</title>
   
</head>
<body>
<div class="container">
        <div class="login-box">
            <div class="logo">
                <img src="/public/assets/img/logo.png" alt="Logo" class="logo-image">
            </div>
            <h1 class="title">¡Bienvenido!</h1>
            <form action="/controllers/validar_login.php" method="post">
                <div class="input-container">
                    <label for="email" class="label">Correo electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                </div>
                <div class="input-container">
                    <label for="password" class="label">Contraseña:</label>
                    <div class="password-container">
                        <input type="Password" id="Password" name="Password" placeholder="Ingresa tu contraseña" required>
                        <button type="button" id="togglePassword" class="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="login-button">Iniciar sesión</button>
            </form>
            <p class="signup-link">Si olvidastes tu contraseña comunicate con un administrador</p>
        </div>
    </div>
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
