<?php
session_start();

// Validacion de rol para ingresar a la pagina 
require_once '../../../../controllers/conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
} else {
    // El usuario está autenticado, obtén el ID del usuario de la sesión
    $usuario_id = $_SESSION["usuario_id"];
    
    // Preparar la consulta para obtener el rol del usuario
    $stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
    $stmt->bind_param("i", $usuario_id);
    
    // Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    // Verifica si el resultado es nulo, lo que significaría que el usuario no tiene un rol válido
    if (!$fila) {
        // Redirige al usuario a una página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }

    // Extrae el nombre del rol del resultado
    $rol_usuario = $fila['Nombre'];
    
    // Verifica si el rol del usuario corresponde al necesario para esta página
    if ($rol_usuario !== 'admin') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
    
   
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


// COMISIONES
try {
    // Consulta SQL para obtener la suma de Comision
    $sqlComisiones = "SELECT SUM(Comision) AS TotalComisiones FROM prestamos";

    // Realizar la consulta
    $resultComisiones = mysqli_query($conexion, $sqlComisiones);

    if ($resultComisiones) {
        $rowComisiones = mysqli_fetch_assoc($resultComisiones);

        // Obtener el total de comisiones
        $totalComisiones = $rowComisiones['TotalComisiones'];

        // Cierra la consulta de comisiones
        mysqli_free_result($resultComisiones);
    } else {
        echo "Error en la consulta de comisiones: " . mysqli_error($conexion);
    }
} catch (Exception $e) {
    echo "Error de conexión a la base de datos (comisiones): " . $e->getMessage();
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




</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
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

            <a href="/resources/views/admin/ruta/lista_super.php">
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
        <a href="/controllers/cerrar_sesion.php" class="botonn">
            <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
            <span class="spann">Cerrar Sesion</span>
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
                    <p><?php echo "<strong>Total:</strong> <span class='ing'> $ " . number_format($totalIngresos, 0, '.', '.') . "</span>" ?></p>
                </div>
            </div>
            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="filtros.php" class="titulo">Prestamos del dia </a>
                    <p>Mantenimiento</p>
                </div>
            </div>
            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/comision_inicio.php" class="titulo">Comision</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='com'>$ " . number_format($totalComisiones, 0, '.', '.') . "</span>"; ?>
                    </p>
                </div>
            </div>

        </div>
         

        </div>
        </div>


    </main>




    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>