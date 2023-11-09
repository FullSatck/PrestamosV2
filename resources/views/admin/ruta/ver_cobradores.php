<?php
session_start();

// Validacion de rol para ingresar a la pagina 
require_once '../../../../controllers/conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
} else {
    // El usuario está autenticado, obtén el ID del usuario de la sesión
    $usuario_id = $_SESSION["usuario_id"];
    
    // Preparar la consulta para obtener el rol del usuario
    $stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
    $stmt->bind_param("i", $usuario_id);
    
    // Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    // Verifica si el resultado es nulo, lo que significaría que el usuario no tiene un rol válido
    if (!$fila) {
        // Redirige al usuario a una página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }

    // Extrae el nombre del rol del resultado
    $rol_usuario = $fila['Nombre'];
    
    // Verifica si el rol del usuario corresponde al necesario para esta página
    if ($rol_usuario !== 'admin') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
    
   
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Obtener el nombre de la zona desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];

    // Conectar a la base de datos
    include("../../../../controllers/conexion.php");

    // Consulta para obtener los usuarios con rol 2 (supervisores) en la zona especificada
    $sql = $conexion->prepare("SELECT U.ID, U.Nombre, U.Apellido, U.Email, Zonas.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios U JOIN Roles ON U.RolID = Roles.ID JOIN Zonas ON U.Zona = Zonas.ID WHERE U.RolID = 3 AND Zonas.Nombre = ?");
    $sql->bind_param("s", $nombreZona);
    $sql->execute();
    $result = $sql->get_result();

    // Verificar si se encontraron supervisores en la zona
    $supervisoresEnZona = $result->num_rows > 0;
} else {
    // Si no se proporciona un nombre de zona válido, establecer $supervisoresEnZona en falso
    $supervisoresEnZona = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/vercobradores.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script> 
    <title>Zona: <?= $nombreZona ?></title>
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
            <h1 class="text-center">Listado de Cobradores en Zona: <?= $nombreZona ?></h1>

            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-9">
                        <?php
            if ($supervisoresEnZona) {
                // Mostrar la tabla solo si hay supervisores en la zona
                ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                        while ($datos = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= "REC 100" . $datos['ID'] ?></td>
                                    <td><?= $datos['Nombre'] ?></td>
                                    <td><?= $datos['Apellido'] ?></td>
                                    <td><?= $datos['Email'] ?></td>
                                    <td><?= $datos['Rol'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php
            } else {
                // Mostrar un mensaje si no se encontraron supervisores en la zona
                echo "No se encontraron supervisores para la zona: " . $nombreZona;
            }
            ?>
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







































<!DOCTYPE html>
<html lang="en">

<body>
    <!-- Botón para volver a la página anterior -->

</body>

</html>