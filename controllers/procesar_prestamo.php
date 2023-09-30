<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Recuperar los datos del formulario
$id_cliente = $_POST['id_cliente'];
$monto = $_POST['monto'];
$tasa_interes = $_POST['tasa_interes'];
$plazo = $_POST['plazo'];
$moneda_id = $_POST['moneda_id'];
$fecha_inicio = $_POST['fecha_inicio'];
$frecuencia_pago = $_POST['frecuencia_pago'];
$zona = $_POST['zona'];

// Calcular la fecha de vencimiento en función de la frecuencia de pago y el plazo
$fecha_vencimiento = calcularFechaVencimiento($fecha_inicio, $plazo, $frecuencia_pago);

// Calcular el monto total a pagar
// Fórmula: Monto Total a Pagar = Monto + (Monto * Tasa de Interés / 100)
$monto_total = $monto + ($monto * $tasa_interes / 100);

// Calcular el monto de cada cuota
$cuota = $monto_total / $plazo;

// Insertar la solicitud de préstamo en la base de datos
$sql = "INSERT INTO Prestamos (IDCliente, Monto, TasaInteres, Plazo, MonedaID, FechaInicio, FechaVencimiento, Estado, CobradorAsignado, Zona, FrecuenciaPago, MontoAPagar, Cuota, MontoCuota) 
VALUES ('$id_cliente', '$monto', '$tasa_interes', '$plazo', '$moneda_id', '$fecha_inicio', '$fecha_vencimiento', 'pendiente', NULL, '$zona', '$frecuencia_pago', '$monto_total', '$cuota', '$cuota')";


if ($conexion->query($sql) === TRUE) {
    echo "Solicitud de préstamo realizada con éxito. Monto Total a Pagar: $monto_total. Cada cuota es de: $cuota";
} else {
    echo "Error al solicitar el préstamo: " . $conexion->error;
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Función para calcular la fecha de vencimiento en función del plazo y la frecuencia de pago
function calcularFechaVencimiento($fecha_inicio, $plazo, $frecuencia_pago) {
    $fecha = new DateTime($fecha_inicio);

    switch ($frecuencia_pago) {
        case 'diario':
            $fecha->add(new DateInterval('P' . $plazo . 'D'));
            break;
        case 'semanal':
            $fecha->add(new DateInterval('P' . ($plazo * 7) . 'D'));
            break;
        case 'quincenal':
            $fecha->add(new DateInterval('P' . ($plazo * 15) . 'D'));
            break;
        case 'mensual':
            $fecha->add(new DateInterval('P' . $plazo . 'M'));
            break;
        default:
            // Por defecto, se asume pago mensual
            $fecha->add(new DateInterval('P' . $plazo . 'M'));
            break;
    }

    return $fecha->format('Y-m-d');
}
?>