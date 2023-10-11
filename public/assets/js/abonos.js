var clienteActualId = 1; // Empieza con el primer cliente (puedes cambiarlo si deseas)

// Función para cargar los datos del cliente
function cargarDatosCliente(clienteId) {
    $.ajax({
        url: "consulta.php?clienteId=" + clienteId,
        dataType: "json",
        success: function(data) {
            // Rellenar los campos con los datos obtenidos
            $("#cliente-id").text(data.ID);
            $("#cliente-nombre").text(data.Nombre);
            $("#cliente-apellido").text(data.Apellido);
            $("#cliente-domicilio").text(data.Domicilio);
            $("#cliente-telefono").text(data.Telefono);
            $("#cliente-curp").text(data.IdentificacionCURP);
            $("#cliente-zona").text(data.ZonaAsignada);

            $("#prestamo-id").text(data.IDPrestamo);
            $("#prestamo-tasa").text(data.TasaInteres);
            $("#prestamo-fecha-inicio").text(data.FechaInicio);
            $("#prestamo-fecha-vencimiento").text(data.FechaVencimiento);
            $("#prestamo-zona").text(data.Zona);
            $("#prestamo-monto-pagar").text(data.MontoAPagar);
            $("#prestamo-cuota").text(data.Cuota);
        },
        error: function() {
            alert("No hay más clientes que mostrar");
        }
    });
}

// Función para registrar el pago
// Variables globales para llevar un registro del ID del cliente actual
var clienteActualId = 1; // Empieza con el primer cliente (puedes cambiarlo si deseas)

// Variable para mantener un registro de si se ha ingresado la cantidad de pago
var cantidadPagoIngresada = false;

// Función para cargar los datos del cliente
function cargarDatosCliente(clienteId) {
    $.ajax({
        url: "consulta.php?clienteId=" + clienteId,
        dataType: "json",
        success: function(data) {
            // Rellenar los campos con los datos obtenidos
            $("#cliente-id").text(data.ID);
            $("#cliente-nombre").text(data.Nombre);
            $("#cliente-apellido").text(data.Apellido);
            $("#cliente-domicilio").text(data.Domicilio);
            $("#cliente-telefono").text(data.Telefono);
            $("#cliente-curp").text(data.IdentificacionCURP);
            $("#cliente-zona").text(data.ZonaAsignada);

            $("#prestamo-id").text(data.IDPrestamo);
            $("#prestamo-tasa").text(data.TasaInteres);
            $("#prestamo-fecha-inicio").text(data.FechaInicio);
            $("#prestamo-fecha-vencimiento").text(data.FechaVencimiento);
            $("#prestamo-zona").text(data.Zona);
            $("#prestamo-monto-pagar").text(data.MontoAPagar);
            $("#prestamo-cuota").text(data.Cuota);
        },
        error: function() {
            alert("No hay más clientes que mostrar");
        }
    });
}

// Función para registrar el pago
function registrarPago() {
    if (cantidadPagoIngresada) {
        var cantidadPago = $("#cantidad-pago").val();
        var fechaPago = $("#fecha-pago").val();
        $.ajax({
            url: "registrar_pago.php",
            method: "POST",
            data: {
                clienteId: $("#cliente-id").text(),
                cantidadPago: cantidadPago,
                fechaPago: fechaPago
            },
            success: function(response) {
                // Actualiza el monto a pagar en la página
                $("#prestamo-monto-pagar").text(response);

                // Limpiar los campos de cantidad de pago
                $("#cantidad-pago").val("");
                // Cierra el modal de confirmación
                $("#confirmarPagoModal").modal("hide");
                // Abre el modal de pago confirmado
                $("#pagoConfirmadoModal").modal("show");

                // Cambia automáticamente al siguiente cliente después de 2 segundos
                setTimeout(function() {
                    cambiarCliente(1);
                }, 4000);
            },
            error: function() {
                alert("Error al registrar el pago");
            }
        });
    } else {
        alert("Por favor, ingrese la cantidad de pago antes de registrarlo.");
    }
}

// Función para cambiar al cliente anterior o siguiente
function cambiarCliente(delta) {
    clienteActualId += delta;
    cargarDatosCliente(clienteActualId);
}

// Llama a la función para cargar los datos del cliente actual al cargar la página
cargarDatosCliente(clienteActualId);

// Asocia el evento click del botón "Registrar Pago" a la función que muestra el modal de confirmación
$("#registrarPago").click(function() {
    // Verifica si se ha ingresado una cantidad de pago
    if ($("#cantidad-pago").val() !== "") {
        cantidadPagoIngresada = true;
        // Abre el modal de confirmación
        $("#confirmarPagoModal").modal("show");
    } else {
        alert("Por favor, ingrese la cantidad de pago antes de registrarlo.");
    }
});

// Asocia el evento click del botón "Confirmar" en el modal de confirmación a la función para registrar el pago
$("#confirmarPago").click(function() {
    registrarPago(); // Registra el pago
});

// Agregar un controlador de eventos al botón "Generar Factura"
$("#generarFacturaBtn").click(function() {
    // Obtener el ID del cliente y el monto del pago
    var clienteId = $("#cliente-id").text();
    var cantidadPago = $("#cantidad-pago").val();

    // Redirigir a la página de generación de factura con los parámetros en la URL
    window.location.href = "generar_factura.php?clienteId=" + clienteId + "&monto=" + cantidadPago;
});


// Asocia el evento clic a los botones de navegación
$("#anteriorCliente").click(function() {
    cambiarCliente(-1); // Cambiar al cliente anterior
});

$("#siguienteCliente").click(function() {
    cambiarCliente(1); // Cambiar al siguiente cliente
});