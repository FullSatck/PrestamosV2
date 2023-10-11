<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    // Incluye el archivo de conexión a la base de datos
    include '../../../../controllers/conexion.php';

    // Consulta SQL para obtener los datos
    $query = "SELECT c.Nombre, c.Apellido, fp.FechaPago, p.Monto, p.MontoCuota, c.IdentificacionCURP
              FROM clientes c
              JOIN prestamos p ON c.ID = p.IDCliente
              JOIN fechas_pago fp ON p.ID = fp.IDPrestamo
              WHERE fp.EstadoPago = 'pendiente'";

    // Ejecuta la consulta
    $result = $conexion->query($query);

    if ($result) {
        echo "<table>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Pago</th>
                    <th>Monto Pagado</th>
                    <th>Monto que Debe</th>
                    <th>Identificación CURP</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Nombre'] . "</td>";
            echo "<td>" . $row['Apellido'] . "</td>";
            echo "<td>" . $row['FechaPago'] . "</td>";
            echo "<td>" . $row['Monto'] . "</td>";
            echo "<td>" . $row['MontoCuota'] . "</td>";
            echo "<td>" . $row['IdentificacionCURP'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        $result->free();
    } else {
        echo "Error al ejecutar la consulta: " . $conexion->error;
    }

    $conexion->close();
    ?>
</body>
</html>
