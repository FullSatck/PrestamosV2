<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
    exit();
}


// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+J/T4Aj4Or5M5L6f4dOMu1zC5z5OIn5S/4ro5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/crudpresta.css">
    <title>CRUD de Préstamos</title>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <a href="/controllers/cerrar_sesion.php" class="botonn">
            <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
            <span class="spann">Cerrar Sesion</span>
        </a>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>


            <a href="/resources/views/zonas/1-aguascalientes/cobrador/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/cobrador/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>



        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <!-- Botón para volver a la página anterior -->
        <h1 class="text-center">Listado de Préstamos</h1>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Barra de búsqueda y botón de registro -->
                    <div class="search-container">
                        <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
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
                                        <th scope="col">Estado</th>
                                        <th scope="col">Zona</th>
                                        <th scope="col">Deuda</th>
                                        <th scope="col">Frecuencia</th>
                                        <th scope="col">Cuota</th>
                                        <th scope="col">Inf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
<<<<<<< HEAD
                            include("../../../../../../controllers/conexion.php");
                            $sql = $conexion->query("SELECT prestamos.ID, clientes.Nombre AS nombreCliente, prestamos.Monto, prestamos.TasaInteres, prestamos.Plazo, prestamos.MonedaID, prestamos.FechaInicio, prestamos.FechaVencimiento, prestamos.Estado, prestamos.CobradorAsignado, prestamos.Zona, prestamos.MontoAPagar, prestamos.FrecuenciaPago, prestamos.MontoCuota, prestamos.Cuota FROM prestamos JOIN clientes ON prestamos.IDCliente = clientes.ID WHERE prestamos.Zona = 'Aguascalientes' AND estadoP = 1");
                            while ($datos = $sql->fetch_object()) { ?>
=======
                                    include("../../../../../../controllers/conexion.php");
                                    $sql = $conexion->query("SELECT prestamos.ID, clientes.Nombre AS nombreCliente, prestamos.Monto, prestamos.TasaInteres, prestamos.Plazo, prestamos.MonedaID, prestamos.FechaInicio, prestamos.FechaVencimiento, prestamos.Estado, prestamos.CobradorAsignado, prestamos.Zona, prestamos.MontoAPagar, prestamos.FrecuenciaPago, prestamos.MontoCuota, prestamos.Cuota FROM prestamos JOIN clientes ON prestamos.IDCliente = clientes.ID WHERE prestamos.Zona = 'Aguascalientes' AND estadoP = 1");
                                    while ($datos = $sql->fetch_object()) { ?>
>>>>>>> 6e5291a02c2829b1c3440ad6fd1cbc7f0507b8ca
                                    <tr>
                                        <td><?= $datos->ID ?></td>
                                        <td><?= $datos->nombreCliente ?></td> <!-- Aquí se cambia a 'nombreCliente' -->
                                        <td><?= $datos->Monto ?></td>
                                        <td><?= $datos->TasaInteres ?></td>
                                        <td><?= $datos->Plazo ?></td>
                                        <td><?= $datos->MonedaID ?></td>
                                        <td class="estado"><?= $datos->Estado ?></td>
                                        <td><?= $datos->Zona ?></td>
                                        <td><?= $datos->MontoAPagar ?></td>
                                        <td class="frecuencia-pago"><?= $datos->FrecuenciaPago ?></td>
                                        <td><?= number_format($datos->MontoCuota, 0, '.', '.') ?></td>
                                        <td><a href="/ruta_para_mostar_inf_de_prestamo?id=<?= $datos->ID ?>"><i
                                                    class="fa-regular fa-circle-info"></i></a></td>
                                    </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    $(document).ready(function() {
        $('#search-button').on('click', function() {
            var searchTerm = $('#search-input').val().toLowerCase();
            $('tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchTerm) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Restaura las filas ocultas cuando se borra el campo de búsqueda
        $('#search-input').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            if (searchTerm === '') {
                $('tbody tr').show();
            }
        });
    });
    </script>
    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>