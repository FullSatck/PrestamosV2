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
        // Consulta SQL para obtener el monto pendiente del préstamo
        $sqlPrestamo = "SELECT MontoAPagar, IDCliente FROM prestamos WHERE ID = ? AND Estado = 'pendiente'";
        $stmtPrestamo = $conexion->prepare($sqlPrestamo);
        $stmtPrestamo->bind_param("i", $prestamoId);
        $stmtPrestamo->execute();
        $resultadoPrestamo = $stmtPrestamo->get_result();
        $filaPrestamo = $resultadoPrestamo->fetch_assoc();
        $stmtPrestamo->close();

        if ($filaPrestamo) {
            $clienteId = $filaPrestamo['IDCliente'];

            // Obtener el nombre y el número de teléfono del cliente
            $sqlCliente = "SELECT Nombre, Telefono FROM clientes WHERE ID = ?";
            $stmtCliente = $conexion->prepare($sqlCliente);
            $stmtCliente->bind_param("i", $clienteId);
            $stmtCliente->execute();
            $resultadoCliente = $stmtCliente->get_result();
            $filaCliente = $resultadoCliente->fetch_assoc();
            $clienteNombre = $filaCliente['Nombre'];
            $clienteTelefono = $filaCliente['Telefono'];
            $stmtCliente->close();

            // Registrar el pago en la tabla 'historial_pagos'
            $sqlRegistrarPago = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado, IDPrestamo) VALUES (?, CURDATE(), ?, ?)";
            $stmtPago = $conexion->prepare($sqlRegistrarPago);
            $stmtPago->bind_param("idi", $clienteId, $montoPagado, $prestamoId);
            $stmtPago->execute();
            $stmtPago->close();

            // Actualizar el estado del préstamo a 'pagado' inmediatamente después de recibir un pago
            $sqlActualizarEstado = "UPDATE prestamos SET Estado = 'pagado' WHERE ID = ?";
            $stmtEstado = $conexion->prepare($sqlActualizarEstado);
            $stmtEstado->bind_param("i", $prestamoId);
            $stmtEstado->execute();
            $stmtEstado->close();

            // Confirmar la transacción
            $conexion->commit();
            echo json_encode([
                "success" => true, 
                "message" => "Pago procesado correctamente.", 
                "clienteNombre" => $clienteNombre, 
                "clienteTelefono" => $clienteTelefono,
                "montoPagado" => $montoPagado
            ]);
        } else {
            throw new Exception("No se encontró el préstamo o ya está pagado.");
        }
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(["success" => false, "message" => "Error al procesar el pago: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos POST necesarios no recibidos."]);
}

$conexion->close();
?>
