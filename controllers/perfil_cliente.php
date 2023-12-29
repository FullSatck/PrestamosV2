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
    $dias_pago = "/resources/views/admin/inicio/cartulina/dias_pago.php";
} elseif ($_SESSION["rol"] == 2) {
    // Ruta para el rol 2 (supervisor) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/supervisor/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/6-Chihuahua/supervisor/inicio/cartulina/dias_pago.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/supervisor/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/20-Puebla/supervisor/inicio/cartulina/dias_pago.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/cartulina/dias_pago.php";
    } elseif ($_SESSION['user_zone'] === '28') {
        $ruta_volver = "/resources/views/zonas/28-Tlaxcala/supervisor/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/28-Tlaxcala/supervisor/inicio/cartulina/dias_pago.php";
    } else {
        // Si no coincide con ninguna zona válida para supervisor, redirigir a un dashboard predeterminado
        $ruta_volver = "/default_dashboard.php";
    }
} elseif ($_SESSION["rol"] == 3) {
    // Ruta para el rol 3 (cobrador) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/cobrador/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/6-Chihuahua/cobrador/inicio/cartulina/dias_pago.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/cobrador/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/20-Puebla/cobrador/inicio/cartulina/dias_pago.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/cartulina/dias_pago.php";
    } elseif ($_SESSION['user_zone'] === '28') {
        $ruta_volver = "/resources/views/zonas/28-Tlaxcala/cobrador/clientes/lista_clientes.php";
        $dias_pago = "/resources/views/zonas/28-Tlaxcala/cobrador/inicio/cartulina/dias_pago.php";
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>

<body>

    <body id="body">

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
                    <p>Curp: <strong><?= $fila["IdentificacionCURP"] ?></strong></p>
                    <p>Domicilio: <strong><?= $fila["Domicilio"] ?></strong></p>
                    <p>Teléfono: <strong><?= $fila["Telefono"] ?></strong> </p>
                    <p>Moneda Preferida: <strong><?= $fila["MonedaNombre"] ?></strong></p> <!-- Nombre de la moneda -->
                    <p>Estado: <strong><?= $fila["ZonaAsignada"] ?></strong></p>
                    <p>Municipio: <strong><?= $fila["CiudadNombre"] ?></strong></p>
                    <p>Colonia: <strong><?= $fila["asentamiento"] ?></strong></p>
                    
                </div>
            </div>
 
            <!-- Agregar una sección para mostrar los préstamos del cliente -->
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
                            <td><?= "REC 100" . $fila_prestamo["ID"] ?></a></td>
                            <td><?= $fila_prestamo["MontoAPagar"] ?></td> 
                            <td><?= $fila_prestamo["Plazo"] ?></td> 
                            <td><?= $fila_prestamo["FechaInicio"] ?></td>
                            <td><?= $fila_prestamo["FechaVencimiento"] ?></td>
                            <td><?= $fila_prestamo["Estado"] ?></td>
                            <td><a href="<?= $dias_pago ?>?id=<?= $id_cliente ?>">Pagos</a></td>
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
    </body>

</html>