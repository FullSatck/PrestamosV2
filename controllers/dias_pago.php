<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/dias_pago.css">
    <title>Fechas de Pago</title>
</head>

<body>

    <main>

        <?php
        // Incluir el archivo de conexión a la base de datos
        require_once("conexion.php");

        // Obtener el ID del préstamo desde el parámetro GET
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $idPrestamo = $_GET['id'];

            // Consulta SQL para obtener los detalles del préstamo con el ID dado
            $sql = "SELECT FechaInicio, FrecuenciaPago, Plazo, Cuota FROM prestamos WHERE ID = $idPrestamo";
            $result = $conexion->query($sql);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $fechaInicio = new DateTime($row["FechaInicio"]);
                $frecuenciaPago = $row["FrecuenciaPago"];
                $plazo = $row["Plazo"];
                $cuota = $row["Cuota"];

                // Calcular las fechas de pago
                $fechasPago = calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo);

                // Mostrar las fechas de pago en una tabla
                echo "<div class='container'>";
                echo "<h1>Fechas de Pago</h1>"; 
                echo "<table>";
                echo "<tr><th>Frecuencia</th><th>Fecha</th><th>Cuota</th><th>Frecuencia de Pago</th><th>Estado del Pago</th></tr>";
                $numeroFecha = 1;
                foreach ($fechasPago as $fecha) {
                    $frecuencia = obtenerFrecuencia($frecuenciaPago, $numeroFecha);
                    $fechaFormato = $fecha->format("Y-m-d");

                    // Preparar la consulta SQL para verificar si la cuota ha sido pagada
                    $stmt = $conexion->prepare("SELECT FechaPago, MontoPagado FROM historial_pagos WHERE FechaPago = ? AND MontoPagado = ? AND IDCliente = ?");
                    $stmt->bind_param("sdi", $fechaFormato, $cuota, $_SESSION["usuario_id"]);
                    $stmt->execute();
                    $resultPago = $stmt->get_result();

                    $estadoPago = "No Pagado"; // Estado por defecto
                    if ($resultPago->num_rows > 0) {
                        $estadoPago = "Pagado";
                    }

                    echo "<tr><td>$frecuencia</td><td>$fechaFormato</td><td>$cuota</td><td>$frecuenciaPago</td><td>$estadoPago</td></tr>";
                    $numeroFecha++;
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "ID de préstamo no válido.";
            }
        } else {
            echo "ID de préstamo no proporcionado.";
        }

        // Función para calcular las fechas de pago
        function calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo)
        {
            $fechasPago = array();

            for ($i = 0; $i < $plazo; $i++) {
                $fechasPago[] = clone $fechaInicio;

                if ($frecuenciaPago === "diario") {
                    $fechaInicio->modify("+1 day");
                } elseif ($frecuenciaPago === "semanal") {
                    $fechaInicio->modify("+1 week");
                } elseif ($frecuenciaPago === "quincenal") {
                    $fechaInicio->modify("+2 weeks");
                } elseif ($frecuenciaPago === "mensual") {
                    $fechaInicio->modify("+1 month");
                }
            }

            return $fechasPago;
        }

        // Función para obtener la descripción de la frecuencia
        function obtenerFrecuencia($frecuenciaPago, $numeroFecha)
        {
            switch ($frecuenciaPago) {
                case "diario":
                    return "Día $numeroFecha";
                case "semanal":
                    return "Semana $numeroFecha";
                case "quincenal":
                    return "Quincena $numeroFecha";
                case "mensual":
                    return "Mes $numeroFecha";
                default:
                    return "";
            }
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
        ?>
    </main>

</body>

</html>
