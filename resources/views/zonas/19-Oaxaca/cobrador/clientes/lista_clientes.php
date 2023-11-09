<?php
session_start(); // Asegura que la sesión está iniciada

// Incluye el archivo de conexión a la base de datos
include('../../../../conexion.php'); // Asegúrate de que este sea el camino correcto al archivo de conexión

// Comprueba si el usuario está logueado y si tiene el rol adecuado
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] != 'cobrador' && $_SESSION['rol'] != 'supervisor')) {
    header('Location: login.php'); // Redirige al login si el usuario no está logueado o no tiene el rol adecuado
    exit();
}

// Obtiene la zona asignada al usuario desde la sesión
$zonaAsignada = $_SESSION['zona'];

// Prepara la consulta SQL para obtener los clientes de la zona asignada
$stmt = $conexion->prepare("SELECT * FROM clientes WHERE ZonaAsignada = ?");
$stmt->bind_param("i", $zonaAsignada); // 'i' indica que el parámetro es de tipo entero
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Clientes</title>

    <link rel="stylesheet" href="/public/assets/css/lista_clientes.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
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

            <a href="/resources/views/admin/clientes/lista_clientes.php" class="selected">
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

<h1>Listado de Clientes</h1>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Domicilio</th>
                <th>Teléfono</th>
                <th>Referencias Personales</th>
                <th>Moneda Preferida</th>
                <th>Zona Asignada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cliente = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['ID']) ?></td>
                <td><?= htmlspecialchars($cliente['Nombre']) ?></td>
                <td><?= htmlspecialchars($cliente['Apellido']) ?></td>
                <td><?= htmlspecialchars($cliente['Domicilio']) ?></td>
                <td><?= htmlspecialchars($cliente['Telefono']) ?></td>
                <td><?= htmlspecialchars($cliente['Referencias']) ?></td>
                <td><?= htmlspecialchars($cliente['MonedaPreferida']) ?></td>
                <td><?= htmlspecialchars($cliente['ZonaAsignada']) ?></td>
                <td>
                    <!-- Agregar aquí enlaces o botones para realizar acciones sobre cada cliente -->
                    <a href="perfil_cliente.php?id=<?= $cliente['ID'] ?>">Perfil</a>
                    <a href="editar_cliente.php?id=<?= $cliente['ID'] ?>">Editar</a>
                  
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No se encontraron clientes en su zona.</p>
<?php endif; ?>

</body>
</html>

<?php
// Cerrar la declaración y la conexión a la base de datos.
$stmt->close();
$conexion->close();
?>
