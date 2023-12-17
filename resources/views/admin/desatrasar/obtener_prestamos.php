<?php
include '../../../../controllers/conexion.php';
$cliente_id = $_GET['cliente_id'] ?? 0; // Asegúrate de que haya un valor predeterminado.

$query = "SELECT ID, MontoAPagar FROM prestamos WHERE IDCliente = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error en la consulta: " . $conexion->error;
    exit;
}

$options = "<option value=''>Seleccione un Préstamo</option>";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['ID'] . "'>Préstamo ID: " . $row['ID'] . " - MontoAPagar: " . $row['MontoAPagar'] . "</option>";
}

echo $options;
?>
