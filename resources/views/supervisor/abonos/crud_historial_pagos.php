<?php
// Incluye el archivo de conexión a la base de datos
include '../../../../controllers/conexion.php';

// Obtén el ID del cliente actual (puedes obtenerlo de alguna manera, por ejemplo, de la URL)
$clienteId = $_GET['clienteId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Historial de Pagos</title>
</head>
<body>
    <h1>Historial de Pagos</h1>

    <!-- Formulario para agregar un nuevo pago -->
    <h2>Agregar Pago</h2>
    <form action="registrar_pago.php" method="post">
        <input type="hidden" name="clienteId" value="<?php echo $clienteId; ?>">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>
        <label for="monto">Monto:</label>
        <input type="text" name="monto" required>
        <button type="submit">Registrar Pago</button>
    </form>

    <!-- Listado de pagos -->
    <h2>Historial de Pagos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Monto Pagado</th>
            <th>Acciones</th>
        </tr>
        <?php
        // PHP para consultar y mostrar el historial de pagos
        $sql = "SELECT * FROM historial_pagos WHERE IDCliente = $clienteId";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['FechaPago'] . "</td>";
                echo "<td>" . $row['MontoPagado'] . "</td>";
                echo "<td><a href='editar_pago.php?id=" . $row['ID'] . "'>Editar</a> | <a href='eliminar_pago.php?id=" . $row['ID'] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron pagos.</td></tr>";
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
    </table>
</body>
</html>
