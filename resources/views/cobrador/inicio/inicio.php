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
</head>

<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recaudo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="sidebar">
        <div class="sidebar-title">
            <h2>Recaudo</h2>
            <span id="close-btn">&times;</span>
        </div>
        <ul class="sidebar-links">
            <li><a href="#">Saldo Inicial</a></li>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Usuarios</a></li>
            <li><a href="#">Registrar Usuario</a></li>
            <li><a href="#">Clientes</a></li>
            <li><a href="#">Registrar Clientes</a></li>
            <li><a href="#">Préstamos</a></li>
            <li><a href="#">Registrar Préstamos</a></li>
            <li><a href="#">Zonas de cobro</a></li>
            <li><a href="#">Gastos</a></li>
            <li><a href="#">Ruta</a></li>
            <li><a href="#">Abonos</a></li>
            <li><a href="#">Retiros</a></li>
            <li><a href="#">Cerrar sesión</a></li>
        </ul>
    </div>
    
 <!-- ACA VA EL CONTENIDO DE LA PAGINA -->
    <div id="content">
    <h1>Inicio Administrador</h1>
        <div class="cuadros-container">
            <div class="cuadro cuadro-1">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/cobro_inicio.php" class="titulo">Cobros</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='cob'> $ $totalMonto </span>" ?></p>
                </div>
            </div>
            <div class="cuadro cuadro-3">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/recuado_admin.php" class="titulo">Recaudos</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='ing'> $  $totalIngresos </span>" ?></p>
                </div>
            </div>
            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="##" class="titulo">Contabilidad</a>
                </div>
            </div>
            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="##" class="titulo">Comision</a>
                </div>
            </div>
        </div>
        <span id="menu-btn">&#9776;</span>
    </div>

    <script src="script.js"></script>
</body>
</html>

   





    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>