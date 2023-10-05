<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos</title>
</head>
<body>
    <h1>Lista de Préstamos</h1>

    <?php
    // Configuración de la conexión a la base de datos
    require_once("conexion.php"); // Incluye el archivo de conexión

    // Consulta SQL para obtener los préstamos y sus fechas de inicio
    $sql = "SELECT ID, FechaInicio, FrecuenciaPago FROM prestamos";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los préstamos y calcular las fechas de pago
        while ($row = $result->fetch_assoc()) {
            $idPrestamo = $row["ID"];
            $fechaInicio = new DateTime($row["FechaInicio"]);
            $frecuenciaPago = $row["FrecuenciaPago"];

            // Calcular las fechas de pago
            $fechasPago = calcularFechasPago($fechaInicio, $frecuenciaPago);

            echo "<h2>Préstamo ID: $idPrestamo</h2>";
            echo "<p>Fecha de Inicio: " . $fechaInicio->format("Y-m-d") . "</p>";
            echo "<p>Frecuencia de Pago: $frecuenciaPago</p>";
            echo "<p>Fechas de Pago:</p>";
            echo "<ul>";
            foreach ($fechasPago as $fecha) {
                echo "<li>" . $fecha->format("Y-m-d") . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "No se encontraron préstamos en la base de datos.";
    }

    // Función para calcular las fechas de pago
    function calcularFechasPago($fechaInicio, $frecuenciaPago) {
        $fechasPago = array();
        $hoy = new DateTime();

        // Agregar la fecha de inicio
        $fechasPago[] = clone $fechaInicio;

        // Calcular las fechas de pago basadas en la frecuencia
        while ($fechaInicio < $hoy) {
            if ($frecuenciaPago === "diario") {
                $fechaInicio->modify("+1 day");
            } elseif ($frecuenciaPago === "semanal") {
                $fechaInicio->modify("+1 week");
            } elseif ($frecuenciaPago === "quincenal") {
                $fechaInicio->modify("+2 weeks");
            } elseif ($frecuenciaPago === "mensual") {
                $fechaInicio->modify("+1 month");
            }
            $fechasPago[] = clone $fechaInicio;
        }

        return $fechasPago;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>

</body>
</html>
