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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <title>Abonos</title>
  
</head>
<body>
    <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Supervisores</h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Botón para registrar trabajadores -->
                <div class="register-button">
                    <a href="registrar.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Registrar Trabajador</a>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Botón para volver a la página anterior -->
                <div class="return-button">
                    <a href="javascript:history.go(-1)" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                </div>

                    <!-- Resto del código de la tabla -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th> 
                                <th scope="col">Zona</th>
                                <th scope="col">Rol</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../../../../controllers/conexion.php");
                            $sql = $conexion->query("SELECT Usuarios.ID, Usuarios.Nombre, Usuarios.Apellido, Usuarios.Email, Zonas.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios JOIN Zonas ON Usuarios.Zona = Zonas.ID JOIN Roles ON Usuarios.RolID = Roles.ID WHERE Roles.ID = 2"); // Filtra por el ID del rol de supervisor (2)
                            $rowCount = 0; // Contador de filas
                            while ($datos = $sql->fetch_object()) { 
                                $rowCount++; // Incrementar el contador de filas
                                ?>
                                <tr class="row<?= $rowCount ?>">
                                    <td><?= "REC 100" .$datos->ID ?></td>
                                    <td><?= $datos->Nombre ?></td>
                                    <td><?= $datos->Apellido ?></td>
                                    <td><a href="prestamos_zonas.php?zona=<?= $datos->Zona ?>"><?= $datos->Zona ?></a></td>
                                    <td><?= $datos->Rol ?></td> 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div id="pagination" class="text-center">
                    <ul class="pagination">
                        <!-- Los botones de paginación se generarán aquí -->
                    </ul>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>
