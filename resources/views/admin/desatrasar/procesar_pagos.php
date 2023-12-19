<?php
date_default_timezone_set('America/Bogota');
session_start(); // Iniciar la sesión para usar variables de sesión
include '../../../../controllers/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamo_id'], $_POST['monto_cuota'], $_POST['fecha_cuota'])) {
    $prestamoId = $_POST['prestamo_id'];
    $montosCuota = $_POST['monto_cuota'];
    $fechasCuota = $_POST['fecha_cuota'];

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

            if (!empty($monto)) { // Verificar si el monto no está vacío
                $stmtPago = $conexion->prepare("INSERT INTO historial_pagos (IDCliente, IDPrestamo, MontoPagado, FechaPago) VALUES (?, ?, ?, ?)");
                $stmtPago->bind_param("iids", $clienteId, $prestamoId, $monto, $fecha);
                $stmtPago->execute();
                $stmtPago->close();

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

        // Verificar si el monto restante es igual a 0 y actualizar el estado del préstamo
        if ($montoRestante == 0) {
            $stmtActualizarEstadoPrestamo = $conexion->prepare("UPDATE prestamos SET Estado = 'pagado' WHERE ID = ?");
            $stmtActualizarEstadoPrestamo->bind_param("i", $prestamoId);
            $stmtActualizarEstadoPrestamo->execute();
            $stmtActualizarEstadoPrestamo->close();
        }

        $conexion->commit();
        $_SESSION['mensaje'] = "Pagos procesados correctamente.";
        header("Location: /resources/views/admin/desatrasar/agregar_clientes.php");
        exit;
    } catch (Exception $e) {
        $conexion->rollback();
        $_SESSION['mensaje'] = "Error al procesar los pagos: " . $e->getMessage();
        header("Location: /ruta_a_tu_pagina_destino.php");
        exit;
    }
} else {
    $_SESSION['mensaje'] = "Datos POST necesarios no recibidos.";
    header("Location: /ruta_a_tu_pagina_destino.php");
    exit;
}
?>
