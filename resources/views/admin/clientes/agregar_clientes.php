<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?> 




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/registrar_cliente.css">
    <title>Registro de Clientes</title>
</head>

<body>
    <div class="container">
        <h1>Registro de Clientes</h1>
        <form action="/controllers/validar_clientes.php" method="POST" enctype="multipart/form-data">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>

            <div class="input-container">
                <label for="curp">Identificación CURP:</label>
                <input type="text" id="curp" name="curp" required>
            </div>

            <div class="input-container">
                <label for="domicilio">Domicilio:</label>
                <input type="text" id="domicilio" name="domicilio" required>
            </div>

            <div class="input-container">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>

            <div class="input-container">
                <label for="historial">Historial Crediticio:</label>
                <textarea id="historial" name="historial" rows="4"></textarea>
            </div>

            <div class="input-container">
                <label for="referencias">Referencias Personales:</label>
                <textarea id="referencias" name="referencias" rows="4"></textarea>
            </div>

            <div class="input-container">
                <label for="moneda">Moneda Preferida:</label>
                <select id="moneda" name="moneda">
                    <?php
                    require_once("../../../../controllers/conexion.php");

                    $query = "SELECT * FROM monedas";
                    $result = mysqli_query($conexion, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . "</option>";
                    }

                    mysqli_close($conexion);
                    ?>
                </select>
            </div>

            <div class="input-container">
                <label for="zona">Zona:</label>
                <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
                    <?php
                    // Incluye el archivo de conexión a la base de datos
                    include("../../../../controllers/conexion.php");
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
                <label for="imagen">Imagen del Cliente:</label>
                <input type="file" id="imagen" name="imagen">
            </div>

            <div class="btn-container">
                <input class="btn-container" type="submit" value="Registrar">
            </div>
        </form>
    </div>
    <script src="/public/assets/js/mensaje.js"></script> 
</body>

</html>
