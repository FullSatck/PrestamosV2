<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../../../index.php");
    exit();
}

include("../../../../../../controllers/conexion.php");

$usuarioId = $_SESSION["usuario_id"];
$saldoInicialUsuario = 0;
$saldoNeto = 0;
$zonaUsuario = '';
$usuariosRolTres = [];

// Preparar la consulta para obtener la zona del usuario y el saldo inicial en una sola llamada
$sqlUsuarioInfo = "SELECT u.Zona, (SELECT Monto FROM retiros WHERE IDUsuario = u.ID LIMIT 1) AS Monto
                   FROM usuarios u WHERE u.ID = ?";
$stmtUsuarioInfo = $conexion->prepare($sqlUsuarioInfo);
$stmtUsuarioInfo->bind_param("i", $usuarioId);
$stmtUsuarioInfo->execute();
$resultadoUsuarioInfo = $stmtUsuarioInfo->get_result();

if ($filaUsuarioInfo = $resultadoUsuarioInfo->fetch_assoc()) {
    $zonaUsuario = $filaUsuarioInfo['Zona'];
    $saldoInicialUsuario = $filaUsuarioInfo['Monto'];
}

// Calcular el saldo neto restando todos los retiros de usuarios de la misma zona
$sqlSaldoNeto = "SELECT (SELECT SUM(Monto) FROM retiros WHERE IDUsuario IN 
                  (SELECT ID FROM usuarios WHERE Zona = ?)) AS TotalRetiros";
$stmtSaldoNeto = $conexion->prepare($sqlSaldoNeto);
$stmtSaldoNeto->bind_param("s", $zonaUsuario);
$stmtSaldoNeto->execute();
$resultadoSaldoNeto = $stmtSaldoNeto->get_result();

if ($filaSaldoNeto = $resultadoSaldoNeto->fetch_assoc()) {
    $totalRetiros = $filaSaldoNeto['TotalRetiros'];
    $saldoNeto = $saldoInicialUsuario - $totalRetiros;
}

// Obtener usuarios con rol 3 de la misma zona y su monto de retiros
$sqlUsuariosRolTres = "SELECT u.ID, u.Nombre, (SELECT SUM(Monto) FROM retiros WHERE IDUsuario = u.ID) AS MontoRetiros
                       FROM usuarios u
                       WHERE u.Zona = ? AND u.RolID = '3'";
$stmtUsuariosRolTres = $conexion->prepare($sqlUsuariosRolTres);
$stmtUsuariosRolTres->bind_param("s", $zonaUsuario);
$stmtUsuariosRolTres->execute();
$resultadoUsuariosRolTres = $stmtUsuariosRolTres->get_result();

while ($filaUsuarioRolTres = $resultadoUsuariosRolTres->fetch_assoc()) {
    array_push($usuariosRolTres, $filaUsuarioRolTres);
}

// Cierra los statements y la conexión una sola vez al final
$stmtUsuarioInfo->close();
$stmtSaldoNeto->close();
$stmtUsuariosRolTres->close();
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
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/retiros/retiros.php" class="selected">
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
            <h1>Retiros</h1>
            <div class="saldo-box">
                <div class="saldo-item">
                    <h2>Saldo Inicial</h2>
                    <p>$<?php echo number_format($saldoInicialUsuario, 0, '.', '.'); ?></p>
                </div>

                <div class="saldo-item">
                    <h2>Monto Neto</h2>
                    <p class="p">$<?php echo number_format($saldoNeto, 0, '.', '.'); ?></p>
                </div>

            </div>


            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Monto Retiros</th>
                </tr>
                <?php foreach ($usuariosRolTres as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['ID']; ?></td>
                    <td><?php echo $usuario['Nombre']; ?></td>
                    <td>$<?php echo number_format($usuario['MontoRetiros'], 0, '.', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

        </main>

    </main>

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