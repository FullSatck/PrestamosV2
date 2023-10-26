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
    <link rel="stylesheet" href="/public/assets/css/dias_pago.css"> <!-- Agrega esta línea para vincular el archivo CSS -->
    <title>Fechas de Pago</title>
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
                    <a href="/resources/views/admin/inicio/inicio.php">
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
                    <a href="/resources/views/admin/clientes/lista_clientes.php" class="hola">
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
        
<?php
// Incluir el archivo de conexión a la base de datos
require_once("conexion.php");

// Obtener el ID del préstamo desde el parámetro GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idPrestamo = $_GET['id'];

    // Consulta SQL para obtener los detalles del préstamo con el ID dado
    $sql = "SELECT FechaInicio, FrecuenciaPago, Plazo, Cuota FROM prestamos WHERE ID = $idPrestamo";
    $result = $conexion->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $fechaInicio = new DateTime($row["FechaInicio"]);
        $frecuenciaPago = $row["FrecuenciaPago"];
        $plazo = $row["Plazo"];
        $cuota = $row["Cuota"];

        // Calcular las fechas de pago
        $fechasPago = calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo);

        // Mostrar las fechas de pago en una tabla
        echo "<div class='container'>";
        echo "<h1>Fechas de Pago</h1>";
        echo "<p class='p'>A pagar: $cuota " . " $frecuenciaPago</p>";
        echo "<table>";
        echo "<tr><th>Frecuencia</th><th>Fecha</th></tr>";
        $numeroFecha = 1;
        foreach ($fechasPago as $fecha) {
            $frecuencia = obtenerFrecuencia($frecuenciaPago, $numeroFecha);
            echo "<tr><td>$frecuencia</td><td>" . $fecha->format("Y-m-d") . "</td></tr>";
            $numeroFecha++;
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "ID de préstamo no válido.";
    }
} else {
    echo "ID de préstamo no proporcionado.";
}

// Función para calcular las fechas de pago
function calcularFechasPago($fechaInicio, $frecuenciaPago, $plazo) {
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
function obtenerFrecuencia($frecuenciaPago, $numeroFecha) {
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
 