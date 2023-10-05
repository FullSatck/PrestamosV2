// Variables globales para llevar un registro del ID del cliente actual
var clienteActualId = 1; // Empieza con el primer cliente (puedes cambiarlo si deseas)

// Función para cargar los datos del cliente
function cargarDatosCliente(clienteId) {
    $.ajax({
        url: "consulta.php?clienteId=" + clienteId,
        dataType: "json",
        success: function(data) {
            // Rellenar los campos con los datos obtenidos
            $("#nombre").text(data.Nombre);
            $("#domicilio").text(data.Domicilio);
            $("#curp").text(data.IdentificacionCURP);
            $("#tel_cel").text(data.Telefono);
            $("#plazo").text(data.Plazo);
            $("#monto").text(data.Monto);
            $("#cuota").text(data.Cuota);
        },
        error: function() {
            alert("No hay más clientes que mostrar");
        }
    });
}

// Función para cambiar al cliente anterior
function cambiarClienteAnterior() {
    clienteActualId--; // Disminuir el ID en 1 (cambia al cliente anterior)
    cargarDatosCliente(clienteActualId);
}

// Función para cambiar al cliente siguiente
function cambiarClienteSiguiente() {
    clienteActualId++; // Aumentar el ID en 1 (cambia al cliente siguiente)
    cargarDatosCliente(clienteActualId);
}

// Llama a la función para cargar los datos del cliente inicial
cargarDatosCliente(clienteActualId);

// Manejar los eventos de los botones para cambiar de cliente
$("#fecha-izquierda").click(cambiarClienteAnterior);
$("#fecha-derecha").click(cambiarClienteSiguiente);

// Función para redireccionar al CRUD de clientes
function redireccionarCrudClientes() {
    // Cambia 'crud_clientes.html' por la URL de tu página de CRUD de clientes
    window.location.href = '/resources/views/admin/clientes/lista_clientes.php';
}

// Asocia la función al evento de clic en el botón "Menu"
$("#menu").click(redireccionarCrudClientes);

// Función para registrar un pago
function registrarPago() {
    var monto = parseFloat($("#pagar").val());
    var fechaPago = obtenerFechaActual();

    $.ajax({
        type: "POST",
        url: "registrar_pago.php",
        data: {
            clienteId: clienteActualId,
            monto: monto,
            fechaPago: fechaPago
        },
        success: function(response) {
            if (response.success) {
                alert("Pago registrado con éxito");
                // Actualiza el monto y el historial de pagos en la interfaz
                actualizarMontoCliente(response.nuevoMonto);
                actualizarHistorialPagos(response.historialPagos);
            } else {
                alert("Error al registrar el pago");
            }
        },
        error: function() {
            alert("Error al comunicarse con el servidor");
        }
    });
}

// Asocia la función al evento de clic en el botón "Registrar Pago"
$("#registrarPago").click(registrarPago);

// Función para obtener la fecha actual en formato deseado (dd/mm/yyyy hh:mm a)
function obtenerFechaActual() {
    var fecha = new Date();
    var dia = fecha.getDate().toString().padStart(2, '0');
    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Los meses son base 0
    var anio = fecha.getFullYear();
    var horas = fecha.getHours().toString().padStart(2, '0');
    var minutos = fecha.getMinutes().toString().padStart(2, '0');
    var ampm = horas >= 12 ? 'p.m.' : 'a.m.';
    horas = horas % 12;
    horas = horas ? horas : 12; // Las 12:00 p.m. y las 12:00 a.m. se muestran como 12:00
    var formatoFecha = dia + '/' + mes + '/' + anio + ' ' + horas + ':' + minutos + ' ' + ampm;
    return formatoFecha;
}

// Función para mostrar la fecha actual en el div en tiempo real
function mostrarFechaActualEnTiempoReal() {
    var fechaDiv = document.getElementById("fecha-actual");

    function actualizarFecha() {
        var fechaActual = obtenerFechaActual();
        fechaDiv.textContent = fechaActual;
    }

    // Actualizar la fecha cada segundo (1000 milisegundos)
    setInterval(actualizarFecha, 1000);

    // Llamar a la función inicialmente para mostrar la fecha inmediatamente
    actualizarFecha();
}

// Llama a la función para mostrar la fecha en tiempo real cuando se carga la página
mostrarFechaActualEnTiempoReal();
