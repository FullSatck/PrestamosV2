<?php
// Incluye el archivo de conexión
include '../../../../controllers/conexion.php';

// Consulta SQL para obtener los datos del cliente y préstamo
$clienteId = $_GET['clienteId']; // Asegúrate de pasar el ID del cliente desde tu HTML
$sql = "SELECT c.Nombre, c.Domicilio, c.IdentificacionCURP, p.Plazo, p.Cuota FROM clientes c INNER JOIN prestamos p ON c.ID = p.IDCliente WHERE c.ID = $clienteId";

$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los datos en formato JSON para que JavaScript los maneje
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo "No se encontraron datos.";
}

// Cierra la conexión
$conexion->close();
?>
