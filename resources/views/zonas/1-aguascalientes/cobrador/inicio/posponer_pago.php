<?php
include '../../../../controllers/conexion.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamoId'])) {
    $prestamoId = $_POST['prestamoId'];

    $sql = "UPDATE prestamos SET Pospuesto = 1 WHERE ID = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $prestamoId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Préstamo actualizado a No Pagado"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el préstamo"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta"]);
    }

    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos POST necesarios no recibidos."]);
}
?>
