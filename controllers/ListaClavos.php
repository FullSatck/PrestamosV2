<?php
// Configuración de la zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$dbnombre = "prestamos";

// Creación de la conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $dbnombre);

// Verificación de la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener clientes que han pasado ciertos días hábiles sin pagar una cuota
$diasHabilesSinPagar = 15;
$fechaLimite = date('Y-m-d', strtotime("-$diasHabilesSinPagar weekdays"));
$query = "SELECT p.IDCliente, p.ID, p.MontoCuota, MIN(p.FechaInicio) AS FechaInicio
          FROM prestamos p
          WHERE p.Estado = 'pendiente' AND p.FechaVencimiento <= '$fechaLimite'
          GROUP BY p.ID";
$result = $conexion->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Calcular la fecha límite para la última cuota
        $fechaInicio = isset($row['FechaInicio']) ? $row['FechaInicio'] : date('Y-m-d');
        $fechaLimiteCuota = date('Y-m-d', strtotime("+10 weekdays", strtotime($fechaInicio)));

        // Verificar si ha pasado el plazo establecido desde la fecha de vencimiento
        if ($fechaLimiteCuota <= $fechaLimite) {
            // Mover cliente a la tabla de clientes clavos
            $clienteID = $row['IDCliente'];
            $updateQuery = "UPDATE clientes SET EstadoID = 2 WHERE ID = $clienteID";
            $conexion->query($updateQuery);

            // Actualizar información en la tabla prestamos
            $prestamoID = $row['ID'];
            $updatePrestamoQuery = "UPDATE prestamos SET CuotasVencidas = CuotasVencidas + 1 WHERE ID = $prestamoID";
            $conexion->query($updatePrestamoQuery);
        }
    }
}

// Verificar y actualizar el estado de los clientes en la lista de clavos
$clavosQuery = "SELECT p.ID AS PrestamoID, p.IDCliente
                FROM prestamos p
                WHERE p.Estado = 'clavo'"; // Asumiendo que 'clavo' es un estado en la tabla prestamos

$clavosResult = $conexion->query($clavosQuery);

if ($clavosResult) {
    while ($clavoRow = $clavosResult->fetch_assoc()) {
        $prestamoID = $clavoRow['PrestamoID'];
        $clienteID = $clavoRow['IDCliente'];

        // Verificar si el cliente ha realizado el pago de la cuota pendiente
        $pagoQuery = "SELECT SUM(MontoPagado) AS TotalPagado
                      FROM historial_pagos
                      WHERE IDPrestamo = $prestamoID AND FechaPago >= '$fechaLimite'";
        $pagoResult = $conexion->query($pagoQuery);
        $pagoRow = $pagoResult->fetch_assoc();

        // Obtener el monto total de la cuota pendiente
        $montoCuotaQuery = "SELECT MontoCuota FROM prestamos WHERE ID = $prestamoID";
        $montoCuotaResult = $conexion->query($montoCuotaQuery);
        $montoCuotaRow = $montoCuotaResult->fetch_assoc();
        $montoCuota = $montoCuotaRow['MontoCuota'];

        if ($pagoRow['TotalPagado'] >= $montoCuota) {
            // El cliente ha pagado, actualizar su estado para sacarlo de la lista de clavos
            $updatePrestamoQuery = "UPDATE prestamos SET Estado = 'activo' WHERE ID = $prestamoID"; // Asumiendo que 'activo' es el estado normal
            $conexion->query($updatePrestamoQuery);
        }
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

<header>
    <a href="/resources/views/admin/inicio/inicio.php" class="botonn">
        <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
        <span class="spann">Volver al Inicio</span>
    </a>

    <div class="nombre-usuario">
        <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Administrator<span>";
        }
        ?>
    </div>
</header>

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
                            WHERE c.EstadoID = 2 AND p.FechaVencimiento <= '$fechaLimite'";

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
