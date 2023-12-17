<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Pagos Retroactivos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="desatrasar.css">
    <script>
        $(document).ready(function() {
            $('#cliente_id').change(function() {
                var clienteId = $(this).val();
                $.ajax({
                    url: 'obtener_prestamos.php',
                    method: 'GET',
                    data: { cliente_id: clienteId },
                    success: function(response) {
                        $('#prestamo_id').html(response);
                    }
                });
            });

            $('#num_cuotas').change(function() {
                var numCuotas = $(this).val();
                var formulariosCuotas = '';
                for (var i = 1; i <= numCuotas; i++) {
                    formulariosCuotas += '<p>Cuota ' + i + ': Monto: <input type="number" name="monto_cuota[]"> Fecha: <input type="date" name="fecha_cuota[]"></p>';
                }
                $('#formularios_cuotas').html(formulariosCuotas);
            });
        });
    </script>
</head>
<body>
    <h2>Registrar Pagos Retroactivos</h2>

    <form action="procesar_pagos.php" method="post">
        <label for="cliente_id">Seleccione el Cliente:</label>
        <select id="cliente_id" name="cliente_id">
            <option value="">Seleccione un Cliente</option>
            <?php
            include '../../../../controllers/conexion.php'; // Asegúrate de que este archivo conecta correctamente a la base de datos.
            $query = "SELECT ID, Nombre FROM clientes";
            $result = $conexion->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . "</option>";
            }
            ?>
        </select><br>

        <label for="prestamo_id">Seleccione el Préstamo:</label>
        <select id="prestamo_id" name="prestamo_id">
            <!-- Opciones de préstamos se cargarán aquí -->
        </select><br>

        <label for="num_cuotas">Número de Cuotas a Pagar:</label>
        <input type="number" id="num_cuotas" name="num_cuotas" min="1"><br>

        <div id="formularios_cuotas">
            <!-- Los formularios de cuotas se generarán aquí -->
        </div>

        <input type="submit" value="Registrar Pagos">
    </form>
</body>
</html>
