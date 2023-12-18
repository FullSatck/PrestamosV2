<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pagos Retroactivos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="desatrasar.css">
</head>
<body>
<header>
        <a href="/resources/views/admin/inicio/inicio.php" class="botonn">
            <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
            <span class="spann">Volver al Inicio</span>
        </a>

        
    </header>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Registrar Pagos Retroactivos</h2>

        <form action="procesar_pagos.php" method="post" class="card card-body">
            <!-- Cliente -->
            <div class="form-group">
                <label for="cliente_id">Seleccione el Cliente:</label>
                <select id="cliente_id" name="cliente_id" class="form-control">
                    <?php
                    include '../../../../controllers/conexion.php';
                    $id_cliente_url = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : null;

                    if ($id_cliente_url) {
                        $query_cliente = "SELECT ID, Nombre FROM clientes WHERE ID = ?";
                        $stmt_cliente = $conexion->prepare($query_cliente);
                        $stmt_cliente->bind_param("i", $id_cliente_url);
                        $stmt_cliente->execute();
                        $result_cliente = $stmt_cliente->get_result();
                        if ($row_cliente = $result_cliente->fetch_assoc()) {
                            echo "<option value='" . $row_cliente['ID'] . "'>" . $row_cliente['Nombre'] . "</option>";
                        }
                        $stmt_cliente->close();

                        // Cargar los préstamos del cliente
                        $query_prestamos = "SELECT ID, MontoAPagar, FechaInicio FROM prestamos WHERE IDCliente = ?";
                        $stmt_prestamos = $conexion->prepare($query_prestamos);
                        $stmt_prestamos->bind_param("i", $id_cliente_url);
                        $stmt_prestamos->execute();
                        $result_prestamos = $stmt_prestamos->get_result();
                    }
                    ?>
                </select>
            </div>

            <!-- Préstamo -->
            <div class="form-group">
                <label for="prestamo_id">Seleccione el Préstamo:</label>
                <select id="prestamo_id" name="prestamo_id" class="form-control">
                    <?php
                    if (isset($result_prestamos)) {
                        while ($row_prestamo = $result_prestamos->fetch_assoc()) {
                            $fechaCreacion = date("d/m/Y", strtotime($row_prestamo['FechaInicio']));
                            echo "<option value='" . $row_prestamo['ID'] . "'>Préstamo: " . $row_prestamo['MontoAPagar'] . " - Fecha: " . $fechaCreacion . "</option>";
                        }
                        $stmt_prestamos->close();
                    }
                    ?>
                </select>
            </div>

            <!-- Número de Cuotas -->
            <div class="form-group">
                <label for="num_cuotas">Número de Cuotas a Pagar:</label>
                <input type="number" id="num_cuotas" name="num_cuotas" min="1" class="form-control">
            </div>

            <!-- Formularios de Cuotas -->
            <div id="formularios_cuotas" class="mb-3">
                <!-- Los formularios de cuotas se generarán aquí -->
            </div>

            <button type="submit" class="btn btn-primary">Registrar Pagos</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#num_cuotas').change(function() {
                var numCuotas = $(this).val();
                var formulariosCuotas = '';
                for (var i = 1; i <= numCuotas; i++) {
                    formulariosCuotas += '<div class="cuota-group mb-3">';
                    formulariosCuotas += '<h5>Cuota ' + i + '</h5>';
                    formulariosCuotas += '<div class="form-row">';
                    formulariosCuotas += '<div class="col"><label>Monto:</label><input type="number" name="monto_cuota[]" class="form-control" placeholder="Monto"></div>';
                    formulariosCuotas += '<div class="col"><label>Fecha:</label><input type="date" name="fecha_cuota[]" class="form-control"></div>';
                    formulariosCuotas += '</div></div>';
                }
                $('#formularios_cuotas').html(formulariosCuotas);
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
