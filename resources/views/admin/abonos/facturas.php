<?php
// Verifica si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("location: ../../../../index.php");
    exit();
}

// Incluye el archivo de conexión a la base de datos
include '../../../../controllers/conexion.php';

// Obtén el ID del cliente desde la URL
$clienteId = $_GET['clienteId'];

// PHP para consultar y mostrar el historial de pagos
$sql = "SELECT * FROM historial_pagos WHERE IDCliente = $clienteId";
$result = $conexion->query($sql);

// Inicializa una variable para almacenar el contenido de la factura
$invoiceContent = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Genera una factura para cada pago en el historial
        $invoiceContent .= "<div class='invoice'>";
        $invoiceContent .= "<h1>Factura</h1>";
        $invoiceContent .= "<p>ID de Pago: " . $row['ID'] . "</p>";
        $invoiceContent .= "<p>Fecha de Pago: " . $row['FechaPago'] . "</p>";
        $invoiceContent .= "<p>Monto Pagado: $" . $row['MontoPagado'] . "</p>";
        // Agrega más detalles de la factura según tus necesidades
        $invoiceContent .= "</div>";
    }
} else {
    $invoiceContent = "<p>No se encontraron pagos para generar facturas.</p>";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="/public/assets/css/facturas.css"> <!-- Agrega un archivo CSS para dar estilo a la factura -->
    <title>Generador de Facturas</title>
</head>
<body>
    <?php
    // Muestra las facturas generadas
    echo $invoiceContent;
    ?>
</body>
</html>
