<?php
// Incluir el archivo de conexión a la base de datos
require_once("conexion.php");

// Obtener la zona del supervisor desde la solicitud AJAX
$zonaSupervisor = $_GET["zona"];

// Obtener la fecha actual
$fechaHoy = date("Y-m-d");

// Consulta SQL para obtener los préstamos pendientes para hoy en la zona del supervisor
$sql = "SELECT p.ID, c.Nombre AS Cliente, p.Monto, p.FrecuenciaPago
        FROM prestamos p
        INNER JOIN clientes c ON p.IDCliente = c.ID
        WHERE p.Estado = 'pendiente' AND '$fechaHoy' BETWEEN p.FechaInicio AND p.FechaVencimiento
        AND p.Zona = '$zonaSupervisor'"; // Filtrar por la zona del supervisor

$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";

    while ($row = $result->fetch_assoc()) {
        $prestamoID = $row["ID"];
        $cliente = $row["Cliente"];
        $monto = $row["Monto"];
        $frecuenciaPago = $row["FrecuenciaPago"];

        echo "<li>ID: $prestamoID - Cliente: $cliente - Monto: $monto - Frecuencia de Pago: $frecuenciaPago</li>";
    }

    echo "</ul>";
} else {
    echo "No se encontraron préstamos pendientes para hoy en la Zona: $zonaSupervisor.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
