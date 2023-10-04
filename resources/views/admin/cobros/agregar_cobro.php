<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}


?>


<!DOCTYPE html>
<html>

<head>
    <title>Formulario para Agregar estado</title>
    <link rel="stylesheet" href="/public/assets/css/agregar_cobro.css">
</head>

<body>
    <div class="container">
        <h2>Formulario para Agregar estado</h2>
        
        <!-- Mostrar el mensaje de confirmación aquí -->
        <div id="mensaje">
            <?php
            if (isset($_GET['mensaje'])) {
                echo htmlspecialchars($_GET['mensaje']);
            }
            ?>
        </div>

        <form action="/controllers/guardarZona.php" method="POST">
            <label for="nombre">Nombre de la estado:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="capital">Capital de la estado:</label>
            <input type="text" id="capital" name="capital" required>
            
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" id="codigo_postal" name="codigo_postal">
            
            <input type="submit" value="Agregar Zona">
        </form>
    </div>

    <script src="/public/assets/js/mensaje.js"></script> 
</body
</html>