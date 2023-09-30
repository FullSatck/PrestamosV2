<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/prestamo.css">
    <title>Solicitud de Préstamo</title>
</head>
<body>
    <h1>Solicitud de Préstamo</h1>
    <form action="/controllers/procesar_prestamo.php" method="POST">
        <?php
        // Incluir el archivo de conexión
        include("../../../../controllers/conexion.php");
        
        // Consulta para obtener la lista de clientes
        $query_clientes = "SELECT ID, Nombre, Apellido FROM Clientes";
        $result_clientes = $conexion->query($query_clientes);
        
        // Consulta para obtener la lista de monedas
        $query_monedas = "SELECT ID, Nombre, Simbolo FROM Monedas";
        $result_monedas = $conexion->query($query_monedas);
        ?>
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id">
            <?php
            while ($row = $result_clientes->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . " " . $row['Apellido'] . "</option>";
            }
            ?>
        </select>

        <label for="monto">Monto del Préstamo:</label>
        <input type="number" name="monto" id="monto" required>

        <label for="tasa_interes">Tasa de Interés (%):</label>
        <input type="number" name="tasa_interes" id="tasa_interes" min="1" max="100" required>

        <label for="plazo">Plazo (meses):</label>
        <input type="number" name="plazo" id="plazo" required>

        <label for="moneda_id">Moneda:</label>
        <select name="moneda_id" id="moneda_id">
            <?php
            while ($row = $result_monedas->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . " (" . $row['Simbolo'] . ")" . "</option>";
            }
            ?>
        </select>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>

        <label for="frecuencia_pago">Frecuencia de Pago:</label>
        <select name="frecuencia_pago" id="frecuencia_pago">
            <option value="diario">Diario</option>
            <option value="semanal">Semanal</option>
            <option value="quincenal">Quincenal</option>
            <option value="mensual">Mensual</option>
        </select>

        <input type="submit" value="Solicitar Préstamo">
    </form>
    <?php
    // Cerrar la conexión a la base de datos (opcional)
    $conexion->close();
    ?>
</body>
</html>
