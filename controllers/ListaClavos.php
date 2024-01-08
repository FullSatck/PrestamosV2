<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
require_once 'conexion.php'; 

// El usuario está autenticado, obtén el ID del usuario de la sesión
$usuario_id = $_SESSION["usuario_id"];

$sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();

// Preparar la consulta para obtener el rol del usuario
$stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
$stmt->bind_param("i", $usuario_id);

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();

$stmt->close();

// Verifica si el resultado es nulo o si el rol del usuario no es 'admin'
if (!$fila || $fila['Nombre'] !== 'admin') {
    header("Location: /ruta_a_pagina_de_error_o_inicio.php");
    exit();
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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Clavos</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        header {
            background-color: #007bff;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nombre-usuario {
            text-align: right;
        }

        .container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .botonn {
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        .spann {
            margin-left: 5px;
        }
    </style>
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
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Deuda</th>
            <th>Días sin pagar</th>
            <th>Perfil</th> <!-- Nueva columna "Perfil" -->
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

                // Nuevo campo "Perfil" como enlace a perfil_cliente.php
                echo "<td><a href='/controllers/perfil_cliente.php?id=" . $clavoRow['ID'] . "' class='btn btn-info'>Ver Perfil</a></td>";

                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

</div>

<!-- Enlace a Bootstrap JS y Popper.js (necesarios para algunas funciones de Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>