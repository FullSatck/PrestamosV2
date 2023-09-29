<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="/views/assets/css/registrar.css">
</head>
<body>
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="controlador/validar_registro.php" method="post">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Por favor ingrese su nombre" required>
            </div>
            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Por favor ingrese su apellido" required>
            </div>
            <div class="input-container">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Por favor ingrese su correo" required>
            </div>
            <div class="input-container">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Por favor ingrese su clave" required>
            </div>
            <div class="input-container">
                <label for="zona">Zona:</label>
                <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
                    <!-- Agrega opciones aquí -->
                </select>
            </div>
            <div class="input-container">
                <label for="moneda">Moneda Preferida:</label>
                <select id="moneda" name="moneda" required>
                    <!-- Agrega opciones aquí -->
                </select>
            </div>
            <div class="input-container">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <!-- Agrega opciones aquí -->
                </select>
            </div>
            <div class="btn-container">
                <button type="submit">Registrar</button>
            </div>
        </form>
    </div>
</body>
</html>
