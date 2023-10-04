<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php"); // Asegúrate de que este archivo contiene tu conexión a la base de datos

// Realizar la consulta para obtener todos los supervisores
$query = "SELECT * FROM Usuarios WHERE RolID = 2"; // Suponiendo que el ID de rol para los supervisores es 2
$result = mysqli_query($conexion, $query);

if (!$result) {
    // Manejar errores en la consulta si es necesario
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/apartados_grupos.css">
    <title>Supervisores</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
</head>

<body>
    <h1>Supervisores</h1>
    <button><a href="/resources/views/admin/grupos/grupos.php">Volver</a></button>

    <!-- Mostrar la lista de supervisores -->
    <ul>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . $row['Nombre'] . " / " . $row['Email'] . " </li>";
        }
        ?>
    </ul>
</body>

</html>
