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

<!DOCTYPE html>
<html>

<head>
    <title>Solicitud de Préstamo</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/assets/css/prestamo.css">
</head>

<body>
    <div class="container">
        <h1>Solicitud de Préstamo</h1><br><br>
        <form action="/controllers/procesar_prestamo.php" method="POST" class="form-container">
            <?php
            // Incluir el archivo de conexión a la base de datos
            include("../../../../controllers/conexion.php");

            // Obtener la lista de clientes, monedas y zonas desde la base de datos
            $query_clientes = "SELECT ID, Nombre FROM Clientes";
            $query_monedas = "SELECT ID, Nombre, Simbolo FROM Monedas";
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
            <input type="text" name ="TasaInteres" id="TasaInteres" required><br>

            <label for="plazo">Plazo:</label>
            <input type="text" name="plazo" id="plazo" required><br>

            <label for="moneda_id">Moneda:</label>
            <select name="moneda_id" id="moneda_id" required onchange="calcularMontoPagar()">
                <?php
                while ($row = $result_monedas->fetch_assoc()) {
                    // Agregar el símbolo de la moneda como un atributo data-*
                    echo "<option value='" . $row['ID'] . "' data-simbolo='" . $row['Simbolo'] . "'>" . $row['Nombre'] . "</option>";
                }
                ?>
            </select><br>

            <!-- Reemplaza el campo de fecha de inicio con un campo de texto readonly -->
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" required><br>
                <br>


            <label for="frecuencia_pago">Frecuencia de Pago:</label>
            <select name="frecuencia_pago" id="frecuencia_pago" required onchange="calcularMontoPagar()">
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

            <div class="result-container">
                <h2>Resultados</h2>
                <p>Monto Total a Pagar: <span id="monto_a_pagar">0.00</span></p>
                <p>Plazo: <span id="plazo_mostrado">0 días</span></p>
                <p>Frecuencia de Pago: <span id="frecuencia_pago_mostrada">Diario</span></p>
                <p>Cantidad a Pagar por Cuota: <span id="cantidad_por_cuota">0.00</span></p>
                <p>Moneda: <span id="moneda_simbolo">USD</span></p>
            </div>

            <input type="submit" value="Hacer préstamo" class="calcular-button">
        </form>
    </div>

    <script>
    function calcularMontoPagar() {
        // Obtener los valores ingresados por el usuario
        var monto = parseFloat(document.getElementById('monto').value);
        var tasa_interes = parseFloat(document.getElementById('TasaInteres').value);
        var plazo = parseFloat(document.getElementById('plazo').value);
        var frecuencia_pago = document.getElementById('frecuencia_pago').value;
        var moneda_select = document.getElementById('moneda_id');
        var moneda_option = moneda_select.options[moneda_select.selectedIndex];
        var simbolo_moneda = moneda_option.getAttribute('data-simbolo');

        // Calcular el monto total, incluyendo el interés
        var monto_total = monto + (monto * (tasa_interes / 100));

        // Calcular la cantidad a pagar por cuota
        var cantidad_por_cuota = monto_total / plazo;

        // Actualizar los elementos HTML para mostrar los resultados en tiempo real
        document.getElementById('monto_a_pagar').textContent = monto_total.toFixed(2);
        document.getElementById('plazo_mostrado').textContent = plazo + ' ' + getPlazoText(frecuencia_pago);
        document.getElementById('frecuencia_pago_mostrada').textContent = frecuencia_pago;
        document.getElementById('cantidad_por_cuota').textContent = cantidad_por_cuota.toFixed(2);
        document.getElementById('moneda_simbolo').textContent = simbolo_moneda;
    }

    function getPlazoText(frecuencia_pago) {
        switch (frecuencia_pago) {
            case 'diario':
                return 'día(s)';
            case 'semanal':
                return 'semana(s)';
            case 'quincenal':
                return 'quincena(s)';
            case 'mensual':
                return 'mes(es)';
            default:
                return 'día(s)';
        }
    }
    </script>
</body>

</html>