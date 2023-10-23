<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Obtener el nombre de la zona desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Conectar a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener los préstamos de la zona especificada con el nombre del cliente
$sql = $conexion->prepare("SELECT P.ID, C.Nombre AS NombreCliente, P.Zona, P.Monto FROM prestamos P INNER JOIN clientes C ON P.IDCliente = C.ID WHERE P.Zona = ?");
$sql->bind_param("s", $nombreZona);
$sql->execute();

// Verificar si la consulta se realizó con éxito
if ($sql === false) {
    die("Error en la consulta SQL: " . $conexion->error);
}
 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <title>Listado de Préstamos</title>
</head>
<body> 
    <h1 class="text-center">Listado de Prestamos en Zona: <?= $nombreZona ?></h1>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID del Préstamo</th>
                            <th scope="col">Nombre del Cliente</th>
                            <th scope="col">Zona</th>
                            <th scope="col">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $sql->get_result();
                        $rowCount = 0; // Contador de filas
                        while ($datos = $result->fetch_assoc()) { 
                            $rowCount++; // Incrementar el contador de filas
                            ?>
                            <tr class="row<?= $rowCount ?>">
                                <td><?= "Prestamo " . $datos['ID'] ?></td>
                                <td><?= $datos['NombreCliente'] ?></td>
                                <td><?= $datos['Zona'] ?></td>
                                <td><?= $datos['Monto'] ?></td>
                            </tr>
                        <?php } 
                        // Cerrar la consulta y la conexión a la base de datos
                        $sql->close();
                        $conexion->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</body>
</html>
