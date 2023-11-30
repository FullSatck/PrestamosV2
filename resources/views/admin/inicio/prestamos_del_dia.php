<?php
session_start();

// Validacion de rol para ingresar a la pagina 
require_once '../../../../controllers/conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
} else {
    // El usuario está autenticado, obtén el ID del usuario de la sesión
    $usuario_id = $_SESSION["usuario_id"];

    // Preparar la consulta para obtener el rol del usuario
    $stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
    $stmt->bind_param("i", $usuario_id);

    // Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    // Verifica si el resultado es nulo, lo que significaría que el usuario no tiene un rol válido
    if (!$fila) {
        // Redirige al usuario a una página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }

    // Extrae el nombre del rol del resultado
    $rol_usuario = $fila['Nombre'];

    // Verifica si el rol del usuario corresponde al necesario para esta página
    if ($rol_usuario !== 'admin') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
}

require 'filtrarPrestamos.php'; // Asegúrate de que este archivo contiene la función obtenerCuotas actualizada

// Obtener el filtro desde la URL si está presente, de lo contrario, usar 'todos'
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'pendiente';

// Obtener las cuotas del día con el filtro aplicado
$cuotasHoy = obtenerCuotas($conexion, $filtro);

// Obtener conteos de préstamos
$conteosPrestamos = contarPrestamosPorEstado($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos del dia </title>
    <link rel="stylesheet" href="/public/assets/css/prestaDia.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <a href="/resources/views/admin/inicio/inicio.php" class="botonn">
            <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
            <span class="spann">Volver al Inicio</span>
        </a>
    </header>


    <main>


        <h1>Cuotas del Día</h1>

        <!-- Canvas para el gráfico -->

        <!-- Contenedor para el gráfico con un estilo personalizado -->
        <div class="grafico-contenedor" style="width: 400px; height: 400px;">
            <canvas id="miGrafico"></canvas>
        </div>


        <form action="prestamos_del_dia.php" method="get">
            <select name="filtro">
                <!-- <option value="todos" <?php echo $filtro == 'todos' ? 'selected' : ''; ?>>Todos</option> -->
                <option value="pagado" <?php echo $filtro == 'pagado' ? 'selected' : ''; ?>>Pagados</option>
                <option value="pendiente" <?php echo $filtro == 'pendiente' ? 'selected' : ''; ?>>Pendientes</option>
                <option value="nopagado" <?php echo $filtro == 'nopagado' ? 'selected' : ''; ?>>No Pagados</option>
            </select>
            <input type="submit" value="Filtrar">
        </form>

        <?php if (count($cuotasHoy) > 0) : ?>
            <div class="table-scroll-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Préstamo</th>

                            <th>Nombre Cliente</th>
                            <th>Domicilio</th>
                            <th>Teléfono</th>
                            <th>Monto Cuota</th>
                            <th>Fecha Inicio</th>
                            <th>Frecuencia Pago</th>
                            <th>Perfil</th>
                            <th>Pagar</th>
                            <th>Mas Tarde</th>
                            <th>Pagar cantida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cuotasHoy as $cuota) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cuota['ID']); ?></td>
                                <td><?php echo htmlspecialchars($cuota['NombreCliente']); ?></td>
                                <td><?php echo htmlspecialchars($cuota['DireccionCliente']); ?></td>
                                <td><?php echo htmlspecialchars($cuota['TelefonoCliente']); ?></td>
                                <td><?php echo htmlspecialchars($cuota['MontoCuota']); ?></td>
                                <td><?php echo htmlspecialchars($cuota['FechaInicio']); ?></td>
                                <td><?php echo htmlspecialchars($cuota['FrecuenciaPago']); ?></td>
                                <td>
                                    <a href="../../../../controllers/perfil_cliente.php?id=<?php echo $cuota['IDCliente']; ?>" class="btn btn-info">Perfil </a>
                                    <?php if ($filtro != 'pagado') : ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmPaymentModal" onclick="setPrestamoId(<?php echo $cuota['ID']; ?>, <?php echo $cuota['MontoCuota']; ?>, '<?php echo htmlspecialchars($cuota['NombreCliente']); ?>', '<?php echo htmlspecialchars($cuota['DireccionCliente']); ?>', '<?php echo htmlspecialchars($cuota['TelefonoCliente']); ?>', '<?php echo htmlspecialchars($cuota['IdentificacionCURP']); ?>', '<?php echo htmlspecialchars($cuota['MontoAPagar']); ?>')">
                                        Pagar
                                    </button>

                                <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($filtro != 'pagado' && !$cuota['Pospuesto']) : ?>
                                        <button type="button" class="btn btn-warning" onclick="abrirModalPosponerPago(<?php echo $cuota['ID']; ?>, '<?php echo $cuota['NombreCliente']; ?>', '<?php echo $cuota['DireccionCliente']; ?>', '<?php echo $cuota['TelefonoCliente']; ?>', '<?php echo $cuota['IdentificacionCURP']; ?>', <?php echo $cuota['MontoAPagar']; ?>)">
                                            Mas Tarde
                                        </button>



                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($filtro != 'pagado') : ?>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#customPaymentModal" data-cliente-telefono="<?php echo htmlspecialchars($cuota['TelefonoCliente']); ?>" onclick="abrirModalPago(<?php echo $cuota['ID']; ?>,<?php echo $cuota['MontoCuota']; ?>,'<?php echo htmlspecialchars($cuota['NombreCliente']); ?>','<?php echo htmlspecialchars($cuota['DireccionCliente']); ?>','<?php echo htmlspecialchars($cuota['TelefonoCliente']); ?>','<?php echo htmlspecialchars($cuota['IdentificacionCURP']); ?>',<?php echo $cuota['MontoAPagar']; ?>)">
                                            Pagar Cantidad
                                        </button>


                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            <?php else : ?>
                <p>No hay cuotas pendientes para hoy.</p>
            <?php endif; ?>
            </div>

            <!-- Modal de Confirmación de Pago -->
            <div class="modal fade" id="confirmPaymentModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Confirmar Pago</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¿Está seguro de que desea procesar este pago?
                            <div>
                                <strong>Cliente:</strong> <span id="modalClienteNombre"></span><br>
                                <strong>Dirección:</strong> <span id="modalClienteDireccion"></span><br>
                                <strong>Teléfono:</strong> <span id="modalClienteTelefono"></span><br>
                                <strong>CURP:</strong> <span id="modalClienteCURP"></span><br>
                                <strong>Monto a Pagar:</strong> <span id="modalMontoAPagar"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="confirmPaymentButton">Confirmar Pago</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de WhatsApp -->
            <div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="whatsappModalLabel">Enviar a WhatsApp</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Enviar recibo a WhatsApp del cliente.</p>
                            <p id="clienteDetalles"></p> <!-- Detalles del cliente -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="sendWhatsappButton">Enviar a WhatsApp</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal de Pago Pospuesto -->
            <div class="modal fade" id="postponePaymentModal" tabindex="-1" role="dialog" aria-labelledby="postponePaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="postponePaymentModalLabel">Pago Pospuesto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Modal de Pago Pospuesto -->

                        <!-- ... -->
                        <div class="modal-body">
                            <strong> ¿Está seguro de que desea posponer el pago de este préstamo?</strong>
                            <strong>Cliente:</strong> <span id="postponeModalClienteNombre"></span><br>
                            <strong>Dirección:</strong> <span id="postponeModalClienteDireccion"></span><br>
                            <strong>Teléfono:</strong> <span id="postponeModalClienteTelefono"></span><br>
                            <strong>CURP:</strong> <span id="postponeModalClienteCURP"></span><br>
                            <strong>Monto a Pagar:</strong> <span id="postponeModalMontoAPagar"></span>


                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-warning" id="confirmPostponePaymentButton">Posponer Pago</button>
                        </div>

                    </div>
                </div>
            </div>
            </div>
            <!-- Modal para ingresar la cantidad personalizada -->
            <div class="modal fade" id="customPaymentModal" tabindex="-1" role="dialog" aria-labelledby="customPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customPaymentModalLabel">Pagar Cantidad Personalizada</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <strong>Cliente:</strong> <span id="customModalClienteNombre"></span><br>
                                <strong>Dirección:</strong> <span id="customModalClienteDireccion"></span><br>
                                <strong>Teléfono:</strong> <span id="customModalClienteTelefono"></span><br>
                                <strong>CURP:</strong> <span id="customModalClienteCURP"></span><br>
                                <strong>Monto a Pagar:</strong> <span id="customModalMontoAPagar"></span><br>
                            </div><br>
                            <form id="customPaymentForm">
                                <div class="form-group">
                                    <label for="customAmount">Ingrese la cantidad:</label>
                                    <input type="number" class="form-control" id="customAmount" name="customAmount" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="procesarPagoPersonalizado()">Pagar</button>
                        </div>
                    </div>
                </div>
            </div>





    </main>
    <script>
        var conteosPrestamos = <?php echo json_encode($conteosPrestamos); ?>;
        console.log(conteosPrestamos); // Para depuración

        var maxPendiente = parseInt(conteosPrestamos.pendiente, 10);
        var maxPagado = parseInt(conteosPrestamos.pagado, 10);
        var maxNoPagado = parseInt(conteosPrestamos.nopagado, 10);
        var maxValor = Math.max(maxPendiente, maxPagado, maxNoPagado);

        var ctx = document.getElementById('miGrafico').getContext('2d');
        var miGrafico = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendientes', 'Pagados', 'No Pagados'],
                datasets: [{
                    label: 'Estado de los Préstamos',
                    data: [maxPendiente, maxPagado, maxNoPagado],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 5,
                    barThickness: 50,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: maxValor + 1
                    },
                    x: {
                        barPercentage: 0.5
                    }
                }
            }
        });

        // Manejador para el botón de confirmar pago
        $('#confirmPaymentButton').click(function() {
            procesarPago(globalPrestamoId, globalMontoCuota);
        });

        // Manejador para el botón de posponer pago
        $('#confirmPostponePaymentButton').click(function() {
            posponerPago(globalPrestamoId);
        });

        // Evento al cerrar el modal de WhatsApp
        $('#whatsappModal').on('hidden.bs.modal', function() {
            location.reload(); // Recargar la página
        });

        // Evento al cerrar el modal de Pago Pospuesto
        $('#postponePaymentModal').on('hidden.bs.modal', function() {
            location.reload(); // Recargar la página
        });

        // Evento al cerrar el modal de Pago Personalizado
        $('#customPaymentModal').on('hidden.bs.modal', function() {
            e.stopPropagation(); // Evita la propagación del evento para que no se cierre automáticamente
        });

        var globalPrestamoId = 0;
        var globalMontoCuota = 0;

        function setPrestamoId(prestamoId, montoCuota, nombreCliente, direccionCliente, telefonoCliente, identificacionCURP, montoAPagar) {
            globalPrestamoId = prestamoId;
            globalMontoCuota = montoCuota;
            // Actualizar el contenido del modal con los detalles del cliente
            $('#modalClienteNombre').text(nombreCliente);
            $('#modalClienteDireccion').text(direccionCliente);
            $('#modalClienteTelefono').text(telefonoCliente);
            $('#modalClienteCURP').text(identificacionCURP);
            $('#modalMontoAPagar').text(montoAPagar);
        }

        function procesarPago(prestamoId, montoCuota) {
            $.ajax({
                url: 'procesar_pago.php', // Asegúrate de que esta URL es correcta
                type: 'POST',
                data: {
                    prestamoId: prestamoId,
                    montoPagado: montoCuota
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#confirmPaymentModal').modal('hide');
                        // Mostrar modal de WhatsApp
                        $('#whatsappModal').modal('show');
                        // Agregar los detalles del cliente al modal
                        $('#clienteDetalles').text('Nombre: ' + response.clienteNombre + ', Monto Pagado: ' +
                            response.montoPagado);
                        // Preparar el botón de WhatsApp
                        $('#sendWhatsappButton').off('click').on('click', function() {
                            var mensajeWhatsapp = 'Hola ' + response.clienteNombre +
                                ', hemos recibido tu pago de ' + response.montoPagado + '.';
                            window.open('https://wa.me/' + response.clienteTelefono + '?text=' +
                                encodeURIComponent(mensajeWhatsapp));
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    alert('Ocurrió un error al procesar el pago.');
                }
            });
        }

        function abrirModalPosponerPago(prestamoId, nombreCliente, direccionCliente, telefonoCliente, identificacionCURP, montoAPagar) {

            globalPrestamoId = prestamoId;

            // Establecer los datos del cliente en el modal de Posponer Pago
            $('#postponeModalClienteNombre').text(nombreCliente);
            $('#postponeModalClienteDireccion').text(direccionCliente);
            $('#postponeModalClienteTelefono').text(telefonoCliente);
            $('#postponeModalClienteCURP').text(identificacionCURP);
            $('#postponeModalMontoAPagar').text(montoAPagar);

            // Mostrar el modal de Posponer Pago
            $('#postponePaymentModal').modal('show');
        }


        function posponerPago(prestamoId) {
            $.ajax({
                url: 'posponer_pago.php', // Verifica que esta URL sea correcta
                type: 'POST',
                data: {
                    prestamoId: prestamoId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Código para manejar una respuesta exitosa
                        $('#postponePaymentModal').modal('hide');
                        // Otras actualizaciones de la interfaz de usuario
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    alert('Ocurrió un error al posponer el pago.');
                }
            });
        }

        // Función para abrir el modal de pago personalizado
        function abrirModalPago(prestamoId, montoCuota, nombreCliente, direccionCliente, telefonoCliente, identificacionCURP, montoAPagar) {
            globalPrestamoId = prestamoId;
            globalMontoCuota = montoCuota;

            // Establecer los datos del cliente en el modal de Pagar Cantidad
            $('#customModalClienteNombre').text(nombreCliente);
            $('#customModalClienteDireccion').text(direccionCliente);
            $('#customModalClienteTelefono').text(telefonoCliente);
            $('#customModalClienteCURP').text(identificacionCURP);
            $('#customModalMontoAPagar').text(montoAPagar);

            // Configurar el botón de WhatsApp para abrir el modal de WhatsApp con el número correcto
            $('#sendWhatsappButton').off('click').on('click', function() {
                var telefonoCliente = $('#customPaymentModal').data('cliente-telefono');
                var mensajeWhatsapp = 'Hola, hemos recibido tu pago de ' + montoAPagar + '.';
                window.open('https://wa.me/' + telefonoCliente + '?text=' + encodeURIComponent(mensajeWhatsapp));
            });

            // Mostrar el modal de Pagar Cantidad
            $('#customPaymentModal').modal('show');
        }

        // Función para procesar el pago personalizado
        function procesarPagoPersonalizado() {
            var customAmount = $('#customAmount').val();

            if (customAmount <= 0) {
                alert('Ingrese una cantidad válida.');
                return;
            }

            // Realiza el pago personalizado
            procesarPago(globalPrestamoId, customAmount);
            $('#customPaymentModal').modal('hide');
        }
    </script>
</body>

</html>