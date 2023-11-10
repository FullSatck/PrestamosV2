<?php
require '../../../../controllers/conexion.php';

function obtenerCuotas($conn, $filtro) {
    $fechaHoy = date('Y-m-d');
    $diaHoy = date('j'); // Día del mes sin ceros iniciales
    $cuotas = [];

    // Iniciar la consulta SQL base
    $sql = "SELECT p.ID, p.IDCliente, p.MontoCuota, p.FechaInicio, p.FrecuenciaPago
            FROM prestamos p
            WHERE p.FechaInicio <= ?";

    // Agregar filtro de estado
    if ($filtro == 'pagado') {
        $sql .= " AND p.Estado = 'pagado'";
    } elseif ($filtro == 'pendiente') {
        $sql .= " AND p.Estado = 'pendiente'";
    } elseif ($filtro == 'nopagado') {
        $sql .= " AND p.Estado = 'nopagado'";
    }

    // Preparar la consulta SQL sin la parte de la frecuencia de pago
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $fechaHoy);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        // Determinar si hoy se debe pagar según la frecuencia de pago
        $diasDiferencia = (new DateTime($fechaHoy))->diff(new DateTime($fila['FechaInicio']))->days;
        
        $debePagarHoy = false;
        switch ($fila['FrecuenciaPago']) {
            case 'diario':
                $debePagarHoy = true; // Todos los días
                break;
            case 'semanal':
                $debePagarHoy = ($diasDiferencia % 7) == 0;
                break;
            case 'quincenal':
                $debePagarHoy = ($diasDiferencia % 14) == 0;
                break;
            case 'mensual':
                $diaInicio = (new DateTime($fila['FechaInicio']))->format('j');
                $debePagarHoy = $diaInicio == $diaHoy;
                break;
        }

        if ($debePagarHoy) {
            $cuotas[] = $fila;
        }
    }

    $stmt->close();
    return $cuotas;
}
