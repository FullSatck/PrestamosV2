<?php
session_start();


// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}


// Incluye el archivo de conexión
include("../../../../controllers/conexion.php");

// COBROS
try {
    // Consulta SQL para obtener la suma de MontoAPagar
    $sqlCobros = "SELECT SUM(MontoAPagar) AS TotalMonto FROM prestamos";

    // Realizar la consulta
    $resultCobros = mysqli_query($conexion, $sqlCobros);

    if ($resultCobros) {
        $rowCobros = mysqli_fetch_assoc($resultCobros);

        // Obtener el total de cobros
        $totalMonto = $rowCobros['TotalMonto'];

        // Cierra la consulta de cobros
        mysqli_free_result($resultCobros);
    } else {
        echo "Error en la consulta de cobros: " . mysqli_error($conexion);
    }
} catch (Exception $e) {
    echo "Error de conexión a la base de datos (cobros): " . $e->getMessage();
}

// INGRESOS
try {
    // Consulta SQL para obtener la suma de MontoPagado
    $sqlIngresos = "SELECT SUM(MontoPagado) AS TotalIngresos FROM historial_pagos";

    // Realizar la consulta
    $resultIngresos = mysqli_query($conexion, $sqlIngresos);

    if ($resultIngresos) {
        $rowIngresos = mysqli_fetch_assoc($resultIngresos);

        // Obtener el total de ingresos
        $totalIngresos = $rowIngresos['TotalIngresos'];

        // Cierra la consulta de ingresos
        mysqli_free_result($resultIngresos);
    } else {
        echo "Error en la consulta de ingresos: " . mysqli_error($conexion);
    }
} catch (Exception $e) {
    echo "Error de conexión a la base de datos (ingresos): " . $e->getMessage();
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/inicio.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-hand-holding-usd"></i> Recaudo</h3>
                <strong><i class="fas fa-hand-holding-usd"></i></strong>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-users"></i>
                        Usuarios
                    </a>
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-user-plus"></i>
                        Registrar Usuario
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-user-tie"></i>
                        Clientes
                    </a>
                    <a href="#clientsSubmenu" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-user-tag"></i>
                        Registrar Clientes
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-hand-holding-usd"></i>
                        Préstamos
                    </a>
                    <a href="#loansSubmenu" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-file-invoice-dollar"></i>
                        Registrar Préstamos
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-route"></i>
                        Zonas de cobro
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-receipt"></i>
                        Gastos
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-road"></i>
                        Ruta
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-donate"></i>
                        Abonos
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-money-bill-wave"></i>
                        Retiros
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar sesión
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>
            </nav>
        </div>
    </div>

    <script src="/public/assets/js/MenuLate.js"></script>
</body>
</html>
