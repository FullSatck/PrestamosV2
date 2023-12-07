<?php
date_default_timezone_set('America/Bogota');
// Conexión al servidor con usuario, contraseña y base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$dbnombre = "prestamos";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $dbnombre);

// Comprobar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Puedes descomentar las siguientes líneas para confirmar que la conexión es efectiva

// else {
  //   echo "Conexión efectiva";
// }

?>

<?php
// ... (tu código de conexión)

// Verificar si se recibió una solicitud para cambiar el estado de pago
if (isset($_POST['cliente_id']) && isset($_POST['nuevo_estado']) && $_SESSION['rol'] === 'admin') {
    $cliente_id = $_POST['cliente_id'];
    $nuevo_estado = $_POST['nuevo_estado'];

    // Actualizar el estado de pago en la tabla de clientes
    $update_query = "UPDATE clientes SET EstadoPago = '$nuevo_estado' WHERE ID = $cliente_id";
    $conexion->query($update_query);

    // Si el nuevo estado es 'moroso', mover el cliente a la tabla de clientes clavos
    if ($nuevo_estado === 'moroso') {
        $insert_query = "INSERT INTO clientes_clavos (ID, Nombre, Deuda) SELECT ID, Nombre, 0.00 FROM clientes WHERE ID = $cliente_id";
        $conexion->query($insert_query);
    }
}

// Realizar consulta para obtener datos de clientes morosos
$query = "SELECT * FROM clientes WHERE EstadoPago = 'moroso'";
$result = $conexion->query($query);

// Comprobar si la consulta fue exitosa
if ($result === false) {
    // Manejar el error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Clavos</title>
    <link rel="stylesheet" type="text/css" href="clavos.css">
</head>

<body>

    <div class="container">
        <h2>Clientes Clavos</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Deuda</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los resultados en la tabla
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Nombre'] . "</td>";
                    echo "<td>Deuda</td>";  // Necesitarás obtener la deuda desde tu base de datos
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>