<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="/views/assets/css/registrar.css">
</head>
<body>
<div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="controlador/validar_registro.php" method="post">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="input-container">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <div class="input-container">
                <label for="zona">Zona:</label>
                <select id="zona" name="zona" required>
                    <?php
                    // Incluye el archivo de conexión a la base de datos
                    include("controlador/conexion.php");

                    // Consulta SQL para obtener las zonas
                    $consultaZonas = "SELECT ID, Nombre FROM Zonas";
                    $resultZonas = mysqli_query($conexion, $consultaZonas);

                    // Genera las opciones del menú desplegable para Zona
                    while ($row = mysqli_fetch_assoc($resultZonas)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="input-container">
                <label for="moneda">Moneda Preferida:</label>
                <select id="moneda" name="moneda" required>
                    <?php
                    // Consulta SQL para obtener las opciones de moneda preferida
                    $consultaMonedas = "SELECT DISTINCT MonedaPreferida FROM Usuarios";
                    $resultMonedas = mysqli_query($conexion, $consultaMonedas);

                    // Genera las opciones del menú desplegable para Moneda Preferida
                    while ($row = mysqli_fetch_assoc($resultMonedas)) {
                        echo '<option value="' . $row['MonedaPreferida'] . '">' . $row['MonedaPreferida'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="input-container">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <?php
                    // Consulta SQL para obtener las opciones de roles
                    $consultaRoles = "SELECT ID, Nombre FROM Roles";
                    $resultRoles = mysqli_query($conexion, $consultaRoles);

                    // Genera las opciones del menú desplegable para Rol
                    while ($row = mysqli_fetch_assoc($resultRoles)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit">Registrar</button>
            </div>
        </form>
    </div>
</body>
</html>
