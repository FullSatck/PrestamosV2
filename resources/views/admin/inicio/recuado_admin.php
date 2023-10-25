<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
} 

// Conectar a la base de datos
include("../../../../controllers/conexion.php");
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/recaudo_admin.css">
</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-circle-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="wallet-outline"></ion-icon>
                <span>Recaudo</span>
            </div>
            <button class="boton" id="volverAtras">
                <ion-icon name="arrow-undo-outline"></ion-icon>
                <span>&nbsp;Volver</span>
            </button>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/resources/views/admin/admin_saldo/saldo_admin.php">
                        <ion-icon name="push-outline"></ion-icon>
                        <span>Saldo Inicial</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/inicio/inicio.php" class="hola">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/crudusuarios.php">
                        <ion-icon name="people-outline"></ion-icon>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/registrar.php">
                        <ion-icon name="person-add-outline"></ion-icon>
                        <span>Registrar Usuario</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/lista_clientes.php">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span>Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/agregar_clientes.php">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span>Registrar Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/crudPrestamos.php">
                        <ion-icon name="list-outline"></ion-icon>
                        <span>Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/prestamos.php">
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        <span>Registrar Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/cobros/cobros.php">
                        <ion-icon name="planet-outline"></ion-icon>
                        <span>Zonas de cobro</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/gastos/gastos.php">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Gastos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/lista_super.php">
                        <ion-icon name="map-outline"></ion-icon>
                        <span>Ruta</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/abonos.php">
                        <ion-icon name="cloud-download-outline"></ion-icon>
                        <span>Abonos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/retiros/retiros.php">
                        <ion-icon name="cloud-done-outline"></ion-icon>
                        <span>Retiros</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    <a href="/controllers/cerrar_sesion.php"><span>Cerrar Sesion</span></a>
                </div>
            </div>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Recaudos totales</h1>
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
        // Muestra los resultados en la tabla
        $nombreCliente = $nombresClientes[$clienteID];
        echo "<tr>";
        echo "<td>" . "Recaudo REC-10" . $row['ID'] . "</td>";
        echo "<td>" . $nombreCliente . "</td>";
        echo "<td>" . $row['FechaPago'] . "</td>";
        echo "<td>" . $row['MontoPagado'] . "</td>";
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>