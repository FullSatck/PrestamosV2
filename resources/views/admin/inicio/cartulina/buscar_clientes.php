
<!-- CODIGO PARA EL BUSCADOR DE CLIENTES -->

<?php
include '../../../../../controllers/conexion.php';
include 'load_clients.php'; // Asegúrate de que este archivo incluya la conexión a la base de datos

$busqueda = $_GET['busqueda'] ?? '';

$query = "SELECT id, Nombre, Apellido, Telefono FROM clientes WHERE Nombre LIKE ? OR Apellido LIKE ? OR Telefono LIKE ?";
$stmt = $conexion->prepare($query);
$likeBusqueda = '%' . $busqueda . '%';
$stmt->bind_param("sss", $likeBusqueda, $likeBusqueda, $likeBusqueda);
$stmt->execute();
$resultado = $stmt->get_result();

$clientes = [];
while ($fila = $resultado->fetch_assoc()) {
    $clientes[] = $fila;
}

echo json_encode($clientes);
