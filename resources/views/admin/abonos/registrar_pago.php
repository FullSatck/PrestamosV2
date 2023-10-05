<?php
// Incluye el archivo de conexión
include '../../../../controllers/conexion.php';

// Obtén los datos del pago enviados desde JavaScript
$clienteId = $_POST['clienteId'];
$monto = $_POST['monto'];
$fechaPago = $_POST['fechaPago'];

// Insertar un registro en la tabla cuotas_pagadas
$sqlInsert = "INSERT INTO cuotas_pagadas (IDCliente, MontoPagado, FechaPago) VALUES ($clienteId, $monto, '$fechaPago')";
if ($conn->query($sqlInsert) === TRUE) {
    // Actualizar el saldo de deuda del cliente en la tabla prestamos
    $sqlUpdate = "UPDATE prestamos SET SaldoDeuda = SaldoDeuda - $monto WHERE IDCliente = $clienteId";
    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Pago registrado con éxito";
    } else {
        echo "Error al actualizar el saldo de deuda";
    }
} else {
    echo "Error al registrar el pago";
}

// Cierra la conexión
$conn->close();
?>
