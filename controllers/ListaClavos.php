<?php
date_default_timezone_set('America/Bogota');
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$dbnombre = "prestamos";

$conexion = new mysqli($servidor, $usuario, $contrasena, $dbnombre);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener clientes que han pasado 20 días sin pagar
$diasSinPagar = 20;
$fechaLimite = date('Y-m-d', strtotime("-$diasSinPagar days"));
$query = "SELECT * FROM prestamos WHERE Estado = 'pendiente' AND FechaVencimiento <= '$fechaLimite'";
$result = $conexion->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Mover cliente a la tabla de clientes clavos
        $clienteID = $row['IDCliente'];
        $updateQuery = "UPDATE clientes SET EstadoID = 2 WHERE ID = $clienteID";
        $conexion->query($updateQuery);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Clavos</title>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/clavos.css">
</head>
<body>

    <div class="container">
        <h2>Clientes Clavos</h2>

        <!-- Agrega el formulario de búsqueda -->
        <form action="" method="GET">
            <label for="buscar">Buscar:</label>
            <input type="text" id="buscar" name="buscar">
            <button type="submit">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Deuda</th>
                    <th>Días sin pagar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los resultados en la tabla de clientes clavos
                $clavosQuery = "SELECT c.ID, c.Nombre, c.EstadoID, p.MontoAPagar, p.MontoCuota, p.FechaVencimiento
                                FROM clientes c
                                JOIN prestamos p ON c.ID = p.IDCliente
                                WHERE c.EstadoID = 2";

                // Modificar la consulta si se ha enviado una búsqueda
                if (isset($_GET['buscar'])) {
                    $busqueda = $_GET['buscar'];
                    $clavosQuery .= " AND (c.ID LIKE '%$busqueda%' OR c.Nombre LIKE '%$busqueda%')";
                }

                $clavosResult = $conexion->query($clavosQuery);

                if ($clavosResult) {
                    while ($clavoRow = $clavosResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $clavoRow['ID'] . "</td>";
                        echo "<td>" . $clavoRow['Nombre'] . "</td>";
                        echo "<td>$" . ($clavoRow['MontoAPagar'] ?: $clavoRow['MontoCuota']) . "</td>";

                        // Calcular días sin pagar
                        $fechaVencimiento = new DateTime($clavoRow['FechaVencimiento']);
                        $fechaActual = new DateTime();
                        $diasSinPagar = $fechaActual->diff($fechaVencimiento)->days;

                        echo "<td>Días sin pagar: $diasSinPagar</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
