<?php
require('../../../../public/assets/fpdf/fpdf.php'); // Asegúrate de que esté incluido el archivo FPDF

if (isset($_GET['clienteId']) && isset($_GET['monto']) && isset($_GET['nombre']) && isset($_GET['direccion']) && isset($_GET['identificacion']) && isset($_GET['montoPagado']) && isset($_GET['montoDeuda']) && isset($_GET['cuota'])) {
    // Recoge los parámetros de la URL
    $clienteId = $_GET['clienteId'];
    $monto = $_GET['monto'];
    $nombre = $_GET['nombre'];
    $direccion = $_GET['direccion'];
    $identificacion = $_GET['identificacion'];
   
   
   

    // Crear un nuevo objeto PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Configurar el formato de la fuente y tamaño
    $pdf->SetFont('Arial', '', 12);

    // Agregar contenido a la factura
    $pdf->Cell(0, 10, 'Factura para Cliente ID: ' . $clienteId, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Nombre: ' . $nombre, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Dirección: ' . $direccion, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Identificación: ' . $identificacion, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Monto Pagado: $' . $montoPagado, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Monto que Debe: $' . $montoDeuda, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Cuota: $' . $cuota, 0, 1, 'C');
    $pdf->Cell(0, 10, 'Monto Total: $' . $monto, 0, 1, 'C');

    // Generar el archivo PDF
    $pdf->Output();
} else {
    // Manejar el caso en que no se proporcionen todos los parámetros
    echo 'Parámetros incorrectos.';
}
?>
