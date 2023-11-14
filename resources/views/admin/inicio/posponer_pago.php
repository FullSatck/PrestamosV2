<?php
require '../../../../controllers/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamoId'])) {
    $prestamoId = $_POST['prestamoId'];

    $sql = "UPDATE prestamos SET Estado = '1' WHERE ID = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $prestamoId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Préstamo pospuesto con éxito."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el estado del préstamo."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error al preparar la consulta."]);
    }

    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos POST necesarios no recibidos."]);
}
?>
