
<!-- PROCESAR TODOS LOS PAGOS DE ABONOS -->


<?php
session_start();
include("../../../../../controllers/conexion.php"); // Incluye tu archivo de conexión a la base de datos.

function obtenerSiguienteClienteId($conexion, $id_cliente_actual)
{
    $siguiente_cliente_id = 0;
    $sql_siguiente_cliente = "SELECT ID FROM clientes WHERE ID > ? ORDER BY ID ASC LIMIT 1";
    $stmt_siguiente_cliente = $conexion->prepare($sql_siguiente_cliente);
    $stmt_siguiente_cliente->bind_param("i", $id_cliente_actual);
    $stmt_siguiente_cliente->execute();
    $stmt_siguiente_cliente->bind_result($siguiente_cliente_id);
    $stmt_siguiente_cliente->fetch();
    $stmt_siguiente_cliente->close();
    return $siguiente_cliente_id;
}

function procesarPago($conexion, $id_cliente, $cuota_ingresada)
{
    // Obtén el MontoAPagar y el ID del préstamo.
    $montoAPagar = 0;
    $idPrestamo = 0;
    $sql_prestamo = "SELECT MontoAPagar, ID FROM prestamos WHERE IDCliente = ? AND Estado = 'pendiente' ORDER BY FechaInicio ASC LIMIT 1";
    $stmt_prestamo = $conexion->prepare($sql_prestamo);
    $stmt_prestamo->bind_param("i", $id_cliente);
    $stmt_prestamo->execute();
    $stmt_prestamo->bind_result($montoAPagar, $idPrestamo);
    if (!$stmt_prestamo->fetch()) {
        echo "Error al encontrar el préstamo pendiente.";
        return;
    }
    $stmt_prestamo->close();

    // Actualizar MontoAPagar en la tabla "prestamos".
    $monto_deuda = $montoAPagar - $cuota_ingresada;
    $sql_update_prestamo = "UPDATE prestamos SET MontoAPagar = ?, Pospuesto = 0, mas_tarde = 0 WHERE IDCliente = ?";
    $stmt_update_prestamo = $conexion->prepare($sql_update_prestamo);
    $stmt_update_prestamo->bind_param("di", $monto_deuda, $id_cliente);
    if (!$stmt_update_prestamo->execute()) {
        echo "Error al actualizar el préstamo.";
        return;
    }
    $stmt_update_prestamo->close();

    if ($monto_deuda == 0) {
        $sql_update_estado = "UPDATE prestamos SET Estado = 'pagado', EstadoP = 1 WHERE IDCliente = ?";
        $stmt_update_estado = $conexion->prepare($sql_update_estado);
        $stmt_update_estado->bind_param("i", $id_cliente);
        if (!$stmt_update_estado->execute()) {
            echo "Error al actualizar el estado del préstamo.";
            return;
        }
        $stmt_update_estado->close();
    }

    // Insertar en la tabla "historial_pagos" y "facturas".
    $fecha_pago = date('Y-m-d');
    $sql_insert_historial = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado, IDPrestamo, IDUsuario) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_historial = $conexion->prepare($sql_insert_historial);
    $stmt_insert_historial->bind_param("issii", $id_cliente, $fecha_pago, $cuota_ingresada, $idPrestamo, $_SESSION['usuario_id']);
    if (!$stmt_insert_historial->execute()) {
        echo "Error al insertar en historial de pagos.";
        return;
    }
    $stmt_insert_historial->close();

    $sql_insert_factura = "INSERT INTO facturas (cliente_id, monto, fecha, monto_pagado, monto_deuda, id_prestamos) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert_factura = $conexion->prepare($sql_insert_factura);
    $stmt_insert_factura->bind_param("idsssi", $id_cliente, $montoAPagar, $fecha_pago, $cuota_ingresada, $monto_deuda, $idPrestamo);
    if (!$stmt_insert_factura->execute()) {
        echo "Error al insertar en facturas.";
        return;
    }
    $stmt_insert_factura->close();
}


function procesarNoPagoOMasTarde($conexion, $id_cliente, $accion) {
    // Primero, verifica si alguna de las acciones ya se ha realizado.
    $sql_verificar = "SELECT Pospuesto, mas_tarde FROM prestamos WHERE IDCliente = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("i", $id_cliente);
    $stmt_verificar->execute();
    $stmt_verificar->store_result();

    if ($stmt_verificar->num_rows == 0) {
        echo "<script>alert('No se encontró el cliente.');</script>";
        return;
    }

    $pospuesto = $mas_tarde = 0;
    $stmt_verificar->bind_result($pospuesto, $mas_tarde);
    $stmt_verificar->fetch();
    $stmt_verificar->close();

    if ($pospuesto == 1 || $mas_tarde == 1) {
        echo "<script>alert('Ya se ha realizado una acción de \"No pago\" o \"Más tarde\" anteriormente.');</script>";
        return;
    }

    // Si ninguna acción se ha realizado, procede a actualizar el campo correspondiente.
    $campo_actualizar = $accion === 'No pago' ? 'Pospuesto' : 'mas_tarde';
    $sql_update = "UPDATE prestamos SET $campo_actualizar = 1 WHERE IDCliente = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("i", $id_cliente);
    if (!$stmt_update->execute()) {
        echo "Error al actualizar el campo '$campo_actualizar': " . $stmt_update->error;
        return;
    }
    $stmt_update->close();
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'], $_POST['id_cliente'])) {
    $id_cliente = $_POST['id_cliente'];
    $accion = $_POST['action'];

    switch ($accion) {
        case 'Pagar':
            $cuota_ingresada = $_POST['cuota'];
            procesarPago($conexion, $id_cliente, $cuota_ingresada);
            break;

        case 'No pago':
        case 'Mas tarde':
            procesarNoPagoOMasTarde($conexion, $id_cliente, $accion);
            break;
    }

    $siguiente_cliente_id = obtenerSiguienteClienteId($conexion, $id_cliente);
    if ($siguiente_cliente_id !== null) {
        header("Location: perfil_abonos.php?id=$siguiente_cliente_id");
        exit();
    } else {
        echo '<script>alert("No hay más clientes");</script>';
    }
}

ob_end_flush();
