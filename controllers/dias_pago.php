<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
require_once("conexion.php");

$usuario_id = $_SESSION["usuario_id"];

// Asumiendo que la tabla de roles se llama 'roles' y tiene las columnas 'id' y 'nombre_rol'
$sql_nombre = "SELECT usuarios.nombre, roles.nombre FROM usuarios INNER JOIN roles ON usuarios.rolID = roles.id WHERE usuarios.id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
    $_SESSION["nombre"] = $fila["nombre"]; // Guarda el nombre del rol en la sesión
}
$stmt->close();
date_default_timezone_set('America/Bogota');

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

            <a href="javascript:history.back()" class="back-link">Volver Atrás</a>

            <div class="nombre-usuario">
                <?php
    if (isset($_SESSION["nombre_usuario"], $_SESSION["nombre"])) {
        echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span>" . htmlspecialchars($_SESSION["nombre"]) . "</span>";
    }
    ?>
            </div>

        </header>
        <main>
            <?php

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
            echo "<div class='table-scroll-container' id='profile-loans'>";

            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $idPrestamo = $_GET['id'];
            
                // Consulta SQL para obtener los detalles del préstamo con el ID dado
                $sql = "SELECT clientes.nombre AS nombre_cliente, FechaInicio, FrecuenciaPago, Plazo, Cuota, MontoAPagar FROM prestamos INNER JOIN clientes ON prestamos.IDCliente = clientes.ID WHERE prestamos.ID = $idPrestamo";
                $result = $conexion->query($sql);
            
                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $nombreCliente = $row["nombre_cliente"]; // Guarda el nombre del cliente
            
                    // Mostrar el nombre del cliente debajo del título
                    echo "<h1>Fechas de Pago</h1>";
                    echo "<p class='nombre-cliente'>Cliente: $nombreCliente</p>";
            
                    // Resto del código...
                } else {
                    echo "ID de préstamo no válido.";
                }
            } else {
                echo "ID de préstamo no proporcionado.";
            }

            echo "<table>";
            echo "<tr><th>Frecuencia</th><th>Fecha</th></tr>";
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

                // Calcular la fecha límite para el pago
                $fechaLimite = calcularFechasPagoConPlazo($fecha, 20);

                // Verificar si se ha superado la fecha límite y el pago no se ha realizado
                $hoy = new DateTime();
                if ($estadoPago == "No Pagado" && $hoy > $fechaLimite) {
                    // Actualiza el estado del cliente en la base de datos a "Vencido"
                    $stmt = $conexion->prepare("UPDATE clientes SET Estado = 'Vencido' WHERE ID = ?");
                    $stmt->bind_param("i", $usuario_id); // Asegúrate de tener el ID del cliente
                    $stmt->execute();
                }

                echo "<tr><td>$frecuencia</td><td>$fechaFormato</td></tr>";
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

    // Función para calcular la fecha límite de pago excluyendo domingos
    function calcularFechasPagoConPlazo($fechaInicio, $plazo) {
        $fechaLimite = clone $fechaInicio;
        $diasHabiles = 0;
        while ($diasHabiles < $plazo) {
            $fechaLimite->modify("+1 day");
            if ($fechaLimite->format("l") != "Sunday") {
                $diasHabiles++;
            }
        }
        return $fechaLimite;
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

    </body>

</html>