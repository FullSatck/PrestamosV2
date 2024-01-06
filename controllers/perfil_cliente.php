<?php
date_default_timezone_set('America/Bogota');
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

$usuario_id = $_SESSION["usuario_id"];

// Asumiendo que la tabla de roles se llama 'roles' y tiene las columnas 'id' y 'nombre_rol'
$sql_nombre = "SELECT usuarios.nombre, roles.nombre FROM usuarios INNER JOIN roles ON usuarios.rolID = roles.id WHERE usuarios.id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
    $_SESSION["nombre"] = $fila["nombre"]; // Guarda el nombre del rol en la sesión
}
$stmt->close();

// Obtener el ID del cliente desde el parámetro GET
$id_cliente = $_GET['id'];

// Consulta SQL para obtener los detalles del cliente con el nombre de la moneda
$sql = "SELECT c.*, m.Nombre AS MonedaNombre, ciu.Nombre AS CiudadNombre
            FROM clientes c
            LEFT JOIN monedas m ON c.MonedaPreferida = m.ID
            LEFT JOIN ciudades ciu ON c.ciudad = ciu.ID
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

// Obtener la zona y rol del usuario desde la sesión
$user_zone = $_SESSION['user_zone'];
$user_role = $_SESSION['rol'];

// Si el rol es 1 (administrador)
if ($_SESSION["rol"] == 1) {
    $ruta_volver = "/resources/views/admin/clientes/lista_clientes.php";
} elseif ($_SESSION["rol"] == 2) {
    // Ruta para el rol 2 (supervisor) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/supervisor/clientes/lista_clientes.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/supervisor/clientes/lista_clientes.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/lista_clientes.php";
    } else {
        // Si no coincide con ninguna zona válida para supervisor, redirigir a un dashboard predeterminado
        $ruta_volver = "/default_dashboard.php";
    }
} elseif ($_SESSION["rol"] == 3) {
    // Ruta para el rol 3 (cobrador) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/cobrador/clientes/lista_clientes.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/cobrador/clientes/lista_clientes.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/lista_clientes.php";
    } else {
        // Si no coincide con ninguna zona válida para cobrador, redirigir a un dashboard predeterminado
        $ruta_volver = "/default_dashboard.php";
    }
} else {
    // Si no hay un rol válido, redirigir a una página predeterminada
    $ruta_volver = "/default_dashboard.php";
}

// Consulta SQL para obtener los préstamos del cliente
$sql_prestamos = "SELECT * FROM prestamos WHERE IDCliente = $id_cliente";
$resultado_prestamos = $conexion->query($sql_prestamos);

// Obtener clientes que han pasado ciertos días hábiles sin pagar una cuota
$diasHabilesSinPagar = 15;
$fechaLimite = date('Y-m-d', strtotime("-$diasHabilesSinPagar weekdays"));
$query = "SELECT p.IDCliente, p.ID, p.MontoCuota, MIN(p.FechaInicio) AS FechaInicio
          FROM prestamos p
          WHERE p.Estado = 'pendiente' AND p.FechaVencimiento <= '$fechaLimite'
          GROUP BY p.ID";
$result = $conexion->query($query);

$diasSinPagar = 0;
$esClavo = 'No';

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Calcular la fecha límite para la última cuota
        $fechaInicio = isset($row['FechaInicio']) ? $row['FechaInicio'] : date('Y-m-d');
        $fechaLimiteCuota = date('Y-m-d', strtotime("+10 weekdays", strtotime($fechaInicio)));

        // Verificar si ha pasado el plazo establecido desde la fecha de vencimiento
        if ($fechaLimiteCuota <= $fechaLimite) {
            // Mover cliente a la tabla de clientes clavos
            $clienteID = $row['IDCliente'];
            $updateQuery = "UPDATE clientes SET EstadoID = 2 WHERE ID = $clienteID";
            $conexion->query($updateQuery);

            // Actualizar información en la tabla prestamos
            $prestamoID = $row['ID'];
            $updatePrestamoQuery = "UPDATE prestamos SET CuotasVencidas = CuotasVencidas + 1 WHERE ID = $prestamoID";
            $conexion->query($updatePrestamoQuery);

            // Incrementar el contador de días sin pagar
            $diasSinPagar++;
        }
    }
}

// Verificar y actualizar el estado de los clientes en la lista de clavos
$clavosQuery = "SELECT p.ID AS PrestamoID, p.IDCliente
                FROM prestamos p
                WHERE p.Estado = 'clavo'"; // Asumiendo que 'clavo' es un estado en la tabla prestamos

$clavosResult = $conexion->query($clavosQuery);

if ($clavosResult) {
    while ($clavoRow = $clavosResult->fetch_assoc()) {
        $prestamoID = $clavoRow['PrestamoID'];
        $clienteID = $clavoRow['IDCliente'];

        // Verificar si el cliente ha realizado el pago de la cuota pendiente
        $pagoQuery = "SELECT SUM(MontoPagado) AS TotalPagado
                      FROM historial_pagos
                      WHERE IDPrestamo = $prestamoID AND FechaPago >= '$fechaLimite'";
        $pagoResult = $conexion->query($pagoQuery);
        $pagoRow = $pagoResult->fetch_assoc();

        // Obtener el monto total de la cuota pendiente
        $montoCuotaQuery = "SELECT MontoCuota FROM prestamos WHERE ID = $prestamoID";
        $montoCuotaResult = $conexion->query($montoCuotaQuery);
        $montoCuotaRow = $montoCuotaResult->fetch_assoc();
        $montoCuota = $montoCuotaRow['MontoCuota'];

        if ($pagoRow['TotalPagado'] >= $montoCuota) {
            // El cliente ha pagado, actualizar su estado para sacarlo de la lista de clavos
            $updatePrestamoQuery = "UPDATE prestamos SET Estado = 'activo' WHERE ID = $prestamoID"; // Asumiendo que 'activo' es el estado normal
            $conexion->query($updatePrestamoQuery);
        } else {
            // Si el cliente sigue siendo un clavo, actualizar la variable $esClavo
            $esClavo = 'Sí';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/perfil_cliente.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <title>Perfil del Cliente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body>

    <header>
        <a href="<?= $ruta_volver ?>" class="back-link">Volver</a>
        <div class="nombre-usuario">
            <?php
                if (isset($_SESSION["nombre_usuario"], $_SESSION["nombre"])) {
                    echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span>" . htmlspecialchars($_SESSION["nombre"]) . "</span>";
                }
            ?>
        </div>
    </header>

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
                <p>Curp: <strong><?= $fila["IdentificacionCURP"] ?></strong></p>
                <p>Domicilio: <strong><?= $fila["Domicilio"] ?></strong></p>
                <p>Teléfono: <strong><?= $fila["Telefono"] ?></strong> </p>
                <p>Moneda Preferida: <strong><?= $fila["MonedaNombre"] ?></strong></p>
                <p>Estado: <strong><?= $fila["ZonaAsignada"] ?></strong></p>
                <p>Municipio: <strong><?= $fila["CiudadNombre"] ?></strong></p>
                <p>Colonia: <strong><?= $fila["asentamiento"] ?></strong></p>
                <!-- Nuevas secciones agregadas -->
                <p>Días sin Pagar: <?= $diasSinPagar ?></p>
                <p>Clavo: <?= $esClavo ?></p>
            </div>
        </div>

        <!-- Sección para mostrar los préstamos del cliente -->
        <div class="profile-loans">
            <h2>Préstamos del Cliente</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID del Préstamo</th>
                        <th>Deuda</th>
                        <th>Plazo</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Estado</th>
                        <th>Pagos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila_prestamo = $resultado_prestamos->fetch_assoc()) : ?>
                        <tr>
                            <td><?= "REC 100" . $fila_prestamo["ID"] ?></td>
                            <td><?= $fila_prestamo["MontoAPagar"] ?></td>
                            <td><?= $fila_prestamo["Plazo"] ?></td>
                            <td><?= $fila_prestamo["FechaInicio"] ?></td>
                            <td><?= $fila_prestamo["FechaVencimiento"] ?></td>
                            <td><?= $fila_prestamo["Estado"] ?></td>
                            <td><a href="dias_pago.php?id=<?= $id_cliente ?>">Pagos</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </main>

    <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function () {
            window.history.back();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileImage = document.querySelector('.profile-image img');

            // Agrega un controlador de eventos para hacer clic en la imagen
            profileImage.addEventListener('click', function () {
                profileImage.classList.toggle('zoomed'); // Alterna la clase 'zoomed'
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
</body>
</html>
