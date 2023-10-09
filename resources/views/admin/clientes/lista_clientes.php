<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<?php
// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener todos los clientes con el nombre de la moneda
$sql = "SELECT c.ID, c.Nombre, c.Apellido, c.Domicilio, c.Telefono, c.HistorialCrediticio, c.ReferenciasPersonales, m.Nombre AS Moneda, c.ZonaAsignada FROM Clientes c
        LEFT JOIN Monedas m ON c.MonedaPreferida = m.ID";
$resultado = $conexion->query($sql);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/lista_clientes.css"> <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Listado de Clientes</title>
</head>
<body>
    <h1>Listado de Clientes</h1>

    <div id="mensaje">
            <?php
            if (isset($_GET['mensaje'])) {
                echo htmlspecialchars($_GET['mensaje']);
            }
            ?>
        </div>
    
    <div class="search-container">
        <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
    </div>
    <div class="div">
        <a href="/resources/views/admin/clientes/agregar_clientes.php">Agregar Cliente</a>
       
        <a href="/resources/views/admin/inicio/inicio.php">Volver</a>
    </div> <br><br>

    <?php if ($resultado->num_rows > 0) { ?>
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
                <th>Acciones</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?= "REC 100" .$fila["ID"] ?></td>
                    <td><?= $fila["Nombre"] ?></td>
                    <td><?= $fila["Apellido"] ?></td>
                    <td><?= $fila["Domicilio"] ?></td>
                    <td><?= $fila["Telefono"] ?></td> 
                    <td><?= $fila["ReferenciasPersonales"] ?></td>
                    <td><?= $fila["Moneda"] ?></td> <!-- Mostrar el nombre de la moneda -->
                    <td><?= $fila["ZonaAsignada"] ?></td>
                    <td><a href="../../../../controllers/perfil_cliente.php?id=<?= $fila["ID"] ?>">Ver Perfil</a></td>
                    <td><a href="/resources/views/admin/abonos/crud_historial_pagos.php?clienteId=<?= $fila["ID"] ?>">pagos</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No se encontraron clientes en la base de datos.</p>
    <?php } ?>
    
    <script>
        // JavaScript para la búsqueda en tiempo real
        const searchInput = document.getElementById('search-input');
        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function () {
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
</body>
</html>
