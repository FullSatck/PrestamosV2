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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Admin</title>

    <link rel="stylesheet" href="/public/assets/css/inicio.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    .btn-status {
            padding: 10px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .active {
            background-color: green;
        }
        .inactive {
            background-color: red;
        }
    </style>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <button id="systemStatusButton" class="btn-status">Cargando...</button>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/admin/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href=" /resources/views/admin/admin_saldo/saldo_admin.php">
                <div class="option">
                    <i class="fa-solid fa-sack-dollar" title=""></i>
                    <h4>Saldo Inicial</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/admin/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/admin/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>
            <a href="/resources/views/admin/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>
            <a href="/resources/views/admin/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>
            <a href="/resources/views/admin/cobros/cobros.php">
                <div class="option">
                    <i class="fa-solid fa-arrow-right-to-city" title=""></i>
                    <h4>Zonas de cobro</h4>
                </div>
            </a>

            <a href="/resources/views/admin/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/admin/abonos/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/admin/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>
            <a href="/resources/views/admin/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>
        </div>
    </div>

    <main>
        <h1>Inicio Administrador</h1>
        <div class="cuadros-container">
            <div class="cuadro cuadro-1">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/cobro_inicio.php" class="titulo">Prestamos</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='cob'>$ " . number_format($totalMonto, 0, '.', '.') . "</span>"; ?>
                    </p>
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
    </main>

    <script>
        $(document).ready(function() {
            // Obtener el estado actual del sistema
            $.get('controllers/system_status.php', function(data) {
                var response = JSON.parse(data);
                if (response.systemStatus == '1') {
                    $('#systemStatusButton').addClass('active').text('Sistema Activo');
                } else {
                    $('#systemStatusButton').addClass('inactive').text('Sistema Inactivo');
                }
            });

            // Cambiar el estado del sistema
            $('#systemStatusButton').click(function() {
                var newStatus = $(this).hasClass('inactive');
                $.post('controllers/system_status.php', {newStatus: newStatus}, function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        if (newStatus) {
                            $('#systemStatusButton').removeClass('inactive').addClass('active').text('Sistema Activo');
                        } else {
                            $('#systemStatusButton').removeClass('active').addClass('inactive').text('Sistema Inactivo');
                        }
                    } else {
                        alert(result.message || 'No se pudo cambiar el estado del sistema.');
                    }
                });
            });
        });
    </script>
    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>