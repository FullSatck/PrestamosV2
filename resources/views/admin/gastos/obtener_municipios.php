<?php
include "../../../../controllers/conexion.php";

// Obtener el ID de zona desde la solicitud GET
$idZona = $_GET['id_zona'];

// Consultar los municipios asociados al estado seleccionado
$consultaCiudades = "SELECT Nombre FROM ciudades WHERE IDZona = ?";
$stmt = $conexion->prepare($consultaCiudades);
$stmt->bind_param("i", $idZona);
$stmt->execute();
$resultadoCiudades = $stmt->get_result();

// Construir las opciones del select de municipios

while ($fila = $resultadoCiudades->fetch_assoc()) {
    $options .= '<option value="' . $fila['Nombre'] . '">' . $fila['Nombre'] . '</option>';
}

// Devolver las opciones como respuesta AJAX
echo $options;

$stmt->close();
$conexion->close();
?>
