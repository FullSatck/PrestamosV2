<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Préstamos</title>
    <link rel="stylesheet" href="/public/assets/css/prestamo.css">
</head>

<body>
    <h1>Solicitud de Préstamo</h1>
    <form action="/controllers/procesar_prestamo.php" method="POST">
        <?php
        // Incluir el archivo de conexión a la base de datos
        include("../../../../controllers/conexion.php");

        // Obtener la lista de clientes, monedas y zonas desde la base de datos
        $query_clientes = "SELECT ID, Nombre FROM Clientes";
        $query_monedas = "SELECT ID, Nombre FROM Monedas";
        $query_zonas = "SELECT Nombre FROM Zonas";

        $result_clientes = $conexion->query($query_clientes);
        $result_monedas = $conexion->query($query_monedas);
        $result_zonas = $conexion->query($query_zonas);
        ?>
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" required>
            <?php
            while ($row = $result_clientes->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . "</option>";
            }
            ?>
        </select><br>

        <label for="monto">Monto:</label>
        <input type="text" name="monto" id="monto" required><br>

        <label for="tasa_interes">Tasa de Interés (%):</label>
        <input type="text" name="tasa_interes" id="tasa_interes" required oninput="calcularMontoPagar()"><br>

        <!-- Elemento para mostrar el monto a pagar en tiempo real -->
        <label for="monto_a_pagar">Monto a Pagar:</label>
        <span id="monto_a_pagar">0.00</span><br>

        <label for="plazo">Plazo (en días):</label>
        <input type="text" name="plazo" required><br>

        <label for="moneda_id">Moneda:</label>
        <select name="moneda_id" required>
            <?php
            while ($row = $result_monedas->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . "</option>";
            }
            ?>
        </select><br>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" required><br>

        <label for="frecuencia_pago">Frecuencia de Pago:</label>
        <select name="frecuencia_pago" required>
            <option value="diario">Diario</option>
            <option value="semanal">Semanal</option>
            <option value="quincenal">Quincenal</option>
            <option value="mensual">Mensual</option>
        </select><br>

        <label for="zona">Zona:</label>
        <select name="zona" required>
            <?php
            while ($row = $result_zonas->fetch_assoc()) {
                echo "<option value='" . $row['Nombre'] . "'>" . $row['Nombre'] . "</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Solicitar Préstamo">
    </form>

    <script>
    function calcularMontoPagar() {
        // Obtener los valores ingresados por el usuario
        var monto = parseFloat(document.getElementById('monto').value);
        var tasa_interes = parseFloat(document.getElementById('tasa_interes').value);

        // Calcular el monto a pagar
        var monto_a_pagar = monto + (monto * tasa_interes / 100);

        // Mostrar el monto a pagar en tiempo real en el elemento HTML
        document.getElementById('monto_a_pagar').textContent = monto_a_pagar.toFixed(2);
    }
    </script>
</body>

</html>