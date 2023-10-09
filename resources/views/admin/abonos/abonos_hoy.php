<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/dias_pago.css">
    <title>Pagos Pendientes para Hoy</title>
</head>
<body>

<?php
include("../../../../controllers/conexion.php");

// Obtener la fecha actual
$fechaHoy = date("Y-m-d");

$sql = "SELECT ID, IDPrestamo, Monto, FechaPago FROM pagos WHERE Estado = 'pendiente' AND FechaPago = '$fechaHoy'";

$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h1>Pagos Pendientes para Hoy ($fechaHoy)</h1>";
    echo "<table>";
    echo "<tr><th>ID Pago</th><th>ID Préstamo</th><th>Monto</th><th>Fecha de Pago</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $pagoID = $row["ID"];
        $prestamoID = $row["IDPrestamo"];
        $monto = $row["Monto"];
        $fechaPago = $row["FechaPago"];
        
        echo "<tr><td>$pagoID</td><td>$prestamoID</td><td>$monto</td><td>$fechaPago</td></tr>";
    }
    
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='container'>";
    echo "No se encontraron pagos pendientes para hoy.";
    echo "</div>";
}

$conexion->close();
?>

</body>
</html>
