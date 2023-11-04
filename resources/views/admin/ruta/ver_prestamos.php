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


// Obtener el nombre de la zona desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Conectar a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener los préstamos de la zona especificada con el nombre del cliente
$sql = $conexion->prepare("SELECT P.ID, C.Nombre AS NombreCliente, P.Zona, P.Monto FROM prestamos P INNER JOIN clientes C ON P.IDCliente = C.ID WHERE P.Zona = ?");
$sql->bind_param("s", $nombreZona);
$sql->execute();

// Verificar si la consulta se realizó con éxito
if ($sql === false) {
    die("Error en la consulta SQL: " . $conexion->error);
}
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script> 
    <title>Listado de Préstamos</title>
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

        <a href="/resources/views/admin/inicio/inicio.php">
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

        <a href="/resources/views/admin/ruta/lista_super.php" class="selected">
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
        <h1 class="text-center">Listado de Prestamos en Zona: <?= $nombreZona ?></h1>

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-9">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID del Préstamo</th>
                                <th scope="col">Nombre del Cliente</th>
                                <th scope="col">Zona</th>
                                <th scope="col">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $result = $sql->get_result();
                    $rowCount = 0; // Contador de filas
                    while ($datos = $result->fetch_assoc()) { 
                        $rowCount++; // Incrementar el contador de filas
                        ?>
                            <tr class="row<?= $rowCount ?>">
                                <td><?= "Prestamo " . $datos['ID'] ?></td>
                                <td><?= $datos['NombreCliente'] ?></td>
                                <td><?= $datos['Zona'] ?></td>
                                <td><?= $datos['Monto'] ?></td>
                            </tr>
                            <?php } 
                    // Cerrar la consulta y la conexión a la base de datos
                    $sql->close();
                    $conexion->close();
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
    // Agregar un evento clic al botón
    document.getElementById("volverAtras").addEventListener("click", function() {
        window.history.back();
    });
    </script>
    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>