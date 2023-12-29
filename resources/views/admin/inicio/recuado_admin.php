<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Historial de Pagos</h1>
        
        <!-- Formulario para filtrar por fechas -->
        <form id="filter-form" class="mb-4">
            <h2>Filtrar por Fechas</h2>
            <div class="mb-3">
                <label for="fechaDesde">Desde:</label>
                <input type="date" class="form-control" id="fechaDesde" name="fechaDesde" required>
            </div>
            <div class="mb-3">
                <label for="fechaHasta">Hasta:</label>
                <input type="date" class="form-control" id="fechaHasta" name="fechaHasta" required>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
        
        <!-- Tabla para mostrar pagos -->
        <h2>Lista de Pagos</h2>
        <table class="table">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Cliente </th>
                    <th>CURP </th>
                    <th>Fecha de Pago</th>
                    <th>Monto Pagado</th>
                    <!-- <th>ID Prestamo</th> -->
                    <th>Quien Pago</th>
                </tr>
            </thead>
            <tbody id="pagos-list">
                <!-- Aquí se cargarán los datos de la base de datos -->
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="app.js"></script>
</body>
</html>
