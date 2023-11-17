
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



// <!-- Script para manejar la lógica del modal y el pago -->

var globalPrestamoId = 0;
var globalMontoCuota = 0;

function setPrestamoId(prestamoId, montoCuota) {
    globalPrestamoId = prestamoId;
    globalMontoCuota = montoCuota;
}

$(document).ready(function() {
    $('#confirmPaymentButton').click(function() {
        procesarPago(globalPrestamoId, globalMontoCuota);
    });
});

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

function posponerPago(prestamoId) {
    $.ajax({
        url: 'posponer_pago.php', // Asegúrate de que esta URL es correcta
        type: 'POST',
        data: {
            prestamoId: prestamoId
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Mostrar el modal de pago pospuesto
                $('#postponePaymentModal').modal('show');
                actualizarTablaPrestamos(); // Actualizar la tabla
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
$(document).ready(function() {
    // Evento al cerrar el modal de WhatsApp
    $('#whatsappModal').on('hidden.bs.modal', function() {
        location.reload(); // Recargar la página
    });

    // Evento al cerrar el modal de Pago Pospuesto
    $('#postponePaymentModal').on('hidden.bs.modal', function() {
        location.reload(); // Recargar la página
    });
});

// Función para abrir el modal de pago personalizado
function abrirModalPago(prestamoId, montoCuota) {
    globalPrestamoId = prestamoId;
    globalMontoCuota = montoCuota;
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