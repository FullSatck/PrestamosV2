<?php
// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Verificar si se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $clienteID = $_POST["clienteID"];
    $monto = $_POST["monto"];
    $tasaInteres = $_POST["tasaInteres"];
    $plazo = $_POST["plazo"];
    $frecuenciaPago = $_POST["frecuenciaPago"];
    $zona = $_POST["zona"];

    // Calcula la fecha de vencimiento
    $fechaVencimiento = calcularFechaVencimiento($frecuenciaPago, $plazo);

    // Insertar los datos en la tabla "Prestamos"
    $sql = "INSERT INTO Prestamos (IDCliente, Monto, TasaInteres, Plazo, FechaInicio, FechaVencimiento, Estado, CobradorAsignado, Zona) VALUES (?, ?, ?, ?, CURDATE(), ?, 'pendiente', ?, ?)";

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Enlazar parámetros
        $stmt->bind_param("idiiiss", $clienteID, $monto, $tasaInteres, $plazo, $fechaVencimiento, $zona, $estado);

        // Definir los valores fijos
        $estado = 'pendiente';

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Préstamo solicitado con éxito.";
        } else {
            echo "Error al solicitar el préstamo: " . $stmt->error;
        }

        // Cerrar la consulta
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}

// Función para calcular la fecha de vencimiento
function calcularFechaVencimiento($frecuenciaPago, $plazo) {
    $fechaInicio = new DateTime();
    $fechaVencimiento = clone $fechaInicio;

    if ($frecuenciaPago === "mensual") {
        $fechaVencimiento->add(new DateInterval("P{$plazo}M"));
    } elseif ($frecuenciaPago === "quincenal") {
        $fechaVencimiento->add(new DateInterval("P{$plazo}D"));
    } elseif ($frecuenciaPago === "semanal") {
        $fechaVencimiento->add(new DateInterval("P" . ($plazo * 7) . "D"));
    }

    return $fechaVencimiento->format("Y-m-d");
}
?>
