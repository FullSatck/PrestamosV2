<?php
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
    <link rel="stylesheet" href="/public/assets/css/curdFaturas.css"> <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Historial de Pagos</title>
</head>
<body>
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
</body>
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
<?php
} else {
    echo "No se ha proporcionado un ID de cliente válido.";
}
?>
