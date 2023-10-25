<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Recuperar los datos del formulario
$id_cliente = $_POST['id_cliente'];
$monto = $_POST['monto'];
$tasa_interes = isset($_POST['TasaInteres']) ? floatval($_POST['TasaInteres']) : 0; // Validar tasa_interes
$plazo = $_POST['plazo'];
$moneda_id = $_POST['moneda_id'];
$fecha_inicio = $_POST['fecha_inicio'];
$frecuencia_pago = $_POST['frecuencia_pago'];
$zona = $_POST['zona'];
$comision = $_POST['comision']; // Nuevo campo de comisión

// Validar que la tasa de interés sea un número válido
if (!is_numeric($tasa_interes)) {
    echo "La tasa de interés no es válida.";
    exit; // Detener la ejecución
}

// Calcular la fecha de vencimiento en función de la frecuencia de pago y el plazo
$fecha_vencimiento = calcularFechaVencimiento($fecha_inicio, $plazo, $frecuencia_pago);

// Calcular el monto total a pagar
// Fórmula: Monto Total a Pagar = Monto + (Monto * Tasa de Interés / 100)
$monto_total = $monto + ($monto * $tasa_interes / 100);

// Verificar si el usuario eligió "Sí" para agregar comisión
if ($comision === 'si') {
    // Calcular la comisión (10%)
    $comision_porcentaje = 10;
    $comision_monto = ($monto_total * $comision_porcentaje) / 100;

    // Añadir la comisión al monto total
    $monto_total += $comision_monto;

    // Actualizar el valor en la base de datos u en cualquier otro lugar necesario
    // ...

    echo "Solicitud de préstamo realizada con éxito. Monto Total a Pagar (incluyendo comisión): $monto_total. Cada cuota es de: $cuota";
} else {
    // El usuario eligió "No", no se agrega comisión
    // ...

    echo "Solicitud de préstamo realizada con éxito. Monto Total a Pagar: $monto_total. Cada cuota es de: $cuota";
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

// Función para calcular las fechas de pago
function calcularFechasPago($fecha_inicio, $frecuencia_pago, $plazo, $id_prestamo, $zona) {
    $fechasPago = array();
    $fecha = new DateTime($fecha_inicio);

    for ($i = 0; $i < $plazo; $i++) {
        $fechasPago[] = clone $fecha;

        switch ($frecuencia_pago) {
            case 'diario':
                $fecha->modify('+1 day');
                break;
            case 'semanal':
                $fecha->modify('+1 week');
                break;
            case 'quincenal':
                $fecha->modify('+2 weeks');
                break;
            case 'mensual':
                $fecha->modify('+1 month');
                break;
        }
    }

    return $fechasPago;
}
?>
