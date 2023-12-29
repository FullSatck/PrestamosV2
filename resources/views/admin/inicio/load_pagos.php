<?php
require_once '../../../../controllers/conexion.php';

if(isset($_GET["fechaDesde"]) && isset($_GET["fechaHasta"])) {
    // Si se proporcionan fechas, aplicar filtro
    $fechaDesde = $_GET["fechaDesde"];
    $fechaHasta = $_GET["fechaHasta"];

    // Consulta SQL para cargar la lista de pagos filtrada por fechas
    $sql = "SELECT hp.*, CONCAT(c.Nombre, ' ', c.Apellido) AS NombreCompletoCliente, c.IdentificacionCURP AS CURPCliente, u.Nombre AS NombreUsuario
            FROM historial_pagos hp
            LEFT JOIN clientes c ON hp.IDCliente = c.ID
            LEFT JOIN usuarios u ON hp.IDUsuario = u.ID
            WHERE hp.FechaPago BETWEEN ? AND ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $fechaDesde, $fechaHasta);
    
    // Ejecutar la consulta con los filtros de fecha
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si no se proporcionan fechas, cargar todos los pagos
    $sql = "SELECT hp.*, CONCAT(c.Nombre, ' ', c.Apellido) AS NombreCompletoCliente, c.IdentificacionCURP AS CURPCliente, u.Nombre AS NombreUsuario
            FROM historial_pagos hp
            LEFT JOIN clientes c ON hp.IDCliente = c.ID
            LEFT JOIN usuarios u ON hp.IDUsuario = u.ID";
    $stmtSinFiltro = $conexion->prepare($sql);
    
    // Ejecutar la consulta sin filtros de fecha
    $stmtSinFiltro->execute();
    $result = $stmtSinFiltro->get_result();
}

$totalPrestamos = 0; // Variable para almacenar el total de los préstamos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Suma el monto del pago al total de préstamos
        $totalPrestamos += $row["MontoPagado"];
    }

    // Imprime la fila que contiene el total
    echo "<tr><td colspan='7'></td><td>Total:</td><td>$totalPrestamos</td><td></td></tr>";

    // Volver a obtener los resultados para imprimir las filas de pagos
    if(isset($_GET["fechaDesde"]) && isset($_GET["fechaHasta"])) {
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $stmtSinFiltro->execute();
        $result = $stmtSinFiltro->get_result();
    }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // echo "<td>" . $row["ID"] . "</td>";
        echo "<td>" . $row["NombreCompletoCliente"] . "</td>"; // Mostrar nombre completo del cliente
        echo "<td>" . $row["CURPCliente"] . "</td>"; // Mostrar CURP del cliente
        echo "<td>" . $row["FechaPago"] . "</td>";
        echo "<td>" . $row["MontoPagado"] . "</td>";
        // echo "<td>" . $row["IDPrestamo"] . "</td>";
        echo "<td>" . $row["NombreUsuario"] . "</td>"; // Mostrar nombre del usuario
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No se encontraron pagos";
    if(isset($_GET["fechaDesde"]) && isset($_GET["fechaHasta"])) {
        echo " en el rango de fechas seleccionado.";
    } else {
        echo ".";
    }
    echo "</td></tr>";
}

$conexion->close();
?>
