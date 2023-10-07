<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado una zona en la URL
if (isset($_GET['zona'])) {
    $zonaSeleccionada = $_GET['zona'];

    // Incluir el archivo de conexión a la base de datos
    include("../../../../controllers/conexion.php");

    // Consultar la base de datos para obtener los cobradores de la zona seleccionada
    $sql = $conexion->prepare("SELECT ID, Nombre, Apellido FROM usuarios WHERE Zona = ?");

    // Verificar si la preparación de la consulta fue exitosa
    if ($sql === false) {
        die("La preparación de la consulta SQL falló: " . $conexion->error);
    }

    // Enlazar el parámetro
    if (!$sql->bind_param("s", $zonaSeleccionada)) {
        die("La vinculación de parámetros falló: " . $sql->error);
    }

    // Ejecutar la consulta
    if (!$sql->execute()) {
        die("La ejecución de la consulta SQL falló: " . $sql->error);
    }

    // Obtener el resultado de la consulta
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Si hay datos en el resultado, mostrar la tabla
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lista de Cobradores de la Zona</title>
        </head>
        <body>
            <h1 class="text-center">Lista de Cobradores de la Zona: <?= htmlspecialchars($zonaSeleccionada) ?></h1>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <!-- Agregar más columnas según tu estructura de usuarios -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            // Mostrar la información de los cobradores
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['ID']) ?></td>
                                <td><?= htmlspecialchars($row['Nombre']) ?></td>
                                <td><?= htmlspecialchars($row['Apellido']) ?></td>
                                <!-- Agregar más columnas según tu estructura de usuarios -->
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Si no se encontraron datos en la consulta
        echo "No se encontraron cobradores para la zona: " . htmlspecialchars($zonaSeleccionada);
    }

    // Cerrar la conexión a la base de datos
    $sql->close();
    $conexion->close();
} else {
    // Manejar el caso en el que no se proporcionó una zona válida en la URL
    echo "Zona no especificada.";
}
?>
