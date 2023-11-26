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


// Conectar a la base de datos
include("../../../../controllers/conexion.php");

$usuario_id = $_SESSION["usuario_id"];

$sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/recaudo_admin.css">
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Supervisor<span>";
        }
        ?>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/controllers/cerrar_sesion.php">
                <div class="option">
                    <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
                    <h4>Cerrar Sesion</h4>
                </div>
            </a>
            <a href="/resources/views/zonas/31-Zacatecas/supervisor/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/31-Zacatecas/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>


        </div>

    </div>



    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Recaudos totales</h1>

        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>

        <?php
// Incluye el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener todos los campos de la tabla historial_pagos en orden descendente
$sql = "SELECT * FROM historial_pagos ORDER BY ID DESC";

// Ejecutar la consulta
$result = mysqli_query($conexion, $sql);

if ($result) {
    // Crear un arreglo para almacenar los nombres de los clientes
    $nombresClientes = array();

    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nombre del Cliente</th>";
    echo "<th>FechaPago</th>";
    echo "<th>MontoPagado</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        // Almacena los IDs de cliente en el arreglo
        $clienteID = $row['IDCliente'];
        // Verifica si el nombre del cliente ya se obtuvo previamente
        if (!array_key_exists($clienteID, $nombresClientes)) {
            // Si no se ha obtenido, realiza una consulta para obtener el nombre
            $consultaCliente = "SELECT Nombre FROM clientes WHERE ID = $clienteID";
            $resultCliente = mysqli_query($conexion, $consultaCliente);
            if ($rowCliente = mysqli_fetch_assoc($resultCliente)) {
                // Almacena el nombre del cliente en el arreglo
                $nombresClientes[$clienteID] = $rowCliente['Nombre'];
            }
        }
        // Muestra los resultados en la tabla con el formato de MontoPagado
        $nombreCliente = $nombresClientes[$clienteID];
        $montoPagado = number_format($row['MontoPagado'], 0, ',', '.'); // Formatea con puntos de mil
        echo "<tr>";
        echo "<td>" . "Recaudo REC-10" . $row['ID'] . "</td>";
        echo "<td>" . $nombreCliente . "</td>";
        echo "<td>" . $row['FechaPago'] . "</td>";
        echo "<td>" . $montoPagado . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>


    </main>

    <script>
    // Agregar un evento clic al botón
    document.getElementById("volverAtras").addEventListener("click", function() {
        window.history.back();
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search-input");
        const rows = document.querySelectorAll("table tr");

        searchInput.addEventListener("input", function() {
            const searchTerm = searchInput.value.trim().toLowerCase();

            rows.forEach(function(row, index) {
                if (index === 0) {
                    // Salta la primera fila que contiene encabezados de la tabla
                    return;
                }

                const columns = row.querySelectorAll("td");
                let found = false;

                columns.forEach(function(column, columnIndex) {
                    const text = column.textContent.toLowerCase();
                    if (columnIndex === 0 && text.includes(searchTerm)) {
                        // Busca el término en la primera columna (ID)
                        found = true;
                    } else if (text.includes(searchTerm)) {
                        // Busca el término en otras columnas
                        found = true;
                    }
                });

                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
    </script>

    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>