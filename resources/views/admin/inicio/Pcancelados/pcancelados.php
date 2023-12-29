<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos Pagados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Prestamos Pagados</h1>

        <?php
        // Incluir el archivo de conexión a la base de datos
        require_once '../../../../../controllers/conexion.php';

        // Consulta SQL para seleccionar préstamos pagados con datos del cliente
        $sql = "SELECT p.*, c.Nombre AS NombreCliente, c.IdentificacionCURP
                FROM prestamos AS p
                INNER JOIN clientes AS c ON p.IDCliente = c.ID
                WHERE p.Estado = 'pagado'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered mt-3'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Cliente</th>
                            <th>CURP</th>
                            <th>Monto</th>
                            <th>Tasa de Interés</th>
                            <th>Plazo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Vencimiento</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["NombreCliente"] . "</td>
                        <td>" . $row["IdentificacionCURP"] . "</td>
                        <td>" . $row["Monto"] . "</td>
                        <td>" . $row["TasaInteres"] . "</td>
                        <td>" . $row["Plazo"] . "</td>
                        <td>" . $row["FechaInicio"] . "</td>
                        <td>" . $row["FechaVencimiento"] . "</td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='mt-3'>No se encontraron préstamos pagados.</p>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>

    </div>

    <!-- Agrega el enlace al archivo JavaScript de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
