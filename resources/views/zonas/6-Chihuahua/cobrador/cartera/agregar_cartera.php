<?php
// Archivo: agregar_cartera.php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Incluye la configuración de conexión a la base de datos
 require_once '../../../../controllers/conexion.php'; 

    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $idZona = $_POST["idZona"];

    // Preparar la consulta para insertar una nueva cartera
    $stmt = $conexion->prepare("INSERT INTO cartera (nombre, IDZona) VALUES (?, ?)");
    $stmt->bind_param("si", $nombre, $idZona);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de la lista de carteras después de agregar exitosamente
        header("Location: lista_cartera.php");
        exit();
    } else {
        echo "Error al agregar la cartera: " . $conexion->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Agregar Cartera</title>
</head>

<body>
    <h2>Agregar Nueva Cartera</h2>
    <form method="post" action="agregar_cartera.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br><br>

        <label for="zona">Zona:</label>
        <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
            <?php
                // Incluye el archivo de conexión a la base de datos
                include("../../../../controllers/conexion.php");
                // Consulta SQL para obtener las zonas
                $consultaZonas = "SELECT ID, Nombre FROM zonas";
                $resultZonas = mysqli_query($conexion, $consultaZonas);
                // Genera las opciones del menú desplegable para Zona
                while ($row = mysqli_fetch_assoc($resultZonas)) {
                    echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                }
                ?>
        </select><br><br>

        <input type="submit" value="Agregar">
    </form>
</body>

</html>