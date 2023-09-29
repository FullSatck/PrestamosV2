<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Préstamo</title>
    <link rel="stylesheet" href="/views/assets/css/prestamo.css">
</head>
<body>
    <div class="container">
        <h1>Solicitud de Préstamo</h1>
        <?php
        // Incluir el archivo de conexión a la base de datos
        include("../../controlador/conexion.php");

        // Verificar si la conexión se realizó correctamente
        if ($conexion->connect_error) {
            echo "<p class='error-message'>Error de conexión a la base de datos: " . $conexion->connect_error . "</p>";
        } else {
            echo "<p class='success-message'>Conexión efectiva a la base de datos</p>";
        }
        ?>
        <form action="/controlador/procesar_prestamo.php" method="POST">
            <label for="monto">Monto del Préstamo:</label>
            <input type="number" name="monto" required>
            
            <label for="tasaInteres">Tasa de Interés (%):</label>
            <input type="number" name="tasaInteres" required>
            
            <label for="plazo">Plazo (meses):</label>
            <input type="number" name="plazo" required>
            
            <label for="frecuenciaPago">Frecuencia de Pago:</label>
            <select name="frecuenciaPago" required>
                <option value="mensual">Mensual</option>
                <option value="quincenal">Quincenal</option>
                <option value="semanal">Semanal</option>
                <option value="diario">Diario</option>
            </select>
            
            <label for="clienteID">Cliente:</label>
            <select name="clienteID" required>
                <?php
                // Consulta para obtener los nombres de los clientes
                $sql = "SELECT ID, Nombre, Apellido FROM Clientes";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["ID"] . "'>" . $row["Nombre"] . " " . $row["Apellido"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay clientes disponibles</option>";
                }
                ?>
            </select>
            
            <label for="zona">Zona:</label>
            <select name="zona" required>
                <?php
                // Consulta para obtener las zonas disponibles
                $sql = "SELECT ID, Nombre FROM Zonas";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["ID"] . "'>" . $row["Nombre"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay zonas disponibles</option>";
                }
                ?>
            </select>

            <button type="submit">Solicitar Préstamo</button>
        </form>
        <!-- Agregar un div para mostrar mensajes de error -->
        <div class="error-message">
            <?php
            if (isset($_GET["error"])) {
                echo "Error: " . $_GET["error"];
            }
            ?>
        </div>
    </div>
</body>
</html>
