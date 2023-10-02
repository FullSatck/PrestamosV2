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
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Zona</title>
    <link rel="stylesheet" href="/public/assets/css/agregar_cobro.css">
</head>
<body>
    <h2>Agregar Zona</h2>
   <center><form action="validar_cobro.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        
        <label for="cobrador_asignado">Cobrador Asignado:</label>
        <select id="cobrador_asignado" name="cobrador_asignado" required>
            <?php
            // Realiza la conexión a la base de datos (ajusta los detalles de conexión según tu configuración)
            include("../../../../controllers/conexion.php");

            // Query SQL para obtener la lista de usuarios disponibles como cobradores
            $sql = "SELECT ID, Nombre FROM usuarios WHERE RolID = 'Cobrador'";
            $result = mysqli_query($conexion, $sql);

            // Muestra la lista de usuarios en un menú desplegable
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row["ID"] . '">' . $row["Nombre"] . '</option>';
            }

            // Cierra la conexión a la base de datos
            mysqli_close($conexion);
            ?>
        </select>
        
        <button type="submit">Agregar Zona</button>
    </form></center> 
</body>
</html>
