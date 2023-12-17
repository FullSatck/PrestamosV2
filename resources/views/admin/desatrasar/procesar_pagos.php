<?php
date_default_timezone_set('America/Bogota');
include '../../../../controllers/conexion.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamo_id'], $_POST['monto_cuota'], $_POST['fecha_cuota'])) {
    $prestamoId = $_POST['prestamo_id'];
    $montosCuota = $_POST['monto_cuota'];
    $fechasCuota = $_POST['fecha_cuota'];

    $conexion->begin_transaction();

    try {
        // Obtener el monto total a pagar y el ID del cliente del préstamo
        $stmtPrestamo = $conexion->prepare("SELECT MontoAPagar, IDCliente FROM prestamos WHERE ID = ?");
        $stmtPrestamo->bind_param("i", $prestamoId);
        $stmtPrestamo->execute();
        $resultadoPrestamo = $stmtPrestamo->get_result();
        $filaPrestamo = $resultadoPrestamo->fetch_assoc();
        $stmtPrestamo->close();

        if (!$filaPrestamo) {
            throw new Exception("Préstamo no encontrado.");
        }

        $clienteId = $filaPrestamo['IDCliente'];
        $montoRestante = $filaPrestamo['MontoAPagar'];

        // Procesar cada pago
        foreach ($montosCuota as $index => $monto) {
            $fecha = $fechasCuota[$index];

            // Insertar en historial_pagos
            $stmtPago = $conexion->prepare("INSERT INTO historial_pagos (IDCliente, IDPrestamo, MontoPagado, FechaPago) VALUES (?, ?, ?, ?)");
            $stmtPago->bind_param("iids", $clienteId, $prestamoId, $monto, $fecha);
            $stmtPago->execute();
            $stmtPago->close();

            // Actualizar el monto restante
            $montoRestante -= $monto;
            $montoDeuda = max($montoRestante, 0); // Asegurarse de que no sea negativo

            // Insertar en facturas
            $stmtFactura = $conexion->prepare("INSERT INTO facturas (cliente_id, monto, fecha, monto_pagado, monto_deuda, id_prestamos) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtFactura->bind_param("idssii", $clienteId, $monto, $fecha, $monto, $montoDeuda, $prestamoId);
            $stmtFactura->execute();
            $stmtFactura->close();
        }

        // Actualizar el monto total a pagar en prestamos
        $stmtActualizarPrestamo = $conexion->prepare("UPDATE prestamos SET MontoAPagar = ? WHERE ID = ?");
        $stmtActualizarPrestamo->bind_param("di", $montoRestante, $prestamoId);
        $stmtActualizarPrestamo->execute();
        $stmtActualizarPrestamo->close();

        $conexion->commit();
        echo json_encode(["success" => true, "message" => "Pagos procesados correctamente."]);
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(["success" => false, "message" => "Error al procesar los pagos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos POST necesarios no recibidos."]);
}

$conexion->close();
?>
