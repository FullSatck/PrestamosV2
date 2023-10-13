<?php
include("../../../../controllers/conexion.php");

// Obtener la fecha actual
$fechaActual = date("Y-m-d");

// Consulta SQL para obtener los préstamos que deben pagarse hoy o antes de hoy
$sql = "SELECT ID, IDCliente, Monto, FechaVencimiento FROM prestamos WHERE FechaVencimiento <= '$fechaActual'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Préstamos a Pagar Hoy o Antes de Hoy ($fechaActual)</h1>";
    echo "<table>";
    echo "<tr><th>ID Préstamo</th><th>ID Cliente</th><th>Monto</th><th>Fecha de Vencimiento</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $prestamoID = $row["ID"];
        $clienteID = $row["IDCliente"];
        $monto = $row["Monto"];
        $fechaVencimiento = $row["FechaVencimiento"];

        echo "<tr><td>$prestamoID</td><td>$clienteID</td><td>$monto</td><td>$fechaVencimiento</td></tr>";
    }

    echo "</table>";
} else {
    echo "No hay préstamos para pagar hoy o antes de hoy.";
}

$conexion->close();
?>
