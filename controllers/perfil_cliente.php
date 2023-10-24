<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/perfil_cliente.css">
    <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Perfil del Cliente</title>
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
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Dark Mode</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">

                        </div>
                    </div>
                </div>
            </div>
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>
