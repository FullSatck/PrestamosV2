<?php
require '../../../../controllers/conexion.php';

function obtenerCuotas($conexion, $filtro) {
    $fechaHoy = date('Y-m-d');
    $cuotas = array();

    // Consulta SQL base
    $sql = "SELECT p.ID, p.IDCliente, p.MontoCuota, p.FechaInicio, p.FrecuenciaPago, p.Pospuesto,
    c.Nombre AS NombreCliente, c.Domicilio AS DireccionCliente, c.Telefono AS TelefonoCliente,
    (SELECT COUNT(*) FROM historial_pagos WHERE IDPrestamo = p.ID AND FechaPago = ?) as PagadoHoy,
    (SELECT SUM(MontoPagado) FROM historial_pagos WHERE IDPrestamo = p.ID) as TotalPagado
       FROM prestamos p
         INNER JOIN clientes c ON p.IDCliente = c.ID
           WHERE p.FechaInicio <= ?";

    // Modificar la consulta según el filtro
    switch ($filtro) {
        case 'pagado':
            $sql .= " AND (p.Estado = '' OR EXISTS (SELECT 1 FROM historial_pagos WHERE IDPrestamo = p.ID AND FechaPago = ?))";
            break;
            case 'pendiente':
                $sql .= " AND p.Estado = 'pendiente' AND p.Pospuesto = 0 AND NOT EXISTS (SELECT 1 FROM historial_pagos WHERE IDPrestamo = p.ID AND FechaPago = ?)";
                break;
            
                case 'nopagado':
                    $sql .= " AND p.Pospuesto = 1";
                    break;
                
    }

    // Preparar la consulta SQL
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo "Error al preparar la consulta: " . $conexion->error;
        return array();
    }

    // Ajustar el bind_param según el filtro
  
if ($filtro == 'pagado' || $filtro == 'pendiente') {
    $stmt->bind_param("sss", $fechaHoy, $fechaHoy, $fechaHoy); // Tres parámetros para 'pagado' y 'pendiente'
} else {
    $stmt->bind_param("ss", $fechaHoy, $fechaHoy); // Dos parámetros para 'nopagado'
}

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            // Verificar si la cuota ha sido pagada hoy (solo para filtro 'pendiente')
            if ($filtro == 'pendiente' && $fila['PagadoHoy'] > 0) continue;

            // Calcular si hoy es un día de pago según la frecuencia (solo para filtro 'pendiente')
            if ($filtro == 'pendiente' && !esDiaDePago($fila['FechaInicio'], $fila['FrecuenciaPago'], $fechaHoy)) continue;

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
?>