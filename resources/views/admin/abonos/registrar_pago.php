<?php
// Incluye el archivo de conexión a la base de datos
include '../../../../controllers/conexion.php';

// Verifica que se haya enviado el clienteId, monto y fechaPago
if (isset($_POST['clienteId']) && isset($_POST['monto']) && isset($_POST['fechaPago'])) {
    $clienteId = $_POST['clienteId'];
    $monto = $_POST['monto'];
    $fechaPago = $_POST['fechaPago'];

    // Inserta el pago en la tabla de historial_pagos
    $sql = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado) VALUES ($clienteId, '$fechaPago', $monto)";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Pago registrado con éxito";
    } else {
        echo "Error al registrar el pago: " . $conexion->error;
    }
} else {
    echo "Faltan parámetros para registrar el pago.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
