<?php
// Verificar si se pasaron los parámetros esperados en la URL
if (isset($_GET['clienteId']) && isset($_GET['monto'])) {
    $clienteId = $_GET['clienteId'];
    $monto = $_GET['monto'];

    // Aquí podrías agregar lógica adicional para obtener información adicional del cliente, por ejemplo, desde una base de datos

    // Generar la factura
    $fechaFactura = date('Y-m-d');
    $nombreCliente = "Cliente"; // Reemplaza esto con el nombre real del cliente
    $direccionCliente = "Dirección del Cliente"; // Reemplaza esto con la dirección real del cliente

    // Generar el contenido de la factura
    $contenidoFactura = "Fecha: $fechaFactura\n";
    $contenidoFactura .= "Cliente: $nombreCliente\n";
    $contenidoFactura .= "Dirección: $direccionCliente\n";
    $contenidoFactura .= "Monto: $monto\n";

    // Descargar la factura como un archivo PDF
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=Factura_Cliente$clienteId.pdf");
    echo $contenidoFactura; // En un sistema real, aquí se generarían archivos PDF más elaborados

    // Terminar el script
    exit();
} else {
    // Redirigir o mostrar un mensaje de error si no se proporcionaron los parámetros esperados
    echo "Error: Parámetros incorrectos.";
}
?>
