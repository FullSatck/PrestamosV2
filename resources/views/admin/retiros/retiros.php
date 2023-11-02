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


// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener el saldo inicial y el saldo neto del administrador
$sqlSaldoAdmin = "SELECT Monto, Monto_Neto FROM saldo_admin LIMIT 1";
$resultadoSaldoAdmin = $conexion->query($sqlSaldoAdmin);
$saldoAdmin = 0; // Valor por defecto si no se encuentra el saldo
$montoNetoAdmin = 0; // Valor por defecto si no se encuentra el saldo neto

if ($resultadoSaldoAdmin && $resultadoSaldoAdmin->num_rows > 0) {
    $filaSaldoAdmin = $resultadoSaldoAdmin->fetch_assoc();
    $saldoAdmin = $filaSaldoAdmin['Monto'];
    $montoNetoAdmin = $filaSaldoAdmin['Monto_Neto'];
}

// Consulta SQL para obtener la lista de retiros con nombre de usuario, zona y monto
$sqlRetiros = "SELECT u.Nombre AS UsuarioNombre, u.Zona, r.Monto
              FROM retiros AS r
              INNER JOIN usuarios AS u ON r.IDUsuario = u.ID";

$resultadoRetiros = $conexion->query($sqlRetiros);

// Calcular el monto total de los retiros
$sqlMontoTotalRetiros = "SELECT SUM(Monto) AS MontoTotal FROM retiros";
$resultadoMontoTotalRetiros = $conexion->query($sqlMontoTotalRetiros);
$montoTotalRetiros = 0;

if ($resultadoMontoTotalRetiros && $resultadoMontoTotalRetiros->num_rows > 0) {
    $filaMontoTotalRetiros = $resultadoMontoTotalRetiros->fetch_assoc();
    $montoTotalRetiros = $filaMontoTotalRetiros['MontoTotal'];
}

// Calcular el saldo total
$saldoTotal = $montoNetoAdmin - $montoTotalRetiros;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/retiros.css">
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
                    <h4>Saldo Incial</h4>
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
    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>






















<!DOCTYPE html>
<html>

<head>

</head>

<body>

</body>

</html>