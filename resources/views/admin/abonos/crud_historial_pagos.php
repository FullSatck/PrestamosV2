<?php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Incluye el archivo de conexión a la base de datos
include '../../../../controllers/conexion.php';

// Obtén el ID del cliente actual (puedes obtenerlo de alguna manera, por ejemplo, de la URL)
$clienteId = $_GET['clienteId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/crudHpsgod.css">
    <title>CRUD de Historial de Pagos</title>
</head>
<body>
    <h1>Historial de Pagos</h1>

    <!-- Formulario para agregar un nuevo pago -->



    <!-- Listado de pagos -->
    <h2>Historial de Pagos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Monto Pagado</th>
           
        </tr>
        <?php
        // PHP para consultar y mostrar el historial de pagos
        $sql = "SELECT * FROM historial_pagos WHERE IDCliente = $clienteId";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['FechaPago'] . "</td>";
                echo "<td>" . $row['MontoPagado'] . "</td>";
              
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron pagos.</td></tr>";
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
    </table>
</body>
</html>
