<?php
// Incluye tu archivo de conexión a la base de datos
include '../../../../controllers/conexion.php';

// Obtén el ID del cliente desde la solicitud GET
$clienteId = $_GET["clienteId"];

// Prepara y ejecuta la consulta para obtener datos del cliente y préstamo
$sql = "SELECT c.ID, c.Nombre, c.Apellido, c.Domicilio, c.Telefono, c.IdentificacionCURP, c.ZonaAsignada,
               p.ID AS IDPrestamo, p.TasaInteres, p.FechaInicio, p.FechaVencimiento, p.Zona, p.MontoAPagar, p.Cuota
        FROM clientes c
        LEFT JOIN prestamos p ON c.ID = p.IDCliente
        WHERE c.ID = $clienteId";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Obtiene los datos como un arreglo asociativo
    $fila = $resultado->fetch_assoc();

    // Devuelve los datos en formato JSON
    echo json_encode($fila);
} else {
    echo "No se encontraron datos del cliente y préstamo.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
