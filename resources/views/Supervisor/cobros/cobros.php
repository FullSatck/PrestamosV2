<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Zonas</title>
    <link rel="stylesheet" href="/public/assets/css/cobros.css"> 
</head>
<body>
    
    <a href="/resources/views/admin/cobros/agregar_cobro.php" class="add-button">Agregar Zona</a> 
    <h2>Listado de Zonas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Capital</th>
            <th>Cobrador Asignado</th>
            <th>CdPostal</th>
            <th>Acciones</th>
            <th>Enrutar</th>
        </tr>

        <?php
        // Realiza la conexión a la base de datos (ajusta los detalles de conexión según tu configuración)
        include("../../../../controllers/conexion.php");

        // Query SQL para obtener todas las zonas
        $sql = "SELECT * FROM zonas";
        $result = mysqli_query($conexion, $sql);

        // Muestra los datos en una tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Capital"] . "</td>";
            echo "<td>" . $row["CobradorAsignado"] . "</td>";
            echo "<td>" . $row["CodigoPostal"] . "</td>";
            echo '<td><a href="editar_zona.php?id=' . $row["ID"] . '">Editar</a> | <a href="eliminar_zona.php?id=' . $row["ID"] . '">Eliminar</a></td>';
            echo '<td><a href="/resources/views/admin/enrutar/cobradores_ruta.php?id=' . $row["ID"] . '">Enrutar</a>';
            echo "</tr>";
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
        ?>
    </table>
</body>
</html>
