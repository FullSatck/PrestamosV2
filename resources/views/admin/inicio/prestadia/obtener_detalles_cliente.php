<?php
// Incluir el archivo de conexión a la base de datos
include '../../../../../controllers/conexion.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestamoId'])) {
    $prestamoId = $_POST['prestamoId'];

    // Consulta SQL para obtener los detalles adicionales del cliente según el ID del préstamo
    $sqlClienteDetalles = "SELECT clientes.IdentificacionCURP AS CURP, clientes.Domicilio AS Direccion, prestamos.Monto AS MontoDeuda 
                           FROM clientes 
                           JOIN prestamos ON clientes.ID = prestamos.IDCliente 
                           WHERE prestamos.ID = ?";
    
    $stmtClienteDetalles = $conexion->prepare($sqlClienteDetalles);
    $stmtClienteDetalles->bind_param("i", $prestamoId);
    $stmtClienteDetalles->execute();
    $resultadoClienteDetalles = $stmtClienteDetalles->get_result();
    $filaClienteDetalles = $resultadoClienteDetalles->fetch_assoc();
    $stmtClienteDetalles->close();

    if ($filaClienteDetalles) {
        // Obtener los detalles del cliente
        $clienteCURP = $filaClienteDetalles['CURP'];
        $clienteDireccion = $filaClienteDetalles['Direccion'];
        $montoDeuda = $filaClienteDetalles['MontoDeuda'];

        // Devolver los detalles del cliente como respuesta JSON
        echo json_encode([
            "success" => true,
            "clienteCURP" => $clienteCURP,
            "clienteDireccion" => $clienteDireccion,
            "montoDeuda" => $montoDeuda
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No se encontraron detalles para el cliente."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Datos POST necesarios no recibidos."
    ]);
}

$conexion->close();
?>
