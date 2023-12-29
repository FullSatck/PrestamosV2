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
    <link rel="stylesheet" href="/public/assets/css/recaudo_admin.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Historial de Pagos</h1>

        <!-- Formulario para filtrar por fechas y/o usuario -->
        <form id="filter-form" class="mb-4">
            <h2>Filtrar Pagos</h2>
            <div class="row">
                <div class="col">
                    <label for="fechaDesde">Desde:</label>
                    <input type="date" class="form-control" id="fechaDesde" name="fechaDesde">
                </div>
                <div class="col">
                    <label for="fechaHasta">Hasta:</label>
                    <input type="date" class="form-control" id="fechaHasta" name="fechaHasta">
                </div>
                <div class="col">
                    <label for="usuario">Usuario:</label>
                    <select class="form-control" id="usuario" name="usuario">
                        <option value="">Todos los usuarios</option>
                        <!-- Las opciones se cargarán desde la base de datos -->
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
        </form>
        <div class="mb-3">
            <h3>Total Pagado: <span id="totalPagado">0</span></h3>
        </div>
        <!-- Tabla para mostrar pagos -->
        <h2>Lista de Pagos</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>CURP</th>
                        <th>Fecha Pago</th>
                        <th>Monto Pagado</th>
                        <th>Quien Pago</th>
                    </tr>
                </thead>
                <tbody id="pagos-list">
                    <!-- Aquí se cargarán los datos de la base de datos -->
                </tbody>
            </table>
        </div>

        <script src="app.js"></script>
</body>

</html>