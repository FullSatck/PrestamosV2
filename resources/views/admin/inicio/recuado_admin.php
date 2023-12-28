<?php
require_once '../../../../controllers/conexion.php';

// Función para calcular el total de los pagos
function calcularTotalPagos($conexion)
{
    $sql = "SELECT SUM(MontoPagado) AS total FROM historial_pagos";
    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Función para filtrar pagos por fecha
function filtrarPagosPorFecha($conexion, $fechaInicio, $fechaFin)
{
    $sql = "SELECT * FROM historial_pagos WHERE FechaPago BETWEEN '$fechaInicio' AND '$fechaFin'";
    $result = $conexion->query($sql);
    return $result;
}

// Obtener la fecha seleccionada (si se proporciona)
$fechaInicio = isset($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"] : '';
$fechaFin = isset($_GET["fecha_fin"]) ? $_GET["fecha_fin"] : '';

// Filtrar pagos por fechas si se proporcionan
if (!empty($fechaInicio) && !empty($fechaFin)) {
    $result = filtrarPagosPorFecha($conexion, $fechaInicio, $fechaFin);
} else {
    // Obtener todos los pagos si no se proporcionan fechas
    $result = $conexion->query("SELECT * FROM historial_pagos");
}

// Calcular el total de pagos
$totalPagos = calcularTotalPagos($conexion);

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Historial de Pagos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#fecha_inicio, #fecha_fin').change(function() {
                actualizarTotalPagos();
            });

            function actualizarTotalPagos() {
                var fechaInicio = $('#fecha_inicio').val();
                var fechaFin = $('#fecha_fin').val();
                $.ajax({
                    type: 'GET',
                    url: 'actualizar_total.php',
                    data: {
                        fecha_inicio: fechaInicio,
                        fecha_fin: fechaFin
                    },
                    success: function(data) {
                        $('#totalPagos').html(data);
                    }
                });
            }

            // Llamar a la función inicialmente para mostrar el total en la carga inicial
            actualizarTotalPagos();
        });
    </script>
</head>

<body>
    <h1>Historial de Pagos</h1>

    <!-- Formulario para filtrar pagos por fecha -->
    <h2>Filtrar Pagos por Fecha</h2>
    <form method="GET" action="recuado_admin.php">
        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">

        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fechaFin; ?>">

        <input type="submit" value="Filtrar Pagos">
    </form>

    <!-- Lista de pagos -->
    <h2>Lista de Pagos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Cliente</th>
            <th>Fecha de Pago</th>
            <th>Monto Pagado</th>
            <th>ID Prestamo</th>
           
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["ID"]; ?></td>
                <td><?php echo $row["IDCliente"]; ?></td>
                <td><?php echo $row["FechaPago"]; ?></td>
                <td><?php echo $row["MontoPagado"]; ?></td>
                <td><?php echo $row["IDPrestamo"]; ?></td>
                
            </tr>
        <?php } ?>
    </table>

    <!-- Total de pagos -->
    <h2>Total de Pagos</h2>
    <p id="totalPagos">Total: $<?php echo number_format($totalPagos, 2); ?></p>
</body>

</html>