// Obtener referencias a elementos HTML
const clienteIdElement = document.getElementById('cliente-id');
const clienteNombreElement = document.getElementById('cliente-nombre');
const clienteApellidoElement = document.getElementById('cliente-apellido');
const clienteDomicilioElement = document.getElementById('cliente-domicilio');
const clienteTelefonoElement = document.getElementById('cliente-telefono');
const clienteCurpElement = document.getElementById('cliente-curp');
const clienteZonaElement = document.getElementById('cliente-zona');

const prestamoIdElement = document.getElementById('prestamo-id');
const tasaInteresElement = document.getElementById('tasa-interes');
const fechaInicioElement = document.getElementById('fecha-inicio');
const fechaVencimientoElement = document.getElementById('fecha-vencimiento');
const prestamoZonaElement = document.getElementById('prestamo-zona');
const montoPagarElement = document.getElementById('monto-pagar');
const cuotaElement = document.getElementById('cuota');

// Función para cargar los datos del cliente y del préstamo
function cargarDatosCliente(clienteId) {
    // Realiza una solicitud AJAX para obtener los datos del cliente y del préstamo
    // Reemplaza la siguiente línea con tu código AJAX
    $.ajax({
        url: '/resources/views/admin/abonos/registrarP.php',
        method: 'GET',
        data: { clienteId },
        dataType: 'json',
        success: function(data) {
            // Llena los campos con los datos obtenidos
            clienteIdElement.textContent = data.ID;
            clienteNombreElement.textContent = data.Nombre;
            clienteApellidoElement.textContent = data.Apellido;
            clienteDomicilioElement.textContent = data.Domicilio;
            clienteTelefonoElement.textContent = data.Telefono;
            clienteCurpElement.textContent = data.IdentificacionCURP;
            clienteZonaElement.textContent = data.ZonaAsignada;

            prestamoIdElement.textContent = data.IDPrestamo;
            tasaInteresElement.textContent = data.TasaInteres;
            fechaInicioElement.textContent = data.FechaInicio;
            fechaVencimientoElement.textContent = data.FechaVencimiento;
            prestamoZonaElement.textContent = data.Zona;
            montoPagarElement.textContent = data.MontoAPagar;
            cuotaElement.textContent = data.Cuota;
        },
        error: function() {
            alert('Error al cargar los datos del cliente y préstamo.');
        }
    });
}

// Agrega un controlador de eventos para el formulario de pago
const formularioPago = document.getElementById('formulario-pago');
formularioPago.addEventListener('submit', function(event) {
    event.preventDefault();

    // Obten los valores del formulario
    const montoPago = document.getElementById('monto-pago').value;
    const fechaPago = document.getElementById('fecha-pago').value;

    // Realiza una solicitud AJAX para guardar el pago en la base de datos
    // Reemplaza la siguiente línea con tu código AJAX
    $.ajax({
        url: '/resources/views/admin/abonos/registrarP.php',
        method: 'POST',
        data: { montoPago, fechaPago },
        success: function() {
            alert('Pago registrado con éxito.');
            // Limpia el formulario después de guardar el pago
            formularioPago.reset();
        },
        error: function() {
            alert('Error al guardar el pago.');
        }
    });
});

// Agrega un controlador de eventos para el botón "Siguiente Cliente"
const siguienteClienteButton = document.getElementById('siguiente-cliente');
siguienteClienteButton.addEventListener('click', function() {
    // Avanzar al siguiente cliente (puedes implementar esta lógica)
    // Llama a la función cargarDatosCliente con el ID del siguiente cliente
    const siguienteClienteId = obtenerSiguienteClienteId(); // Implementa esta función
    cargarDatosCliente(siguienteClienteId);
});

// Inicialmente, carga los datos del primer cliente
cargarDatosCliente(1);
