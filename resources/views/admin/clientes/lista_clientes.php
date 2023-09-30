<?php
// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener todos los clientes
$sql = "SELECT * FROM Clientes";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/lista_clientes.css"> <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Listado de Clientes</title>
</head>
<body>
    <h1>Listado de Clientes</h1>
    

    <?php if ($resultado->num_rows > 0) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Historial Crediticio</th>
                <th>Referencias Personales</th>
                <th>Moneda Preferida</th>
                <th>Zona Asignada</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?= $fila["ID"] ?></td>
                    <td><?= $fila["Nombre"] ?></td>
                    <td><?= $fila["Apellido"] ?></td>
                    <td><?= $fila["Direccion"] ?></td>
                    <td><?= $fila["Telefono"] ?></td>
                    <td><?= $fila["HistorialCrediticio"] ?></td>
                    <td><?= $fila["ReferenciasPersonales"] ?></td>
                    <td><?= $fila["MonedaPreferida"] ?></td>
                    <td><?= $fila["ZonaAsignada"] ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No se encontraron clientes en la base de datos.</p>
    <?php } ?>
</body>
</html>

