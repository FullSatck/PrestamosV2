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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/curdFaturas.css"> 
    <title>Historial de Pagos</title>
</head>
 
<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <a href="/controllers/cerrar_sesion.php" class="botonn">
            <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
            <span class="spann">Cerrar Sesion</span>
        </a>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/inicio/inicio.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/inicio/inicio.php" class="selected">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

<<<<<<< HEAD
          

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/clientes/lista_clientes.php" class="selected">
=======
           
            <a href="/resources/views/zonas/2-baja_california/Supervisor/clientes/lista_clientes.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/clientes/agregar_clientes.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/clientes/agregar_clientes.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/creditos/crudPrestamos.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/creditos/crudPrestamos.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/creditos/prestamos.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/creditos/prestamos.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/gastos/gastos.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/gastos/gastos.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/ruta/lista_super.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/ruta/lista_super.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/abonos/abonos.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/abonos/abonos.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

<<<<<<< HEAD
            <a href="/resources/views/zonas/1-aguascalientes/cobrador/retiros/retiros.php">
=======
            <a href="/resources/views/zonas/2-baja_california/Supervisor/retiros/retiros.php">
>>>>>>> 55778081d058cb02dc1a645f3f0ead2bccf5e5f9
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