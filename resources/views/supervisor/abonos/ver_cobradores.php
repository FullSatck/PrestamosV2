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

// Obtener el nombre de la zona desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];

    // Conectar a la base de datos
    include("../../../../controllers/conexion.php");

    // Consulta para obtener los usuarios con rol 2 (supervisores) en la zona especificada
    $sql = $conexion->prepare("SELECT U.ID, U.Nombre, U.Apellido, U.Email, Zonas.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios U JOIN Roles ON U.RolID = Roles.ID JOIN Zonas ON U.Zona = Zonas.ID WHERE U.RolID = 3 AND Zonas.Nombre = ?");
    $sql->bind_param("s", $nombreZona);
    $sql->execute();
    $result = $sql->get_result();

    // Verificar si se encontraron supervisores en la zona
    $supervisoresEnZona = $result->num_rows > 0;
} else {
    // Si no se proporciona un nombre de zona válido, establecer $supervisoresEnZona en falso
    $supervisoresEnZona = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <title>Zona: <?= $nombreZona ?></title>
</head>
<body>
    <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Supervisores en Zona: <?= $nombreZona ?></h1>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-9">
                <?php
                if ($supervisoresEnZona) {
                    // Mostrar la tabla solo si hay supervisores en la zona
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th> 
                                <th scope="col">Email</th>
                                <th scope="col">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($datos = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= "REC 100" . $datos['ID'] ?></td>
                                    <td><?= $datos['Nombre'] ?></td>
                                    <td><?= $datos['Apellido'] ?></td>
                                    <td><?= $datos['Email'] ?></td>
                                    <td><?= $datos['Rol'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    // Mostrar un mensaje si no se encontraron supervisores en la zona
                    echo "No se encontraron supervisores para la zona: " . $nombreZona;
                }
                ?>
            </div>
        </div>
    </div> 
</body>
</html>
