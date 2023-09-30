<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Clientes</title>
</head>
<body>
    <h1>Formulario de Clientes</h1>
    <form action="validar_clientes.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br>

        <label for="historial_crediticio">Historial Crediticio:</label>
        <textarea name="historial_crediticio"></textarea><br>

        <label for="referencias_personales">Referencias Personales:</label>
        <textarea name="referencias_personales"></textarea><br>

        <label for="moneda_preferida">Moneda Preferida:</label>
        <select name="moneda_preferida">
            <?php
                // Conexión a la base de datos
                $conexion = new mysqli("localhost", "usuario", "contraseña", "prestamos");

                // Verificar la conexión
                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Consulta para obtener las monedas
                $query = "SELECT ID, Nombre, Simbolo FROM Monedas";
                $result = $conexion->query($query);

                // Llenar el dropdown con las opciones de monedas
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["ID"] . "'>" . $row["Nombre"] . " (" . $row["Simbolo"] . ")</option>";
                }

                // Cerrar la conexión
                $conexion->close();
            ?>
        </select><br>

        <label for="zona_asignada">Zona Asignada:</label>
        <select name="zona_asignada">
            <?php
                // Conexión a la base de datos
                $conexion = new mysqli("localhost", "usuario", "contraseña", "prestamos");

                // Verificar la conexión
                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Consulta para obtener las zonas
                $query = "SELECT ID, Nombre FROM Zonas";
                $result = $conexion->query($query);

                // Llenar el dropdown con las opciones de zonas
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["Nombre"] . "'>" . $row["Nombre"] . "</option>";
                }

                // Cerrar la conexión
                $conexion->close();
            ?>
        </select><br>

        <input type="submit" value="Registrar Cliente">
    </form>
</body>
</html>
