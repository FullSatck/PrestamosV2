<?php
session_start();
include("../../../../controllers/conexion.php");

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Procesar el formulario de cambio de estado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["usuario_id"]) && isset($_POST["nuevo_estado"])) {
    $usuarioID = $_POST["usuario_id"];
    $nuevoEstado = $_POST["nuevo_estado"];

    // Actualiza el estado en la base de datos
    $updateSQL = $conexion->prepare("UPDATE usuarios SET Estado = ? WHERE ID = ?");
    $updateSQL->bind_param("si", $nuevoEstado, $usuarioID);

    if ($updateSQL->execute()) {
        // Éxito en la actualización, redirige de nuevo a esta página
        header("Location: crudusuarios.php?mensaje=Estado actualizado correctamente.");
        exit();
    } else {
        // Error en la actualización
        $mensaje = "Error al actualizar el estado en la base de datos.";
    }
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

            <a href="/resources/views/admin/abonos/lista_super.php">
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
        <h1>Listado de Usuarios</h1>
        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Zona</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php
            $sql = $conexion->query("SELECT * FROM usuarios");

            if ($sql === false) {
                die("Error en la consulta SQL: " . $conexion->error);
            }

            if ($sql->num_rows > 0) {
                $rowCount = 0;
                while ($datos = $sql->fetch_object()) {
                    $rowCount++;
                    ?>
                    <tr class="row<?= $rowCount ?>">
                        <td><?= "REC 100" . $datos->ID ?></td>
                        <td><?= $datos->Nombre ?></td>
                        <td><?= $datos->Apellido ?></td>
                        <td><?= $datos->Email ?></td>
                        <td><?= $datos->Zona ?></td>
                        <td><?= $datos->RolID ?></td>
                        <td>
                            <form class="estado-form" action="" method="POST">
                                <input type="hidden" name="usuario_id" value="<?= $datos->ID ?>">
                                <select name="nuevo_estado">
                                    <option value="Activo" <?php if ($datos->Estado == 'Activo') echo 'selected'; ?>>Activo</option>
                                    <option value="Inactivo" <?php if ($datos->Estado == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                                </select>
                                <button type="submit">Cambiar</button>
                            </form>
                        </td>
                        <td>
                            <a href="modificarUser.php?id=<?= $datos->ID ?>">
                                <i class="fas fa-pencil-alt"></i> Modificar
                            </a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                echo "No se encontraron resultados.";
            }
            ?>
        </table>
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