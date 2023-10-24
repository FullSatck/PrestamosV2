<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago de Préstamos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/assets/css/abonos.css">
</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-circle-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="wallet-outline"></ion-icon>
                <span>Recaudo</span>
            </div>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/resources/views/admin/admin_saldo/saldo_admin.php">
                        <ion-icon name="push-outline"></ion-icon>
                        <span>Saldo Inicial</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/inicio/inicio.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/crudusuarios.php">
                        <ion-icon name="people-outline"></ion-icon>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/registrar.php">
                        <ion-icon name="person-add-outline"></ion-icon>
                        <span>Registrar Usuario</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/lista_clientes.php">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span>Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/agregar_clientes.php">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span>Registrar Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/crudPrestamos.php">
                        <ion-icon name="list-outline"></ion-icon>
                        <span>Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/prestamos.php">
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        <span>Registrar Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/cobros/cobros.php">
                        <ion-icon name="planet-outline"></ion-icon>
                        <span>Zonas de cobro</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/gastos/gastos.php">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Gastos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/lista_super.php">
                        <ion-icon name="map-outline"></ion-icon>
                        <span>Ruta</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/abonos.php" class="hola">
                        <ion-icon name="cloud-download-outline"></ion-icon>
                        <span>Abonos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/retiros/retiros.php">
                        <ion-icon name="cloud-done-outline"></ion-icon>
                        <span>Retiros</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Dark Mode</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <div class="container">
            <h1 class="mt-5">Formulario de Pago de Préstamos</h1>

            <div class="botone">
                <a href="">mas tarde</a>&nbsp;&nbsp;
                <a href="">pagar todo</a>
            </div>

            <!-- Información del cliente -->
            <div id="cliente-info" class="mt-4">
                <h2>Información del Cliente</h2> <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cliente-id"><strong>ID del Cliente: </strong></label>
                        <span id="cliente-id"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cliente-nombre"><strong>Nombre: </strong></label>
                        <span id="cliente-nombre"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cliente-apellido"><strong>Apellido: </strong></label>
                        <span id="cliente-apellido"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cliente-domicilio"><strong>Domicilio:</strong></label>
                        <span id="cliente-domicilio"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cliente-telefono"><strong>Teléfono:</strong></label>
                        <span id="cliente-telefono"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cliente-curp"><strong>Identificación CURP:</strong></label>
                        <span id="cliente-curp"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cliente-zona"><strong>Zona Asignada:</strong></label>
                        <span id="cliente-zona"></span>
                    </div>
                </div>
            </div>

            <!-- Información del préstamo -->
            <div id="prestamo-info" class="mt-4">
                <h2>Información del Préstamo</h2> <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="prestamo-id"><strong>ID de Préstamo:</strong></label>
                        <span id="prestamo-id"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestamo-tasa"><strong>Tasa de Interés:</strong></label>
                        <span id="prestamo-tasa"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestamo-fecha-inicio"><strong>Fecha de Inicio:</strong></label>
                        <span id="prestamo-fecha-inicio"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestamo-fecha-vencimiento"><strong>Fecha de Vencimiento:</strong></label>
                        <span id="prestamo-fecha-vencimiento"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestamo-zona"><strong>Zona:</strong></label>
                        <span id="prestamo-zona"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestamo-monto-pagar"><strong>Deuda:</strong></label>
                        <span id="prestamo-monto-pagar"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prestamo-cuota"><strong>Cuota:</strong></label>
                        <span id="prestamo-cuota"></span>
                    </div>
                </div>
            </div>

            <!-- Formulario de pago -->
            <div id="pago-form" class="mt-4">
                <h2>Registrar Pago</h2>
                <form id="formulario-pago">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cantidad-pago">Cantidad a Pagar:</label>
                            <input type="number" id="cantidad-pago" class="form-control" required>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha-pago">Fecha del Pago:</label>
                            <input type="date" id="fecha-pago" class="form-control" value="<?php echo date('Y-m-d'); ?>"
                                readonly>
                        </div>
                    </div>
                    <button type="button" id="registrarPago" class="btn btn-primary">Registrar Pago</button>
                </form>
            </div>

            <!-- Botones para navegar entre clientes -->
            <div class="mt-4">
                <button id="anteriorCliente" class="btn btn-secondary mr-2">Anterior</button>
                <button id="siguienteCliente" class="btn btn-secondary">Siguiente</button>
            </div>
        </div>

        <!-- Modal para confirmar el pago -->
        <div class="modal fade" id="confirmarPagoModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmarPagoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmarPagoModalLabel">Confirmar Pago</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Desea agregar este pago?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="confirmarPago" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para pago confirmado -->
        <div class="modal fade" id="pagoConfirmadoModal" tabindex="-1" role="dialog"
            aria-labelledby="pagoConfirmadoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pagoConfirmadoModalLabel">Pago Confirmado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        El pago ha sido confirmado exitosamente.
                    </div>
                    <div class="modal-footer">
                        <!-- Agregar el botón para generar la factura -->
                        <button id="generarFacturaButton" class="btn btn-primary">Generar Factura</button>

                        <!-- Agregar un botón para compartir la factura por WhatsApp -->
                       
                        <button type="button" class="btn btn-primary" id="compartirPorWhatsAppButton">
                            Compartir por WhatsApp 
                        </button>

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="/public/assets/js/abonos.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>