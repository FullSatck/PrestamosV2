<?php
require_once '../../../../controllers/conexion.php';

// Función para calcular el total de los pagos filtrados por fecha
function calcularTotalPagosFiltrados($conexion, $fechaInicio, $fechaFin) {
    $sql = "SELECT SUM(MontoPagado) AS total FROM historial_pagos WHERE FechaPago BETWEEN '$fechaInicio' AND '$fechaFin'";
    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Obtener la fecha de inicio y fin desde la solicitud AJAX
$fechaInicio = $_GET["fecha_inicio"];
$fechaFin = $_GET["fecha_fin"];

// Calcular el total de pagos filtrados por fecha
$totalPagosFiltrados = calcularTotalPagosFiltrados($conexion, $fechaInicio, $fechaFin);

// Formatear el total como una respuesta AJAX
echo "Total: $" . number_format($totalPagosFiltrados, 2);

// Cerrar la conexión a la base de datos
$conexion->close();
?>
