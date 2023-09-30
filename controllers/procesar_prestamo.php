<?php
// Incluir el archivo de conexión
include("conexion.php");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $cliente_id = $_POST["cliente_id"];
    $monto = $_POST["monto"];
    $tasa_interes = $_POST["tasa_interes"];
    $plazo = $_POST["plazo"];
    $moneda_id = $_POST["moneda_id"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $frecuencia_pago = $_POST["frecuencia_pago"];

    // Sentencia SQL para insertar datos en la tabla
    $sql = "INSERT INTO prestamos (cliente_id, monto, tasa_interes, plazo, moneda_id, fecha_inicio, frecuencia_pago) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia SQL
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param("iiiiiss", $cliente_id, $monto, $tasa_interes, $plazo, $moneda_id, $fecha_inicio, $frecuencia_pago);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            echo "Los datos se han insertado correctamente.";
        } else {
            echo "Error al insertar datos: " . $stmt->error;
        }

        // Cerrar la sentencia y la conexión
        $stmt->close();
    } else {
        echo "Error en la preparación de la sentencia: " . $conexion->error;
    }
} else {
    echo "El formulario no se ha enviado correctamente.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
