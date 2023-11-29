<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../../../controllers/conexion.php");

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

// Consulta SQL para obtener todos los clientes con el nombre de la moneda
$sql = "SELECT c.ID, c.Nombre, c.Apellido, c.Domicilio, c.Telefono, c.HistorialCrediticio, c.ReferenciasPersonales, m.Nombre AS moneda, c.ZonaAsignada 
        FROM clientes c
        LEFT JOIN monedas m ON c.monedaPreferida = m.ID
        WHERE c.ZonaAsignada = 'Quintana Roo'
        ORDER BY c.ID DESC";


$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/lista_clientes.css">
    <title>Listado de Clientes</title>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Supervisor<span>";
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

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/lista_clientes.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Listado de Clientes</h1>

        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>

        <?php if ($resultado->num_rows > 0) { ?>

        <div class="table-scroll-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Domicilio</th>
                    <th>Teléfono</th>
                    <th>Moneda Preferida</th>
                    <th>Zona Asignada</th>
                    <th>Acciones</th>
                    <th>Pagos</th>
                </tr>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?= "REC 100" .$fila["ID"] ?></td>
                    <td><?= $fila["Nombre"] ?></td>
                    <td><?= $fila["Apellido"] ?></td>
                    <td><?= $fila["Domicilio"] ?></td>
                    <td><?= $fila["Telefono"] ?></td>
                    <td><?= $fila["moneda"] ?></td> <!-- Mostrar el nombre de la moneda -->
                    <td><?= $fila["ZonaAsignada"] ?></td>
                    <td><a href="../../../../../../controllers/perfil_cliente.php?id=<?= $fila["ID"] ?>">Perfil</a></td>
                    <td><a
                            href="/resources/views/zonas/22-QuintanaRoo/supervisor/abonos/crud_historial_pagos.php?clienteId=<?= $fila["ID"] ?>">pagos</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <p>No se encontraron clientes en la base de datos.</p>
            <?php } ?>
        </div>
    </main>

    <script>
    // JavaScript para la búsqueda en tiempo real
    const searchInput = document.getElementById('search-input');
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        rows.forEach((row) => {
            const rowData = Array.from(row.children)
                .map((cell) => cell.textContent.toLowerCase())
                .join('');

            if (rowData.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>

    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>