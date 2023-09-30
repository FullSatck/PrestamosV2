<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <!-- Asegúrate de incluir esta línea para hacer tu sitio web responsive -->
    <link rel="stylesheet" type="text/css" href="/public/assets/css/registrar_cliente.css">
</head>

<body>
    <div class="registro-container"><br><br><br><br><br><br><br><br>
        <h2>Registro de Cliente</h2>
        <form action="validar_clientes.php" method="post">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Por favor ingrese el nombre">
            </div>
            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Por favor ingrese el apellido">
            </div>
            <div class="input-container">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" placeholder="Por favor ingrese la dirección">
            </div>
            <div class="input-container">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" placeholder="Por favor ingrese el teléfono">
            </div>
            <div class="input-container">
                <label for="historial_crediticio">Historial Crediticio:</label>
                <textarea id="historial_crediticio" name="historial_crediticio"
                    placeholder="Por favor ingrese el historial crediticio"></textarea>
            </div>
            <div class="input-container">
                <label for="referencias_personales">Referencias Personales:</label>
                <textarea id="referencias_personales" name="referencias_personales"
                    placeholder="Por favor ingrese las referencias personales"></textarea>
            </div>
            <div class="input-container">
                <label for="moneda_preferida">Moneda Preferida:</label>
                <select id="moneda_preferida" name="moneda_preferida">
                
                    <?php
        // Incluye el archivo de conexión a la base de datos
        include("../../../../controllers/conexion.php");

        // Consulta SQL para obtener las monedas
        $consultaMonedas = "SELECT ID, Nombre FROM Monedas";
        $resultMonedas = mysqli_query($conexion, $consultaMonedas);

        // Genera las opciones del menú desplegable para Moneda Preferida
        while ($row = mysqli_fetch_assoc($resultMonedas)) {
            echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
        ?>
               </select>
            </div>

            <div class="input-container">
                <label for="zona_asignada">Zona Asignada:</label>
                <select id="zona_asignada" name="zona_asignada">
                    <?php
        // Incluye el archivo de conexión a la base de datos
        include("../../../../controllers/conexion.php");

        // Consulta SQL para obtener las zonas
        $consultaZonas = "SELECT ID, Nombre FROM Zonas";
        $resultZonas = mysqli_query($conexion, $consultaZonas);

        // Genera las opciones del menú desplegable para Zona Asignada
        while ($row = mysqli_fetch_assoc($resultZonas)) {
            echo '<option value="' . $row['Nombre'] . '">' . $row['Nombre'] . '</option>';
        }

        ?>
                </select>
            </div>

            <div class="btn-container">
                <button type="submit">Registrar Cliente</button>
            </div>
        </form>
    </div>
</body>

</html>