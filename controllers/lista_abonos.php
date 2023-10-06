<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/dias_pago.css">
    <title>Fechas de Pago</title>
</head>
<body>

<?php
require_once("conexion.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idPrestamo = $_GET['id'];

    $sql = "SELECT FechaInicio, FrecuenciaPago, Plazo, Cuota, Estado FROM prestamos WHERE ID = $idPrestamo";
    $result = $conexion->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $fechaInicio = new DateTime($row["FechaInicio"]);
        $frecuenciaPago = $row["FrecuenciaPago"];
        $plazo = $row["Plazo"];
        $cuota = $row["Cuota"];
        $estado = $row["Estado"];

        $fechasPago = calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo);

        echo "<div class='container'>";
        echo "<h1>Fechas de Pago</h1>";
        echo "<p class='p'>A pagar: $cuota $frecuenciaPago</p>";
        echo "<table>";
        echo "<tr><th>Frecuencia</th><th>Fecha</th></tr>";
        $numeroFecha = 1;
        foreach ($fechasPago as $fecha) {
            $frecuencia = obtenerFrecuencia($frecuenciaPago, $numeroFecha);
            echo "<tr><td>$frecuencia</td><td>" . $fecha->format("Y-m-d") . "</td></tr>";
            $numeroFecha++;
        }
        echo "</table>";
        echo "</div>";

        if ($estado === "pendiente") {
            echo "<div class='container'>";
            echo "<h1>Registrar Abono</h1>";
            echo "<form action='registrar_abono.php' method='post'>";
            echo "<input type='hidden' name='idPrestamo' value='$idPrestamo'>";
            echo "<label for='abono'>Monto del Abono:</label>";
            echo "<input type='text' id='abono' name='abono'>";
            echo "<input type='submit' value='Registrar Abono'>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "ID de préstamo no válido.";
    }
} else {
    echo "ID de préstamo no proporcionado.";
}

function calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo) {
    $fechasPago = array();

    for ($i = 0; $i < $plazo; $i++) {
        $fechasPago[] = clone $fechaInicio;

        if ($frecuenciaPago === "diario") {
            $fechaInicio->modify("+1 day");
        } elseif ($frecuenciaPago === "semanal") {
            $fechaInicio->modify("+1 week");
        } elseif ($frecuenciaPago === "quincenal") {
            $fechaInicio->modify("+2 weeks");
        } elseif ($frecuenciaPago === "mensual") {
            $fechaInicio->modify("+1 month");
        }
    }

    return $fechasPago;
}

function obtenerFrecuencia($frecuenciaPago, $numeroFecha) {
    switch ($frecuenciaPago) {
        case "diario":
            return "Día $numeroFecha";
        case "semanal":
            return "Semana $numeroFecha";
        case "quincenal":
            return "Quincena $numeroFecha";
        case "mensual":
            return "Mes $numeroFecha";
        default:
            return "";
    }
}

$conexion->close();
?>

</body>
</html>
