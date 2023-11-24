<?php
// Incluir el archivo de conexión a la base de datos
include '../../../../../../controllers/conexion.php';

header('Content-Type: application/json');

// Verificar si se han enviado los datos necesarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamoId'], $_POST['montoPagado'])) {
    $prestamoId = $_POST['prestamoId'];
    $montoPagado = $_POST['montoPagado']; // Asegúrate de validar y limpiar esta entrada

    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        // Consulta SQL para obtener el monto de la cuota del préstamo y el ID del cliente
        $sqlCuota = "SELECT MontoCuota, IDCliente FROM prestamos WHERE ID = ? AND Estado = 'pendiente'";
        $stmtCuota = $conexion->prepare($sqlCuota);
        $stmtCuota->bind_param("i", $prestamoId);
        $stmtCuota->execute();
        $resultadoCuota = $stmtCuota->get_result();
        $stmtCuota->close();

        if ($filaCuota = $resultadoCuota->fetch_assoc()) {
            $clienteId = $filaCuota['IDCliente'];

            // Consulta SQL para obtener detalles del cliente
            $sqlCliente = "SELECT Nombre, Telefono FROM clientes WHERE ID = ?";
            $stmtCliente = $conexion->prepare($sqlCliente);
            $stmtCliente->bind_param("i", $clienteId);
            $stmtCliente->execute();
            $resultadoCliente = $stmtCliente->get_result();
            $cliente = $resultadoCliente->fetch_assoc();
            $stmtCliente->close();

            // Consulta SQL para registrar el pago en la tabla 'historial_pagos'
            $sqlRegistrarPago = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado, IDPrestamo) VALUES (?, CURDATE(), ?, ?)";
            $stmtPago = $conexion->prepare($sqlRegistrarPago);
            $stmtPago->bind_param("idi", $clienteId, $montoPagado, $prestamoId);
            $stmtPago->execute();
            $stmtPago->close();

            // Consulta SQL para actualizar el monto pendiente en la tabla 'prestamos'
            $sqlActualizarMonto = "UPDATE prestamos SET MontoAPagar = MontoAPagar - ? WHERE ID = ? AND Estado = 'pendiente'";
            $stmtActualizar = $conexion->prepare($sqlActualizarMonto);
            $stmtActualizar->bind_param("di", $montoPagado, $prestamoId);
            $stmtActualizar->execute();
            $stmtActualizar->close();

            // Verificar si el préstamo ha sido pagado completamente y actualizar el estado
            $sqlCheckCompleto = "SELECT MontoAPagar FROM prestamos WHERE ID = ?";
            $stmtCheck = $conexion->prepare($sqlCheckCompleto);
            $stmtCheck->bind_param("i", $prestamoId);
            $stmtCheck->execute();
            $resultadoCheck = $stmtCheck->get_result();
            $stmtCheck->close();

            if ($filaCheck = $resultadoCheck->fetch_assoc()) {
                if ($filaCheck['MontoAPagar'] <= 0) {
                    // Actualizar el estado del préstamo a 'pagado'
                    $sqlActualizarEstado = "UPDATE prestamos SET Estado = 'pagado' WHERE ID = ?";
                    $stmtEstado = $conexion->prepare($sqlActualizarEstado);
                    $stmtEstado->bind_param("i", $prestamoId);
                    $stmtEstado->execute();
                    $stmtEstado->close();
                }
            }

            // Si todo fue bien, confirmar la transacción
            $conexion->commit();
            echo json_encode([
                "success" => true, 
                "message" => "Pago procesado correctamente.",
                "clienteNombre" => $cliente['Nombre'],
                "clienteTelefono" => $cliente['Telefono']
            ]);
        } else {
            // Si no se encuentra el préstamo o ya está pagado
            throw new Exception("No se encontró el préstamo o ya está pagado.");
        }
    } catch (Exception $e) {
        // Si algo sale mal, revertir la transacción
        $conexion->rollback();
        echo json_encode(["success" => false, "message" => "Error al procesar el pago: " . $e->getMessage()]);
    }
} else {
    // Si no se reciben los datos necesarios por POST
    echo json_encode(["success" => false, "message" => "Datos POST necesarios no recibidos."]);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
