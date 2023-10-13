<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Obtener el ID de la zona desde la URL
if (isset($_GET['id'])) {
    $zona_id = $_GET['id'];
} else {
    // Si no se proporciona un ID de zona válido, puedes manejar el error aquí.
    echo "ID de zona no válido.";
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php"); // Asegúrate de que este archivo contenga tu conexión a la base de datos

// Realizar la consulta para obtener los cobradores de la zona específica
$query = "SELECT * FROM cobradores WHERE Zona = ?";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $zona_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
    } else {
        // Manejar errores en la ejecución de la consulta si es necesario
        echo "Error en la consulta: " . mysqli_error($conexion);
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    // Manejar errores en la consulta preparada si es necesario
    echo "Error en la consulta preparada: " . mysqli_error($conexion);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/cobradores_ruta.css">
    <title>Cobradores por Zona</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
</head>

<body>
    <h1>Cobradores por Zona</h1>
    <a href="/resources/views/admin/enrutar/ruta.php?id=<?php echo $zona_id; ?>" class="back-link">Volver a la página de ruta</a>

    <!-- Mostrar los cobradores en una tabla -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <!-- Agrega más columnas si es necesario -->
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Apellido"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            // Agrega más columnas si es necesario
            echo "</tr>";
        }
        ?>

    </table> 
</body>

</html>
