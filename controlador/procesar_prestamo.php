<?php
// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Procesar la solicitud de préstamo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $monto = $_POST["monto"];
    $tasaInteresAnual = $_POST["tasaInteres"] / 100; // Convertir la tasa de interés a decimal
    $plazo = $_POST["plazo"];
    $frecuenciaPago = $_POST["frecuenciaPago"];
    $clienteID = $_POST["clienteID"];
    $zona = $_POST["zona"]; // Variable para la zona

    // Calcular la tasa de interés periódica
    if ($frecuenciaPago === "mensual") {
        $tasaInteresPeriodica = $tasaInteresAnual / 12;
    } elseif ($frecuenciaPago === "quincenal") {
        $tasaInteresPeriodica = $tasaInteresAnual / 24;
    } elseif ($frecuenciaPago === "semanal") {
        $tasaInteresPeriodica = $tasaInteresAnual / 52;
    } elseif ($frecuenciaPago === "diario") {
        $tasaInteresPeriodica = $tasaInteresAnual / 365;
    } else {
        // Manejar casos no válidos o desconocidos
        echo "Frecuencia de pago no válida.";
        exit;
    }

    // Calcular el número total de pagos
    if ($frecuenciaPago === "mensual") {
        $numeroPagos = $plazo;
    } elseif ($frecuenciaPago === "quincenal") {
        $numeroPagos = $plazo * 2;
    } elseif ($frecuenciaPago === "semanal") {
        $numeroPagos = $plazo * 4;
    } elseif ($frecuenciaPago === "diario") {
        $numeroPagos = $plazo * 30; // Suponiendo un mes de 30 días
    }

    // Calcular el monto del pago periódico
    if ($tasaInteresPeriodica > 0) {
        $factor = (1 + $tasaInteresPeriodica) ** $numeroPagos; // Utilizar ** en lugar de pow
        $montoPago = ($monto * $tasaInteresPeriodica * $factor) / ($factor - 1);
    } else {
        $montoPago = $monto / $numeroPagos;
    }

    // Calcular la fecha de inicio (hoy)
    $fechaInicio = date("Y-m-d");

    // Calcular la fecha de vencimiento
    if ($frecuenciaPago === "mensual") {
        $fechaVencimiento = date("Y-m-d", strtotime("+{$plazo} months", strtotime($fechaInicio)));
    } elseif ($frecuenciaPago === "quincenal") {
        $fechaVencimiento = date("Y-m-d", strtotime("+{$plazo * 15} days", strtotime($fechaInicio)));
    } elseif ($frecuenciaPago === "semanal") {
        $fechaVencimiento = date("Y-m-d", strtotime("+{$plazo * 7} days", strtotime($fechaInicio)));
    } elseif ($frecuenciaPago === "diario") {
        $fechaVencimiento = date("Y-m-d", strtotime("+{$plazo} days", strtotime($fechaInicio)));
    }

    // Insertar los detalles del préstamo en la base de datos
    $sql = "INSERT INTO Prestamos (IDCliente, Monto, TasaInteres, Plazo, MonedaID, FechaInicio, FechaVencimiento, Estado, CobradorAsignado, Zona)
            VALUES ($clienteID, $monto, $tasaInteresAnual, $plazo, 1, '$fechaInicio', '$fechaVencimiento', 'pendiente', 1, '$zona')";

    if ($conn->query($sql) === TRUE) {
        echo "Préstamo solicitado con éxito.";
    } else {
        echo "Error al solicitar el préstamo: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos (si es necesario)
$conn->close();
?>
