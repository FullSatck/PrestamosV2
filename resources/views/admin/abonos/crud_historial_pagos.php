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

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Verificar si se ha proporcionado el clienteId en la URL
if (isset($_GET['clienteId'])) {
    $clienteId = $_GET['clienteId'];

    // Consulta SQL para obtener las facturas de un cliente específico
    $sql = "SELECT * FROM facturas WHERE cliente_id = $clienteId";
    $resultado = $conexion->query($sql);  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/curdFaturas.css">  
    <title>Historial de Pagos</title>
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
    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Historial de Pagos del Cliente</h1>
        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>

        <table>
            <tr>
                <th>ID de Factura</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Monto Pagado</th>
                <th>Monto Deuda</th>
                <th>Generar PDF</th>

            </tr>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?= $fila["id"] ?></td>
                <td><?= $fila["monto"] ?></td>
                <td><?= $fila["fecha"] ?></td>
                <td><?= $fila["monto_pagado"] ?></td>
                <td><?= $fila["monto_deuda"] ?></td>
                <td><a href="generar_pdf.php?facturaId=<?= $fila['id'] ?>">Generar PDF</a></td>

            </tr>
            <?php } ?>
        </table>
    </main>

    <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function() {
            window.history.back();
        });
    </script>

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
<?php
} else {
    echo "No se ha proporcionado un ID de cliente válido.";
}
?>

</html>