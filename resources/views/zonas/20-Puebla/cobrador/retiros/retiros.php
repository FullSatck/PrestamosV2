<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../../../controllers/conexion.php");

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <title>Administrador Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/retiros.css">
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <a href="/controllers/cerrar_sesion.php" class="botonn">
            <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
            <span class="spann">Cerrar Sesion</span>
        </a>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/zonas/20-Puebla/cobrador/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

         

            <a href="/resources/views/zonas/20-Puebla/cobrador/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/cobrador/retiros/retiros.php">
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
                    <p>$1.000.000</p>
                </div>
                <div class="saldo-item">
                    <h2>Monto Neto</h2>
                    <p class="p">$2.000</p>
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