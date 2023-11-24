<?php
// Incluir el archivo de conexión a la base de datos
include '../../../../controllers/conexion.php';

header('Content-Type: application/json');

// Verificar si se han enviado los datos necesarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamoId'], $_POST['montoPagado'])) {
    $prestamoId = $_POST['prestamoId'];
    $montoPagado = $_POST['montoPagado']; // Asegúrate de validar y limpiar esta entrada

    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        // Consulta SQL para obtener el monto pendiente y el monto total del préstamo
        $sqlPrestamo = "SELECT MontoAPagar, IDCliente, MontoTotal FROM prestamos WHERE ID = ? AND Estado = 'pendiente'";
        $stmtPrestamo = $conexion->prepare($sqlPrestamo);
        if (!$stmtPrestamo) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }
        $stmtPrestamo->bind_param("i", $prestamoId);
        $stmtPrestamo->execute();
        $resultadoPrestamo = $stmtPrestamo->get_result();
        $filaPrestamo = $resultadoPrestamo->fetch_assoc();
        $stmtPrestamo->close();

        if (!$filaPrestamo) {
            throw new Exception("No se encontró el préstamo o ya está pagado.");
        }

        $clienteId = $filaPrestamo['IDCliente'];
        $montoTotalAPagar = $filaPrestamo['MontoAPagar'];
        $montoTotalPrestamo = $filaPrestamo['MontoTotal'];

        // Obtener el nombre y el número de teléfono del cliente
        $sqlCliente = "SELECT Nombre, Telefono FROM clientes WHERE ID = ?";
        $stmtCliente = $conexion->prepare($sqlCliente);
        if (!$stmtCliente) {
            throw new Exception("Error al preparar la consulta de cliente: " . $conexion->error);
        }
        $stmtCliente->bind_param("i", $clienteId);
        $stmtCliente->execute();
        $resultadoCliente = $stmtCliente->get_result();
        $filaCliente = $resultadoCliente->fetch_assoc();
        $stmtCliente->close();

        if (!$filaCliente) {
            throw new Exception("No se encontró información del cliente.");
        }

        $clienteNombre = $filaCliente['Nombre'];
        $clienteTelefono = $filaCliente['Telefono'];

        // Registrar el pago en la tabla 'historial_pagos'
        $sqlRegistrarPago = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado, IDPrestamo) VALUES (?, CURDATE(), ?, ?)";
        $stmtPago = $conexion->prepare($sqlRegistrarPago);
        if (!$stmtPago) {
            throw new Exception("Error al preparar la consulta de registro de pago: " . $conexion->error);
        }
        $stmtPago->bind_param("idi", $clienteId, $montoPagado, $prestamoId);
        $stmtPago->execute();
        $stmtPago->close();

        // Descontar el monto pagado del total a pagar
        $montoRestante = $montoTotalAPagar - $montoPagado;

        // Preparar la consulta para actualizar el monto total a pagar y, si es necesario, el estado del préstamo
        if ($montoRestante <= 0) {
            // Si el monto restante es cero o menor, el préstamo se considera pagado
            $sqlActualizarPrestamo = "UPDATE prestamos SET MontoAPagar = 0, Estado = 'pagado' WHERE ID = ?";
            $stmtActualizarPrestamo = $conexion->prepare($sqlActualizarPrestamo);
            if (!$stmtActualizarPrestamo) {
                throw new Exception("Error al preparar la consulta de actualización de préstamo: " . $conexion->error);
            }
            $stmtActualizarPrestamo->bind_param("i", $prestamoId);
        } else {
            // Si aún queda monto por pagar, solo actualizamos el monto
            $sqlActualizarPrestamo = "UPDATE prestamos SET MontoAPagar = ? WHERE ID = ?";
            $stmtActualizarPrestamo = $conexion->prepare($sqlActualizarPrestamo);
            if (!$stmtActualizarPrestamo) {
                throw new Exception("Error al preparar la consulta de actualización de préstamo: " . $conexion->error);
            }
            $stmtActualizarPrestamo->bind_param("di", $montoRestante, $prestamoId);
        }
        $stmtActualizarPrestamo->execute();
        $stmtActualizarPrestamo->close();

        // Confirmar la transacción
        $conexion->commit();
        echo json_encode([
            "success" => true, 
            "message" => "Pago procesado correctamente.", 
            "clienteNombre" => $clienteNombre, 
            "clienteTelefono" => $clienteTelefono,
            "montoPagado" => $montoPagado
        ]);
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(["success" => false, "message" => "Error al procesar el pago: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos POST necesarios no recibidos."]);
}

$conexion->close();
?>
