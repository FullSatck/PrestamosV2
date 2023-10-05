<!DOCTYPE html>
<html>
<head>
    <title>Registrar Pago</title>
</head>
<body>
    <h1>Registrar Pago</h1>
    <form action="/resources/views/admin/abonos/registrar1.php" method="POST">
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id">
            <!-- Aquí debes cargar la lista de clientes desde la base de datos -->
            <?php
            include '../../../../controllers/conexion.php'; // Incluye el archivo de conexión
            $query = "SELECT ID, Nombre, Apellido FROM clientes";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['ID']}'>{$row['Nombre']} {$row['Apellido']}</option>";
            }
            ?>
        </select>
        <br>
        <label for="fecha_pago">Fecha del Pago:</label>
        <input type="date" name="fecha_pago" id="fecha_pago" required>
        <br>
        <label for="monto_pagado">Monto Pagado:</label>
        <input type="number" name="monto_pagado" id="monto_pagado" step="0.01" required>
        <br>
        <input type="submit" value="Registrar Pago">
    </form>
</body>
</html>
