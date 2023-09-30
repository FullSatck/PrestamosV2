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
if ($frecuencia_pago == 'diario') {
    $fecha_vencimiento = date('Y-m-d', strtotime("+$plazo days", strtotime($fecha_inicio)));
} elseif ($frecuencia_pago == 'semanal') {
    $fecha_vencimiento = date('Y-m-d', strtotime("+$plazo weeks", strtotime($fecha_inicio)));
} elseif ($frecuencia_pago == 'quincenal') {
    $fecha_vencimiento = date('Y-m-d', strtotime("+$plazo weeks", strtotime($fecha_inicio)));
} else {
    $fecha_vencimiento = date('Y-m-d', strtotime("+$plazo months", strtotime($fecha_inicio)));
}

// Calcular el monto a pagar
// Fórmula: Monto a pagar = Monto + (Monto * Tasa de Interés / 100)
$monto_a_pagar = $monto + ($monto * $tasa_interes / 100);

// Insertar la solicitud de préstamo en la base de datos
$sql = "INSERT INTO Prestamos (IDCliente, Monto, TasaInteres, Plazo, MonedaID, FechaInicio, FechaVencimiento, Estado, CobradorAsignado, Zona, MontoAPagar) 
        VALUES ('$id_cliente', '$monto', '$tasa_interes', '$plazo', '$moneda_id', '$fecha_inicio', '$fecha_vencimiento', 'pendiente', NULL, '$zona', '$monto_a_pagar')";

if ($conexion->query($sql) === TRUE) {
    echo "Solicitud de préstamo realizada con éxito. Monto a pagar: $monto_a_pagar";
} else {
    echo "Error al solicitar el préstamo: " . $conexion->error;
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
