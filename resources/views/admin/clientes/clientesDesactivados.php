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


// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<?php
// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener todos los clientes con el nombre de la moneda
$sql = "SELECT c.ID, c.Nombre, c.Apellido, c.Domicilio, c.Telefono, c.HistorialCrediticio, c.ReferenciasPersonales, m.Nombre AS Moneda, c.ZonaAsignada, c.Estado FROM Clientes c
        LEFT JOIN Monedas m ON c.MonedaPreferida = m.ID WHERE c.Estado = 0";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Clientes</title>

    <link rel="stylesheet" href="/public/assets/css/lista_clientes.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
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

            <a href="/resources/views/admin/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href=" /resources/views/admin/admin_saldo/saldo_admin.php">
                <div class="option">
                    <i class="fa-solid fa-sack-dollar" title=""></i>
                    <h4>Saldo Incial</h4>
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
        <h1>Clientes Desactivados</h1>



        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
            <button><a href="lista_clientes.php" class="btn btn-primary">Activados</a></button>
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
                    <th>Referencias Personales</th>
                    <th>Moneda Preferida</th>
                    <th>Zona Asignada</th>
                    <th>Estado</th>
                    <th>Des/Act</th>
                    <th>Perfil</th>
                    <th>Pagos</th>
                </tr>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?= "REC 100" .$fila["ID"] ?></td>
                    <td><?= $fila["Nombre"] ?></td>
                    <td><?= $fila["Apellido"] ?></td>
                    <td><?= $fila["Domicilio"] ?></td>
                    <td><?= $fila["Telefono"] ?></td>
                    <td><?= $fila["ReferenciasPersonales"] ?></td>
                    <td><?= $fila["Moneda"] ?></td>
                    <td><?= $fila["ZonaAsignada"] ?></td>
                    <td><?= $fila["Estado"] == 1 ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="cambiarEstadoCliente.php?id=<?= $fila["ID"] ?>&estado=<?= $fila["Estado"] ?>">
                            <i class="fas <?= $fila["Estado"] == 1 ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                            <?= $fila["Estado"] == 1 ? 'Desactivar' : 'Activar' ?>
                        </a>
                    </td>
                    <td><a href="../../../../controllers/perfil_cliente.php?id=<?= $fila["ID"] ?>">Perfil</a></td>
                    <td><a
                            href="/resources/views/admin/abonos/crud_historial_pagos.php?clienteId=<?= $fila["ID"] ?>">pagos</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>