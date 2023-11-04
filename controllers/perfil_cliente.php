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

// Verificar si se ha pasado un ID válido como parámetro GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirigir a una página de error o a la lista de clientes
    header("location: dias_pagos.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Obtener el ID del cliente desde el parámetro GET
$id_cliente = $_GET['id'];

// Consulta SQL para obtener los detalles del cliente con el nombre de la moneda
$sql = "SELECT c.*, m.Nombre AS MonedaNombre 
        FROM clientes c
        LEFT JOIN monedas m ON c.MonedaPreferida = m.ID
        WHERE c.ID = $id_cliente";

$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    // Mostrar los detalles del cliente aquí
    $fila = $resultado->fetch_assoc();
    
    // Obtener la ruta de la imagen del cliente desde la base de datos
    $imagen_cliente = $fila["ImagenCliente"];
    
    // Si no hay imagen cargada, usar una imagen de reemplazo
    if (empty($imagen_cliente)) {
        $imagen_cliente = "../public/assets/img/perfil.png"; // Reemplaza con tu imagen por defecto
    }
} else {
    // Cliente no encontrado en la base de datos, redirigir a una página de error o a la lista de clientes
    header("location: ../resources/views/admin/clientes/lista_clientes.php");
    exit();
}

// Consulta SQL para obtener los préstamos del cliente
$sql_prestamos = "SELECT * FROM prestamos WHERE IDCliente = $id_cliente";
$resultado_prestamos = $conexion->query($sql_prestamos);
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/perfil_cliente.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Perfil del Cliente</title>
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

        <a href="/resources/views/admin/inicio/inicio.php" class="selected">
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

        <a href="/resources/views/admin/ruta/lista_super.php">
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
        <div class="profile-container">
            <div class="profile-image"><br><br><br>
                <!-- Mostrar la foto del cliente -->
                <img src="<?= $imagen_cliente ?>" alt="Foto del Cliente">
            </div>
            <div class="profile-details">
                <!-- Mostrar los datos del cliente -->
                <h1><strong><?= $fila["Nombre"] ?></strong></h1>
                <p>Apellido: <strong><?= $fila["Apellido"] ?></strong></p>
                <p>Domicilio: <strong><?= $fila["Domicilio"] ?></strong></p>
                <p>Teléfono: <strong><?= $fila["Telefono"] ?></strong> </p>
                <p>Historial Crediticio: <strong><?= $fila["HistorialCrediticio"] ?></strong> </p>
                <p>Referencias Personales: <strong><?= $fila["ReferenciasPersonales"] ?></strong> </p>
                <p>Moneda Preferida: <strong><?= $fila["MonedaNombre"] ?></strong></p> <!-- Nombre de la moneda -->
                <p>Zona Asignada: <strong><?= $fila["ZonaAsignada"] ?></strong></p>
            </div>
        </div>

        <!-- Agregar una sección para mostrar los préstamos del cliente -->
        <div class="profile-loans">
            <h2>Préstamos del Cliente</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID del Préstamo</th>
                        <th>Monto</th>
                        <th>Tasa de Interés</th>
                        <th>Plazo</th>
                        <th>Frecuencia de Pago</th> <!-- Agregar Frecuencia de Pago -->
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Estado</th>
                        <th>Pagos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila_prestamo = $resultado_prestamos->fetch_assoc()) : ?>
                    <tr>
                        <td><?= "REC 100" . $fila_prestamo["ID"] ?></a></td>
                        <td><?= $fila_prestamo["Monto"] ?></td>
                        <td><?= $fila_prestamo["TasaInteres"] ?></td>
                        <td><?= $fila_prestamo["Plazo"] ?></td>
                        <td><?= $fila_prestamo["FrecuenciaPago"] ?></td> <!-- Mostrar Frecuencia de Pago -->
                        <td><?= $fila_prestamo["FechaInicio"] ?></td>
                        <td><?= $fila_prestamo["FechaVencimiento"] ?></td>
                        <td><?= $fila_prestamo["Estado"] ?></td>
                        <td><a href="dias_pago.php?id=<?= $fila_prestamo["ID"]; ?>">Pagos</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function() {
            window.history.back();
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileImage = document.querySelector('.profile-image img');

        // Agrega un controlador de eventos para hacer clic en la imagen
        profileImage.addEventListener('click', function() {
            profileImage.classList.toggle('zoomed'); // Alterna la clase 'zoomed'
        });
    });
    </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
     <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>
