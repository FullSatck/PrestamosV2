<?php
require 'filtrarPrestamos.php'; // Asegúrate de que este archivo contiene la función obtenerCuotas actualizada

// Obtener el filtro desde la URL si está presente, de lo contrario, usar 'todos'
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';

// Obtener las cuotas del día con el filtro aplicado
$cuotasHoy = obtenerCuotas($conexion, $filtro);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Préstamos</title>
    <link rel="stylesheet" href="/public/assets/css/lista_clientes.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body>




    <h1>Cuotas del Día</h1>
    <form action="prestamos_del_dia.php" method="get">
        <select name="filtro">
            <option value="todos" <?php echo $filtro == 'todos' ? 'selected' : ''; ?>>Todos</option>
            <option value="pagado" <?php echo $filtro == 'pagado' ? 'selected' : ''; ?>>Pagados</option>
            <option value="pendiente" <?php echo $filtro == 'pendiente' ? 'selected' : ''; ?>>Pendientes</option>
            <option value="nopagado" <?php echo $filtro == 'nopagado' ? 'selected' : ''; ?>>No Pagados</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <?php if (count($cuotasHoy) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID Préstamo</th>
                <th>ID Cliente</th>
                <th>Monto Cuota</th>
                <th>Fecha Inicio</th>
                <th>Frecuencia Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuotasHoy as $cuota): ?>
            <tr>
                <td><?php echo htmlspecialchars($cuota['ID']); ?></td>
                <td><?php echo htmlspecialchars($cuota['IDCliente']); ?></td>
                <td><?php echo htmlspecialchars($cuota['MontoCuota']); ?></td>
                <td><?php echo htmlspecialchars($cuota['FechaInicio']); ?></td>
                <td><?php echo htmlspecialchars($cuota['FrecuenciaPago']); ?></td>
                <td>
                    <!-- Botón que activa el modal de confirmación de pago -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmPaymentModal"
                        onclick="setPrestamoId(<?php echo $cuota['ID']; ?>, <?php echo $cuota['MontoCuota']; ?>)">
                        Pagar
                    </button>


                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No hay cuotas pendientes para hoy.</p>
    <?php endif; ?>



    <div class="modal fade" id="confirmPaymentModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentButton">Confirmar Pago</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para después del pago -->
    <div class="modal fade" id="postPaymentModal" tabindex="-1" role="dialog" aria-labelledby="postPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postPaymentModalLabel">Pago Realizado</h5>
                </div>
                <div class="modal-body">
                    El pago se ha efectuado con éxito.
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-success" id="whatsappLink">Compartir por WhatsApp</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Script para manejar la lógica del modal y el pago -->
    <script>
var globalPrestamoId = 0;
var globalMontoPagado = 0;
var globalTelefonoCliente = '';

function setPrestamoId(prestamoId, montoPagado, telefonoCliente) {
    globalPrestamoId = prestamoId;
    globalMontoPagado = montoPagado;
    globalTelefonoCliente = telefonoCliente;

    // Preparar el enlace de WhatsApp
    var mensajeWhatsApp = "Se ha realizado un pago de " + montoPagado + ". ID del Préstamo: " + prestamoId;
    var urlWhatsApp = "https://wa.me/" + telefonoCliente + "?text=" + encodeURIComponent(mensajeWhatsApp);
    document.getElementById('whatsappLink').setAttribute('href', urlWhatsApp);
}

$(document).ready(function() {
    $('#confirmPaymentButton').click(function() {
        procesarPago(globalPrestamoId, globalMontoPagado, globalTelefonoCliente);
    });
});

function procesarPago(prestamoId, montoPagado, telefonoCliente) {
    $.ajax({
        url: 'procesar_pago.php',
        type: 'POST',
        data: {
            prestamoId: prestamoId,
            montoPagado: montoPagado
        },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                $('#confirmPaymentModal').modal('hide');
                $('#postPaymentModal').modal('show');
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



    </script>


</body>



</html>