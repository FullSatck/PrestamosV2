<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Obtener el saldo neto del administrador
$sqlSaldoNetoAdmin = "SELECT Monto, Monto_Neto FROM saldo_admin WHERE IDUsuario = '1' LIMIT 1";
$resultadoSaldoNetoAdmin = $conexion->query($sqlSaldoNetoAdmin);
$saldoNetoAdmin = 0;

if ($resultadoSaldoNetoAdmin && $resultadoSaldoNetoAdmin->num_rows > 0) {
    $filaSaldoNetoAdmin = $resultadoSaldoNetoAdmin->fetch_assoc();
    $saldoNetoAdmin = $filaSaldoNetoAdmin['Monto_Neto'];
}

// Consulta SQL para obtener la lista de retiros con nombre de usuario, zona y monto
$sqlRetiros = "SELECT r.ID AS RetiroID, u.Nombre AS UsuarioNombre, u.Zona, r.Monto
                FROM retiros AS r
                INNER JOIN usuarios AS u ON r.IDUsuario = u.ID";
$resultadoRetiros = $conexion->query($sqlRetiros);

// Iniciar transacción para actualizar el saldo neto del administrador
$conexion->begin_transaction();

try {
    // Restar el monto asignado al supervisor del saldo neto del administrador
    // y actualizar el saldo neto en la base de datos
    while ($filaRetiro = $resultadoRetiros->fetch_assoc()) {
        $saldoNetoAdmin -= $filaRetiro['Monto'];

        // Actualizar el saldo neto en la base de datos para cada retiro
        $sqlActualizarSaldoNeto = "UPDATE saldo_admin SET Monto_Neto = ? WHERE IDUsuario = '1'";
        $stmtActualizarSaldoNeto = $conexion->prepare($sqlActualizarSaldoNeto);
        $stmtActualizarSaldoNeto->bind_param("d", $saldoNetoAdmin);
        $stmtActualizarSaldoNeto->execute();
    }
    // Si todo fue bien, confirma los cambios
    $conexion->commit();
} catch (Exception $e) {
    // Si algo salió mal, revierte la transacción
    $conexion->rollback();
    echo "Error al actualizar los saldos: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conexion->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/retiros.css">
</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-circle-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="cloudy-outline"></ion-icon>
                <span>Recaudo</span>
            </div>
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
                    <a href="/resources/views/admin/retiros/retiros.php" class="hola">
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
        <main>
            <h1>Lista de Retiros</h1>
            <div class="saldo-box">
                <div class="saldo-item">
                    <h2>Saldo Inicial</h2>
                    <p>$<?php echo $saldoAdmin; ?></p>
                </div>
                <div class="saldo-item">
                    <h2>Monto Neto</h2>
                    <p class="p">$<?php echo $montoNetoAdmin; ?></p>
                </div>
            </div>
            <table>

                <div class="search-container">
                    <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
                </div>
                <tr>
                    <th>Nombre del Usuario</th>
                    <th>Zona</th>
                    <th>Monto</th>
                </tr>
                <?php
if ($resultadoRetiros) {
  while ($fila = $resultadoRetiros->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila['UsuarioNombre'] . "</td>";
    echo "<td>" . $fila['Zona'] . "</td>";
    echo "<td>" . number_format($fila['Monto'], 0, '.', '.') . "</td>"; // Formatear el monto
    echo "</tr>";
  }
} else {
  echo "Error en la consulta de retiros: " . $conexion->error;
}
?>

            </table>
        </main>

    </main>

    <script>
    function buscarRetiros() {
        var input = document.getElementById("busqueda");
        var filtro = input.value.toLowerCase();
        var tabla = document.querySelector("table");
        var filas = tabla.getElementsByTagName("tr");

        for (var i = 1; i < filas.length; i++) { // Empezamos desde 1 para omitir la fila de encabezados
            var celdas = filas[i].getElementsByTagName("td");
            var filaCoincide = false;

            for (var j = 0; j < celdas.length; j++) {
                var celda = celdas[j];
                if (celda) {
                    var textoCelda = celda.textContent || celda.innerText;
                    if (textoCelda.toLowerCase().indexOf(filtro) > -1) {
                        filaCoincide = true;
                        break;
                    }
                }
            }

            if (filaCoincide) {
                filas[i].style.display = "";
            } else {
                filas[i].style.display = "none";
            }
        }
    }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>






















<!DOCTYPE html>
<html>

<head>

</head>

<body>

</body>

</html>