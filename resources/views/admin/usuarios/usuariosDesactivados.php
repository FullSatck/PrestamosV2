<?php
date_default_timezone_set('America/Bogota');
session_start();
include("../../../../controllers/conexion.php");



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
// Consulta para obtener la lista de usuarios
$usuariosSQL = $conexion->query("SELECT * FROM usuarios WHERE estado = 'inactivo'");

if ($usuariosSQL === false) {
    die("Error en la consulta SQL: " . $conexion->error);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Usuarios</title>
    <link rel="stylesheet" href="/public/assets/css/lista_usuarios.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Administrator<span>";
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

            <a href="/resources/views/admin/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/crudusuarios.php" class="selected">
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
            <a href="/resources/views/admin/cobros/cobros.php">
                <div class="option">
                    <i class="fa-solid fa-arrow-right-to-city" title=""></i>
                    <h4>Zonas de cobro</h4>
                </div>
            </a>

            <a href="/resources/views/admin/gastos/gastos.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/admin/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>

            <a href="/resources/views/admin/cartera/lista_cartera.php">
                <div class="option">
                <i class="fa-solid fa-basket-shopping"></i> 
                    <h4>Cobros</h4>
                </div>
            </a>

        </div>

    </div>

    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Usuarios Desactivados</h1>





        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
            <button><a href="crudusuarios.php" class="btn btn-primary">Activados</a></button>
        </div>
        <div class="table-scroll-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Zona</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th></th>
                    <th>Modificar</th>
                    <th>Des/Act</th>
                </tr>
                <?php
                if ($usuariosSQL->num_rows > 0) {
                    while ($datos = $usuariosSQL->fetch_object()) {
                ?>
                        <tr>
                            <td><?= "REC 100" . $datos->ID ?></td>
                            <td><?= $datos->Nombre ?></td>
                            <td><?= $datos->Apellido ?></td>
                            <td><?= $datos->Email ?></td>
                            <td><?= $datos->Zona ?></td>
                            <td><?= $datos->RolID ?></td>
                            <td><?= $datos->Estado ?></td>

                            <td>

                            <td>
                                <a href="modificarUser.php?id=<?= $datos->ID ?>">
                                    <i class="fas fa-pencil-alt"></i> Modificar
                                </a>

                            </td>
                            <td>
                                <!-- Enlace para cambiar el estado -->
                                <a href="cambiarEstado.php?id=<?= $datos->ID ?>&estado=<?= $datos->Estado ?>&vista=inactivos">
                                    <i class="fas <?= $datos->Estado == 'activo' ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                                    <?= $datos->Estado == 'activo' ? 'Desactivar' : 'Activar' ?>
                                </a>
                            <td>

                        </tr>
                <?php
                    }
                } else {
                    echo "No se encontraron resultados.";
                }
                ?>
            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>