<?php
require '../../../../controllers/conexion.php';

function obtenerCuotas($conexion, $filtro) {
    $fechaHoy = date('Y-m-d');
    $cuotas = array();

    // Consulta para obtener los préstamos y verificar los pagos realizados
    $sql = "SELECT p.ID, p.IDCliente, p.MontoCuota, p.FechaInicio, p.FrecuenciaPago,
                   (SELECT COUNT(*) FROM historial_pagos WHERE IDPrestamo = p.ID AND FechaPago = ?) as PagadoHoy,
                   (SELECT SUM(MontoPagado) FROM historial_pagos WHERE IDPrestamo = p.ID) as TotalPagado
            FROM prestamos p
            WHERE p.FechaInicio <= ? AND p.Estado != 'pagado'";
    // Preparar la consulta SQL
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo "Error al preparar la consulta: " . $conexion->error;
        return array();
    }
    $stmt->bind_param("ss", $fechaHoy, $fechaHoy);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            // Verificar si la cuota ha sido pagada hoy
            if ($filtro == 'pagado' && $fila['PagadoHoy'] == 0) continue;
            if ($filtro == 'pendiente' && $fila['PagadoHoy'] > 0) continue;

            // Calcular si hoy es un día de pago según la frecuencia
            if (!esDiaDePago($fila['FechaInicio'], $fila['FrecuenciaPago'], $fechaHoy)) continue;

            // Agregar la fila al array de cuotas
            $cuotas[] = $fila;
        }
    } else {
        // Manejar el error en la ejecución de la consulta
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();

    return $cuotas;
}

function esDiaDePago($fechaInicio, $frecuenciaPago, $fechaHoy) {
    $fechaInicio = new DateTime($fechaInicio);
    $fechaHoy = new DateTime($fechaHoy);

    $intervalo = $fechaInicio->diff($fechaHoy);

    switch ($frecuenciaPago) {
        case 'diario':
            return true;
        case 'semanal':
            return $intervalo->days % 7 == 0;
        case 'quincenal':
            return $intervalo->days % 15 == 0;
        case 'mensual':
            return $fechaInicio->format('d') == $fechaHoy->format('d');
        default:
            return false;
    }
}

// Ejemplo de uso
$cuotasPendientes = obtenerCuotas($conexion, 'pendiente');
$cuotasPagadas = obtenerCuotas($conexion, 'pagado');

?>
