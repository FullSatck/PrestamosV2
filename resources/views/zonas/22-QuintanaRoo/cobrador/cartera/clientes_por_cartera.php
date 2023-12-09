<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../../../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
require_once '../../../../../../controllers/conexion.php';

// El usuario está autenticado, obtén el ID del usuario de la sesión
$usuario_id = $_SESSION["usuario_id"];

$sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();

// Preparar la consulta para obtener el rol del usuario
$stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
$stmt->bind_param("i", $usuario_id);

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();

$stmt->close();

// Verifica si el resultado es nulo o si el rol del usuario no es 'admin'
if (!$fila || $fila['Nombre'] !== 'cobrador') {
    header("Location: ../../../../../../error404.html");
    exit();
}

// Obtener el ID de la cartera desde el parámetro GET
if (isset($_GET['id'])) {
    $cartera_id = $_GET['id'];

    // Consulta SQL para obtener los clientes de una cartera específica
    $sql = "SELECT * FROM clientes WHERE cartera_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $cartera_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si no se proporciona un ID de cartera, redirigir o manejar el caso según sea necesario
    // Por ejemplo, redirigir a una página de error o a la lista de carteras
    header("Location: /ruta_a_pagina_de_error_o_lista_de_carteras.php");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <title>Clientes por Carteras</title>
</head>

<body>

    <body id="body">

        <header>
            <div class="icon__menu">
                <i class="fas fa-bars" id="btn_open"></i>
            </div>
            <a href="javascript:history.back()" class="back-link">Volver Atrás</a>

            <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Cobrador<span>";
        }
        ?>
        </div>
        </header>

        <div class="menu__side" id="menu_side">

            <div class="name__page">
                <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
                <h4>Recaudo</h4>
            </div>

            <div class="options__menu">

            <a href="/controllers/cerrar_sesion.php">
                <div class="option">
                    <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
                    <h4>Cerrar Sesion</h4>
                </div>
            </a>

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/inicio.php" class="selected">
                    <div class="option">
                        <i class="fa-solid fa-landmark" title="Inicio"></i>
                        <h4>Inicio</h4>
                    </div>
                </a>



                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/lista_clientes.php">
                    <div class="option">
                        <i class="fa-solid fa-people-group" title=""></i>
                        <h4>Clientes</h4>
                    </div>
                </a>

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/agregar_clientes.php">
                    <div class="option">
                        <i class="fa-solid fa-user-tag" title=""></i>
                        <h4>Registrar Clientes</h4>
                    </div>
                </a>

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/creditos/crudPrestamos.php">
                    <div class="option">
                        <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                        <h4>Prestamos</h4>
                    </div>
                </a> 

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/gastos/gastos.php">
                    <div class="option">
                        <i class="fa-solid fa-sack-xmark" title=""></i>
                        <h4>Gastos</h4>
                    </div>
                </a>

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/ruta/ruta.php">
                    <div class="option">
                        <i class="fa-solid fa-map" title=""></i>
                        <h4>Enrutada</h4>
                    </div>
                </a>

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/cartera/lista_cartera.php" class="selected">
                    <div class="option">
                        <i class="fa-regular fa-address-book"></i>
                        <h4>Cobros</h4>
                    </div>
                </a>

                <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/abonos/abonos.php">
                    <div class="option">
                        <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                        <h4>Abonos</h4>
                    </div>
                </a>

            </div>
        </div>


        <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

        <main>
            <!-- Botón para volver a la página anterior -->
            <h1>Clientes por Cartera</h1>

            <table>
                <!-- Encabezados de tabla para los datos de los clientes -->
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <!-- Otros encabezados necesarios -->
                </tr>

                <!-- Mostrar los datos de los clientes en la tabla -->
                <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Nombre"] . "</td>";
                // Puedes mostrar más información de los clientes según sea necesario
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No se encontraron clientes para esta cartera</td></tr>";
        }
        ?>
            </table>

        </main>

        <script src="/public/assets/js/MenuLate.js"></script>
    </body>

    </html>