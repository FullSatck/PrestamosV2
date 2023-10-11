<?php
// Incluye tu archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Obtener la fecha actual en el formato de tu base de datos (por ejemplo, 'Y-m-d')
$fecha_actual = date('Y-m-d');

// Verificar si se ha proporcionado una zona válida desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];

    // Consulta SQL para seleccionar las filas de la tabla fechas_pago solo para la zona especificada y la fecha actual
    $sql = "SELECT * FROM fechas_pago WHERE Zona = '$nombreZona' AND FechaPago = '$fecha_actual'";
    $resultado = $conexion->query($sql);

    $fechas_pago = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $fechas_pago[] = $row;
        }
    }
} else {
    // Maneja el caso donde no se proporcionó una zona válida
    echo "Zona no especificada.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Fechas de Pago</title>
    <link rel="stylesheet" href="ruta.css">
</head>
<body>
    <h1>Lista de Fechas de Pago para la Zona: <?= $nombreZona ?></h1>
    <table id="lista-pagos">
        <thead>
            <tr>
                <th></th> <!-- Espacio para el arrastre -->
                <th>ID</th>
                <th>ID del Préstamo</th>
                <th>Fecha de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fechas_pago as $fecha) : ?>
                <tr>
                    <td class="drag-handle"></td> <!-- Espacio para el arrastre -->
                    <td><?= $fecha['ID'] ?></td>
                    <td><?= $fecha['IDPrestamo'] ?></td>
                    <td><?= $fecha['FechaPago'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            // Agrega el arrastre y suelte a las filas
            $("#lista-pagos tbody").sortable({
                handle: ".drag-handle", // El elemento de arrastre
                cursor: "move", // El cursor se convierte en una mano
                update: function(event, ui) {
                    // Aquí puedes manejar las actualizaciones necesarias en tu base de datos
                    // para reflejar el nuevo orden
                    var nuevaOrden = $(this).sortable("toArray");
                    // Envía la nueva orden al servidor con AJAX o como lo prefieras
                }
            });
            $("#lista-pagos tbody").disableSelection();
        });
    </script> 
</body>
</html>
