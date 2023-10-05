<?php
include '../../../../controllers/conexion.php'; // Incluye el archivo de conexión

$cliente_id = $_POST['cliente_id'];
$fecha_pago = $_POST['fecha_pago'];
$monto_pagado = $_POST['monto_pagado'];

// Inserta el pago en la tabla historial_pagos
$query = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado) VALUES ('$cliente_id', '$fecha_pago', '$monto_pagado')";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo "Pago registrado exitosamente.";
    
    // Actualiza el monto que debe el cliente en la tabla prestamos
    $query = "UPDATE prestamos SET MontoAPagar = MontoAPagar - $monto_pagado WHERE IDCliente = '$cliente_id'";
    mysqli_query($conexion, $query);
} else {
    echo "Error al registrar el pago: " . mysqli_error($conexion);
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
