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

// Obtener el nombre de la zona desde la URL
$nombreZona = $_GET['zona'];

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
    <title>Zona: <?= $nombreZona ?></title>
</head>
<body>
    <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Préstamos en Zona: <?= $nombreZona ?></h1> 


    <a href="cobradores.php?zona=Puebla">Ver Cobradores de Puebla</a>


    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-9">
                <!-- Tabla de préstamos -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ID Cliente</th>
                            <th scope="col">Monto</th> 
                            <th scope="col">Tasa de Interés</th>
                            <th scope="col">Plazo</th> 
                            <th scope="col">Frecuencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../../../../controllers/conexion.php");
                        // Consulta para obtener los préstamos en la zona especificada
                        $sql = $conexion->prepare("SELECT ID, IDCliente, Monto, TasaInteres, Plazo, FrecuenciaPago FROM prestamos WHERE zona = ?");
                        $sql->bind_param("s", $nombreZona);
                        $sql->execute();
                        $result = $sql->get_result();
                        
                        while ($datos = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $datos['ID'] ?></td>
                                <td><?= $datos['IDCliente'] ?></td>
                                <td><?= $datos['Monto'] ?></td>
                                <td><?= $datos['TasaInteres'] ?></td>
                                <td><?= $datos['Plazo'] ?></td>
                                <td><?= $datos['FrecuenciaPago'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 

</body>
</html>
