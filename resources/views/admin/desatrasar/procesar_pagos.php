<?php
date_default_timezone_set('America/Bogota');
session_start();
include '../../../../controllers/conexion.php';

header('Content-Type: application/json'); // Indicar que la respuesta será en formato JSON

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamo_id'], $_POST['monto_cuota'], $_POST['fecha_cuota'])) {
    $prestamoId = $_POST['prestamo_id'];
    $montosCuota = $_POST['monto_cuota'];
    $fechasCuota = $_POST['fecha_cuota'];
    $usuarioId = $_SESSION['usuario_id']; // Asumiendo que el ID del usuario está almacenado en la sesión

    $conexion->begin_transaction();

    try {
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

        foreach ($montosCuota as $index => $monto) {
            $fecha = $fechasCuota[$index];

            // Verificar si el monto de la cuota es mayor que cero
            if (!empty($monto)) {
                // Insertar la cuota en el historial de pagos
                $stmtPago = $conexion->prepare("INSERT INTO historial_pagos (IDCliente, IDPrestamo, MontoPagado, FechaPago, IDUsuario) VALUES (?, ?, ?, ?, ?)");
                $stmtPago->bind_param("iidsi", $clienteId, $prestamoId, $monto, $fecha, $usuarioId);
                $stmtPago->execute();
                $stmtPago->close();

                // Actualizar el monto restante y la factura solo si el monto de la cuota es mayor que cero
                $montoRestante -= $monto;
                $montoDeuda = max($montoRestante, 0);

                $stmtFactura = $conexion->prepare("INSERT INTO facturas (cliente_id, monto, fecha, monto_pagado, monto_deuda, id_prestamos) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtFactura->bind_param("idssii", $clienteId, $monto, $fecha, $monto, $montoDeuda, $prestamoId);
                $stmtFactura->execute();
                $stmtFactura->close();
            }
        }

        $stmtActualizarPrestamo = $conexion->prepare("UPDATE prestamos SET MontoAPagar = ? WHERE ID = ?");
        $stmtActualizarPrestamo->bind_param("di", $montoRestante, $prestamoId);
        $stmtActualizarPrestamo->execute();
        $stmtActualizarPrestamo->close();

        if ($montoRestante == 0) {
            $stmtActualizarEstadoPrestamo = $conexion->prepare("UPDATE prestamos SET Estado = 'pagado' WHERE ID = ?");
            $stmtActualizarEstadoPrestamo->bind_param("i", $prestamoId);
            $stmtActualizarEstadoPrestamo->execute();
            $stmtActualizarEstadoPrestamo->close();
        }

        $conexion->commit();
        $response['success'] = true;
        $response['message'] = "Pagos procesados correctamente.";
    } catch (Exception $e) {
        $conexion->rollback();
        $response['message'] = "Error al procesar los pagos: " . $e->getMessage();
    }
} else {
    $response['message'] = "Datos POST necesarios no recibidos.";
}

// Mostrar el mensaje como respuesta JSON
echo json_encode($response);

// Realizar la redirección después de mostrar el mensaje
if ($response['success']) {
    header("Location: /resources/views/admin/desatrasar/agregar_clientes.php");
    exit();
}
?>
