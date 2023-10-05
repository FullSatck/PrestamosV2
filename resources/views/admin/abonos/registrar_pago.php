<?php
// Incluye el archivo de conexión que contiene la variable $conexion
include("../../../../controllers/conexion.php");

// Inicializa una respuesta por defecto
$response = array("success" => false, "message" => "");

// Obtener los datos enviados por la solicitud AJAX
$clienteId = $_POST["clienteId"];
$monto = $_POST["monto"];
$fechaPago = $_POST["fechaPago"];

// Realizar la inserción en la tabla de historial de pagos
$sql = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado) VALUES ($clienteId, '$fechaPago', $monto)";

if ($conexion->query($sql) === TRUE) {
    // Éxito
    $response["success"] = true;
    $response["message"] = "Pago registrado con éxito";
} else {
    // Error al insertar en el historial de pagos
    $response["message"] = "Error al registrar el pago: " . $conexion->error;
}

// Agrega encabezados para indicar que la respuesta es JSON
header("Content-Type: application/json; charset=UTF-8");

// Devuelve la respuesta como JSON
echo json_encode($response);
?>
