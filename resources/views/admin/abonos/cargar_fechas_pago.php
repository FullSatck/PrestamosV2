<?php
// Incluye tu archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Obtener la fecha actual en el formato de tu base de datos (por ejemplo, 'Y-m-d')
$fecha_actual = date('Y-m-d');

// Verificar si se ha proporcionado una zona válida desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];

    // Manejar la solicitud POST para guardar el nuevo orden
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nuevoOrden"])) {
        $nuevoOrden = $_POST["nuevoOrden"];
        $guardarOrdenSQL = "UPDATE fechas_pago SET Orden = ? WHERE Zona = ?";
        $stmt = $conexion->prepare($guardarOrdenSQL);

        if ($stmt) {
            $stmt->bind_param("ss", $nuevoOrden, $nombreZona);
            if ($stmt->execute()) {
                // Éxito al guardar el nuevo orden
                echo "Nuevo orden actualizado con éxito.";
            } else {
                echo "Error al actualizar el nuevo orden: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta para guardar el nuevo orden: " . $conexion->error;
        }
    }

    // Consulta SQL para seleccionar las filas de la tabla fechas_pago solo para la zona especificada y la fecha actual
    $sql = "SELECT * FROM fechas_pago WHERE Zona = '$nombreZona' AND FechaPago = '$fecha_actual' ORDER BY Orden";
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

    <button id="guardarCambios">Guardar Cambios</button>

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

            // Manejar el clic en el botón "Guardar Cambios"
            $("#guardarCambios").on("click", function() {
                // Obtener el nuevo orden de las filas y enviarlo al servidor
                var nuevoOrden = $("#lista-pagos tbody").sortable("toArray");
                $.ajax({
                    url: 'cargar_fechas_pago.php?zona=<?= $nombreZona; ?>',
                    method: 'POST',
                    data: { nuevoOrden: nuevoOrden },
                    success: function(response) {
                        // Manejar la respuesta del servidor (éxito o error)
                        alert(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
