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

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/dias_pago.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <title>Fechas de Pago</title>
</head>

<body>

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
            </div>
        </div>

        <main>
    <?php
    // Incluir el archivo de conexión a la base de datos
    require_once("conexion.php");

    // Obtener el ID del préstamo desde el parámetro GET
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idPrestamo = $_GET['id'];

        // Consulta SQL para obtener los detalles del préstamo con el ID dado
        $sql = "SELECT FechaInicio, FrecuenciaPago, Plazo, Cuota, MontoAPagar FROM prestamos WHERE ID = $idPrestamo";
        $result = $conexion->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $fechaInicio = new DateTime($row["FechaInicio"]);
            $frecuenciaPago = $row["FrecuenciaPago"];
            $plazo = $row["Plazo"];
            $cuota = $row["Cuota"];
            $totalAPagar = $row["MontoAPagar"];

            // Calcular las fechas de pago
            $fechasPago = calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo);

            // Mostrar las fechas de pago en una tabla
            echo "<div class='container'>";
            echo "<h1>Fechas de Pago</h1>"; 
            echo "<table>";
            echo "<tr><th>Frecuencia</th><th>Fecha</th><th>Cuota</th><th>Frecuencia de Pago</th><th>Pagado</th></tr>";
            $numeroFecha = 1;
            $sumaPagos = 0;
            foreach ($fechasPago as $fecha) {
                $frecuencia = obtenerFrecuencia($frecuenciaPago, $numeroFecha);
                $fechaFormato = $fecha->format("Y-m-d");

                // Preparar la consulta SQL para verificar si la cuota ha sido pagada
                $stmt = $conexion->prepare("SELECT FechaPago, MontoPagado FROM historial_pagos WHERE FechaPago = ? AND IDPrestamo = ?");
                $stmt->bind_param("si", $fechaFormato, $idPrestamo);
                $stmt->execute();
                $resultPago = $stmt->get_result();

                $estadoPago = "No Pagado"; // Estado por defecto
                if ($resultPago->num_rows > 0) {
                    $estadoPago = "Pagado";
                    $pago = $resultPago->fetch_assoc();
                    $sumaPagos += $pago["MontoPagado"];
                }

                echo "<tr><td>$frecuencia</td><td>$fechaFormato</td><td>$cuota</td><td>$frecuenciaPago</td><td>$estadoPago</td></tr>";
                $numeroFecha++;
            }
            echo "</table>";
            echo "</div>";

            // Si la suma de los pagos es igual al total a pagar, actualizar el estado del préstamo
            if ($sumaPagos >= $totalAPagar) {
                // Actualizar el estado del préstamo a 'pagado' y EstadoP a 0
                $stmt = $conexion->prepare("UPDATE prestamos SET Estado = 'pagado', EstadoP = 0 WHERE ID = ?");
                $stmt->bind_param("i", $idPrestamo);
                $stmt->execute();
            }
        } else {
            echo "ID de préstamo no válido.";
        }
    } else {
        echo "ID de préstamo no proporcionado.";
    }

    // Función para calcular las fechas de pago
    function calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo)
    {
        $fechasPago = array();

        for ($i = 0; $i < $plazo; $i++) {
            $fechasPago[] = clone $fechaInicio;

            if ($frecuenciaPago === "diario") {
                $fechaInicio->modify("+1 day");
            } elseif ($frecuenciaPago === "semanal") {
                $fechaInicio->modify("+1 week");
            } elseif ($frecuenciaPago === "quincenal") {
                $fechaInicio->modify("+2 weeks");
            } elseif ($frecuenciaPago === "mensual") {
                $fechaInicio->modify("+1 month");
            }
        }

        return $fechasPago;
    }

    // Función para obtener la descripción de la frecuencia
    function obtenerFrecuencia($frecuenciaPago, $numeroFecha)
    {
        switch ($frecuenciaPago) {
            case "diario":
                return "Día $numeroFecha";
            case "semanal":
                return "Semana $numeroFecha";
            case "quincenal":
                return "Quincena $numeroFecha";
            case "mensual":
                return "Mes $numeroFecha";
            default:
                return "";
        }
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>
</main>





        <script src="/public/assets/js/MenuLate.js"></script>
    </body>

</html>