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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluye jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+J/T4Aj4Or5M5L6f4dOMu1zC5z5OIn5S/4ro5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/cruduser.css">
    <link rel="stylesheet" href="/public/assets/css/custom.css">
    <title>CRUD de Préstamos</title>
</head>

<body>
    <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Préstamos</h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Barra de búsqueda y botón de registro -->
                <div class="search-container">
                    <div class="search-input">
                        <input type="text" id="search-input" class="form-control" placeholder="Buscar...">
                        <button type="button" id="search-button" class="btn btn-primary"><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
                <!-- Tabla de préstamos en un contenedor con scroll horizontal -->
                <div class="table-container">
                    <div class="table-scroll">
                        <table class="table table-responsive">
                            <!-- Clase 'table-responsive' para hacerla responsive -->
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Interés</th>
                                    <th scope="col">Plazo</th>
                                    <th scope="col">Moneda</th>
                                    <th scope="col">F. Inicio</th>
                                    <th scope="col">F. Vencimiento</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Cobrador</th>
                                    <th scope="col">Zona</th>
                                    <th scope="col">Deuda</th>
                                    <th scope="col">Frecuencia</th>
                                    <th scope="col">Cuota</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("../../../../controllers/conexion.php");
                                $sql = $conexion->query("SELECT prestamos.ID, clientes.Nombre AS NombreCliente, prestamos.Monto, prestamos.TasaInteres, prestamos.Plazo, prestamos.MonedaID, prestamos.FechaInicio, prestamos.FechaVencimiento, prestamos.Estado, prestamos.CobradorAsignado, prestamos.Zona, prestamos.MontoAPagar, prestamos.FrecuenciaPago, prestamos.MontoCuota, prestamos.Cuota FROM prestamos JOIN clientes ON prestamos.IDCliente = clientes.ID");
                                while ($datos = $sql->fetch_object()) { ?>
                                    <tr>
                                        <td><?= $datos->ID ?></td>
                                        <td><?= $datos->NombreCliente ?></td>
                                        <td><?= $datos->Monto ?></td>
                                        <td><?= $datos->TasaInteres ?></td>
                                        <td><?= $datos->Plazo ?></td>
                                        <td><?= $datos->MonedaID ?></td>
                                        <td class="fecha-inicio"><?= $datos->FechaInicio ?></td>
                                        <td class="fecha-vencimiento"><?= $datos->FechaVencimiento ?></td>
                                        <td class="estado"><?= $datos->Estado ?></td>
                                        <td><?= $datos->CobradorAsignado ?></td>
                                        <td><?= $datos->Zona ?></td>
                                        <td><?= $datos->MontoAPagar ?></td>
                                        <td class="frecuencia-pago"><?= $datos->FrecuenciaPago ?></td>
                                        <td><?= $datos->MontoCuota ?></td>
                                        <td><a href="/ruta_para_editar?id=<?= $datos->ID ?>"><i
                                                    class="fas fa-edit fa-lg"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Paginación -->
                <div id="pagination" class="text-center">
                    <ul class="pagination">
                        <!-- Los botones de paginación se generarán aquí -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

  
    <script>
        $(document).ready(function () {
            $('#search-button').on('click', function () {
                var searchTerm = $('#search-input').val().toLowerCase();
                $('tbody tr').each(function () {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchTerm) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Restaura las filas ocultas cuando se borra el campo de búsqueda
            $('#search-input').on('input', function () {
                var searchTerm = $(this).val().toLowerCase();
                if (searchTerm === '') {
                    $('tbody tr').show();
                }
            });
        });
    </script>
</body>

</html>
