<?php
// Incluye el archivo de conexión a la base de datos
include_once "../../../../controllers/conexion.php"; // Reemplaza "conexion.php" con la ruta correcta a tu archivo de conexión

// Función para generar informe de Clientes
function generarInformeClientes($conexion) {
    $sql = "SELECT * FROM clientes";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Informe de Clientes</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Domicilio</th><th>Teléfono</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Apellido"] . "</td>";
            echo "<td>" . $row["Domicilio"] . "</td>";
            echo "<td>" . $row["Telefono"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron clientes.";
    }
}

// Función para generar informe de Préstamos
function generarInformePrestamos($conexion) {
    $sql = "SELECT * FROM prestamos";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Informe de Préstamos</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>ID Cliente</th><th>Monto</th><th>Tasa de Interés</th><th>Plazo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["IDCliente"] . "</td>";
            echo "<td>" . $row["Monto"] . "</td>";
            echo "<td>" . $row["TasaInteres"] . "</td>";
            echo "<td>" . $row["Plazo"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron préstamos.";
    }
}

// Función para generar informe de Pagos
function generarInformePagos($conexion) {
    $sql = "SELECT * FROM facturas";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Informe de Pagos</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>ID Cliente</th><th>Monto Pagado</th><th>Fecha</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["cliente_id"] . "</td>";
            echo "<td>" . $row["monto_pagado"] . "</td>";
            echo "<td>" . $row["fecha"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron pagos.";
    }
}

// Función para generar informe de Gastos
function generarInformeGastos($conexion) {
    $sql = "SELECT * FROM gastos";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Informe de Gastos</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Descripción</th><th>Valor</th><th>Fecha</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Descripcion"] . "</td>";
            echo "<td>" . $row["Valor"] . "</td>";
            echo "<td>" . $row["Fecha"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron gastos.";
    }
}

// Procesar el formulario y generar el informe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST["categoria"];

    switch ($categoria) {
        case "clientes":
            generarInformeClientes($conexion);
            break;
        case "prestamos":
            generarInformePrestamos($conexion);
            break;
        case "pagos":
            generarInformePagos($conexion);
            break;
        case "gastos":
            generarInformeGastos($conexion);
            break;
        default:
            echo "Categoría no válida.";
            break;
    }
}

// Cerrar la conexión a la base de datos (si es necesario)
// $conexion->close();
?>
