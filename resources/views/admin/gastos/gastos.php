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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/gastos.css">
    <title>Lista de Gastos</title>
</head>
<body>
    <h1>Lista de Gastos</h1>

    <!-- Botón para agregar gastos -->
    <a href="agregar_gasto.php">Agregar Gasto</a>

    <?php
    // Incluye la configuración de conexión a la base de datos
    include "../../../../controllers/conexion.php"; // Asegúrate de que la ruta sea correcta

    // Realiza la consulta para obtener los gastos con el nombre de la zona
    $sql = "SELECT G.ID, Z.Nombre AS NombreZona, G.Fecha, G.Descripcion, G.Valor 
            FROM Gastos G
            INNER JOIN Zonas Z ON G.IDZona = Z.ID";
    $resultado = $conexion->query($sql);

    // Crear una tabla HTML para mostrar las columnas de las filas
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Zona</th>';
    echo '<th>Fecha</th>';
    echo '<th>Descripción</th>';
    echo '<th>Valor</th>';
    echo '</tr>';

    // Verifica si hay gastos en la base de datos
    if ($resultado->num_rows > 0) {
        // Si hay gastos, itera a través de los resultados y muestra cada gasto
        while ($fila = $resultado->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $fila['ID'] . '</td>';
            echo '<td>' . $fila['NombreZona'] . '</td>';
            echo '<td>' . $fila['Fecha'] . '</td>';
            echo '<td>' . $fila['Descripcion'] . '</td>';
            echo '<td>' . $fila['Valor'] . '</td>';
            echo '</tr>';
        }
    } else {
        // Si no hay gastos, muestra una fila con celdas vacías
        echo '<tr>';
        echo '<td colspan="5">No se encontraron gastos en la base de datos.</td>';
        echo '</tr>';
    }

    echo '</table>';

    // Cierra la conexión a la base de datos
    $conexion->close();
    ?>
</body>
</html>
