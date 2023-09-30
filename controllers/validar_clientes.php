<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "usuario", "contraseña", "prestamos");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$historial_crediticio = $_POST["historial_crediticio"];
$referencias_personales = $_POST["referencias_personales"];
$moneda_preferida = $_POST["moneda_preferida"];
$zona_asignada = $_POST["zona_asignada"];

// Consulta SQL para insertar el nuevo cliente
$query = "INSERT INTO Clientes (Nombre, Apellido, Direccion, Telefono, HistorialCrediticio, ReferenciasPersonales, MonedaPreferida, ZonaAsignada) VALUES ('$nombre', '$apellido', '$direccion', '$telefono', '$historial_crediticio', '$referencias_personales', '$moneda_preferida', '$zona_asignada')";

// Ejecutar la consulta
if ($conexion->query($query) === TRUE) {
    echo "Cliente registrado exitosamente.";
} else {
    echo "Error al registrar el cliente: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
