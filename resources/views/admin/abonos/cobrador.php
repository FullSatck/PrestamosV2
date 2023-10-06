<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado el parámetro 'zona' en la URL
if (!isset($_GET['zona'])) {
    // Si no se proporciona un nombre de zona válido, redirigir a alguna página de manejo de errores
    header("location: error.php");
    exit();
}

// Obtener el ID de la zona desde la URL
$idZona = $_GET['zona'];

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <title>Cobradores en Zona con ID: <?= $idZona ?></title>
  
</head>
<body>
    <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Cobradores en Zona con ID: <?= $idZona ?></h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Botón para volver a la página de supervisores -->
                <div class="return-button">
                    <a href="javascript:history.go(-1)" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver a Supervisores</a>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Resto del código de la tabla -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th> 
                            <th scope="col">Email</th>
                            <th scope="col">ID Zona</th> <!-- Cambiamos a mostrar el ID de la zona -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../../../../controllers/conexion.php");
                        // Consulta para obtener los cobradores en la zona especificada por ID
                        $sql = $conexion->prepare("SELECT U.ID, U.Nombre, U.Apellido, U.Email, U.Zona AS IDZona FROM Usuarios U WHERE U.Zona = ? AND U.RolID = 3"); // Suponemos que el RolID de los cobradores es 3
                        $sql->bind_param("s", $idZona);
                        $sql->execute();
                        $result = $sql->get_result();
                        
                        while ($datos = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $datos['ID'] ?></td>
                                <td><?= $datos['Nombre'] ?></td>
                                <td><?= $datos['Apellido'] ?></td>
                                <td><?= $datos['Email'] ?></td>
                                <td><?= $datos['IDZona'] ?></td> <!-- Mostramos el ID de la zona -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</body>
</html>
